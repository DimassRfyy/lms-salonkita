<?php

namespace Tests\Feature;

use App\Models\MentorAvailabilitySlot;
use App\Models\MentorAvailabilityTemplate;
use App\Models\User;
use App\Support\Mentoring\MentorAvailabilitySlotGenerator;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentorTemplateSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_template_sync_replaces_unbooked_slots_and_preserves_booked_slots(): void
    {
        $mentor = User::factory()->create([
            'role' => 'mentor',
        ]);

        // 1. Template: Every Monday (day 1) 10:00 - 11:00
        $template = MentorAvailabilityTemplate::create([
            'mentor_id' => $mentor->id,
            'day_of_week' => 1,
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'is_active' => true,
        ]);

        $generator = app(MentorAvailabilitySlotGenerator::class);
        $created = $generator->generateForTemplate($template, 30);
        $this->assertGreaterThan(0, $created);

        // Find created slots
        $initialSlots = MentorAvailabilitySlot::where('mentor_availability_template_id', $template->id)->get();
        $this->assertNotEmpty($initialSlots);

        // Simulate 1 slot being booked by a student
        $bookedSlot = $initialSlots->first();
        $bookedSlot->update(['status' => MentorAvailabilitySlot::STATUS_BOOKED]);

        $originalBookedStartsAt = $bookedSlot->starts_at->toDateTimeString();

        // 2. Mentor changes template to 08:00 - 09:00
        $template->update([
            'start_time' => '08:00:00',
            'end_time' => '09:00:00',
        ]);

        // Sync template
        $result = $generator->syncTemplateSlots($template, 30);

        $this->assertEquals(1, $result['booked_retained']);
        $this->assertGreaterThan(0, $result['deleted_unbooked']);
        $this->assertGreaterThan(0, $result['new_created']);

        // Check booked slot is still in DB with same time and status
        $bookedSlotRefreshed = MentorAvailabilitySlot::find($bookedSlot->id);
        $this->assertNotNull($bookedSlotRefreshed);
        $this->assertEquals(MentorAvailabilitySlot::STATUS_BOOKED, $bookedSlotRefreshed->status);
        $this->assertEquals($originalBookedStartsAt, $bookedSlotRefreshed->starts_at->toDateTimeString());

        // Check that there are no unbooked available slots with 10:00
        $oldUnbookedSlots = MentorAvailabilitySlot::where('mentor_id', $mentor->id)
            ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
            ->whereTime('starts_at', '10:00:00')
            ->count();
        $this->assertEquals(0, $oldUnbookedSlots);

        // Check that new available slots exist with 08:00
        $newAvailableSlots = MentorAvailabilitySlot::where('mentor_id', $mentor->id)
            ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
            ->whereTime('starts_at', '08:00:00')
            ->count();
        $this->assertGreaterThan(0, $newAvailableSlots);
    }

    public function test_template_deletion_cleans_up_unbooked_future_slots_only(): void
    {
        $mentor = User::factory()->create([
            'role' => 'mentor',
        ]);

        $template = MentorAvailabilityTemplate::create([
            'mentor_id' => $mentor->id,
            'day_of_week' => 2,
            'start_time' => '14:00:00',
            'end_time' => '15:00:00',
            'is_active' => true,
        ]);

        $generator = app(MentorAvailabilitySlotGenerator::class);
        $generator->generateForTemplate($template, 30);

        $slots = MentorAvailabilitySlot::where('mentor_availability_template_id', $template->id)->get();

        // 1 slot booked
        $bookedSlot = $slots->first();
        $bookedSlot->update(['status' => MentorAvailabilitySlot::STATUS_BOOKED]);

        $deletedCount = $generator->cleanupTemplateSlotsOnDelete($template->id);
        $this->assertGreaterThan(0, $deletedCount);

        // Booked slot remains
        $this->assertDatabaseHas('mentor_availability_slots', [
            'id' => $bookedSlot->id,
            'status' => MentorAvailabilitySlot::STATUS_BOOKED,
        ]);

        // Unbooked available slots are removed
        $remainingAvailable = MentorAvailabilitySlot::where('mentor_availability_template_id', $template->id)
            ->where('status', MentorAvailabilitySlot::STATUS_AVAILABLE)
            ->count();
        $this->assertEquals(0, $remainingAvailable);
    }
}
