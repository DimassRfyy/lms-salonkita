<?php

namespace Tests\Feature;

use App\Livewire\MentoringBookingSlotPicker;
use App\Models\Category;
use App\Models\Course;
use App\Models\MentorAvailabilitySlot;
use App\Models\MentoringBooking;
use App\Models\MentoringEntitlement;
use App\Models\MentoringRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MentoringBookingSlotPickerTest extends TestCase
{
    use RefreshDatabase;

    public function test_slot_picker_shows_dates_beyond_14_days_and_allows_instant_selection(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $mentor = User::factory()->create(['role' => 'mentor', 'is_approved' => true]);
        $category = Category::create(['name' => 'Haircut', 'slug' => 'haircut']);
        $course = Course::create([
            'name' => 'Haircut Course',
            'slug' => 'haircut-course',
            'price' => 200000,
            'category_id' => $category->id,
            'user_id' => $mentor->id,
            'is_published' => true,
        ]);

        $transaction = \App\Models\Transaction::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'price' => 200000,
            'status' => 'PAID',
            'payment_method' => 'manual_midtrans',
            'paid_at' => now(),
        ]);

        $entitlement = MentoringEntitlement::create([
            'transaction_id' => $transaction->id,
            'student_id' => $student->id,
            'course_id' => $course->id,
            'total_quota' => 3,
            'used_quota' => 0,
            'status' => 'active',
            'granted_at' => now(),
        ]);

        $request = MentoringRequest::create([
            'mentoring_entitlement_id' => $entitlement->id,
            'student_id' => $student->id,
            'mentor_id' => $mentor->id,
            'course_id' => $course->id,
            'status' => MentoringRequest::STATUS_APPROVED,
        ]);

        // Create slot 25 days in the future (beyond 14 days limit of old code)
        $futureDate = now()->addDays(25)->startOfDay()->addHours(10);
        $slotFarAhead = MentorAvailabilitySlot::create([
            'mentor_id' => $mentor->id,
            'starts_at' => $futureDate,
            'ends_at' => $futureDate->copy()->addHour(),
            'status' => MentorAvailabilitySlot::STATUS_AVAILABLE,
        ]);

        // Test Livewire component
        $this->actingAs($student);

        Livewire::test(MentoringBookingSlotPicker::class, [
            'entitlement' => $entitlement,
            'mentor' => $mentor,
        ])
        ->assertSee($futureDate->format('d'))
        ->set('selectedDate', $futureDate->toDateString())
        ->assertSee('10:00 - 11:00 WIB')
        ->call('confirmSlot', $slotFarAhead->id)
        ->assertSet('showConfirmModal', true)
        ->assertSet('selectedSlotId', $slotFarAhead->id)
        ->call('executeBooking')
        ->assertRedirect(route('mentoring.index'));

        // Assert booking is created
        $this->assertDatabaseHas('mentoring_bookings', [
            'student_id' => $student->id,
            'mentor_id' => $mentor->id,
            'mentor_availability_slot_id' => $slotFarAhead->id,
            'status' => MentoringBooking::STATUS_CONFIRMED,
        ]);

        // Assert slot is marked as booked
        $this->assertEquals(MentorAvailabilitySlot::STATUS_BOOKED, $slotFarAhead->fresh()->status);

        // Assert used_quota incremented
        $this->assertEquals(1, $entitlement->fresh()->used_quota);

        // Assert request marked completed
        $this->assertEquals(MentoringRequest::STATUS_COMPLETED, $request->fresh()->status);
    }
}
