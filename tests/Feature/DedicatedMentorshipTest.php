<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Course;
use App\Models\MentorAvailabilitySlot;
use App\Models\MentoringBooking;
use App\Models\MentoringEntitlement;
use App\Models\MentoringRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DedicatedMentorshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_dedicated_mentorship_full_lifecycle(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $mentorA = User::factory()->create(['role' => 'mentor', 'is_approved' => true, 'name' => 'Mentor Alpha']);
        $mentorB = User::factory()->create(['role' => 'mentor', 'is_approved' => true, 'name' => 'Mentor Beta']);
        $category = Category::create(['name' => 'Haircut', 'slug' => 'haircut']);

        $course1 = Course::create([
            'name' => 'Basic Haircut',
            'slug' => 'basic-haircut',
            'price' => 150000,
            'category_id' => $category->id,
            'user_id' => $mentorA->id,
            'is_published' => true,
        ]);

        $transaction1 = Transaction::create([
            'user_id' => $student->id,
            'course_id' => $course1->id,
            'price' => 150000,
            'status' => 'PAID',
            'payment_method' => 'manual_midtrans',
            'paid_at' => now(),
        ]);

        $entitlement1 = MentoringEntitlement::create([
            'transaction_id' => $transaction1->id,
            'student_id' => $student->id,
            'course_id' => $course1->id,
            'total_quota' => 2,
            'used_quota' => 0,
            'status' => 'active',
            'granted_at' => now(),
        ]);

        // 1. Student applies to Mentor A
        $this->actingAs($student);
        $response = $this->post(route('mentoring.apply', ['entitlement' => $entitlement1->id]), [
            'mentor_id' => $mentorA->id,
            'student_notes' => 'Halo Mentor A, ingin konsultasi teknik gunting layer.',
        ]);
        $response->assertRedirect(route('mentoring.index'));

        $this->assertDatabaseHas('mentoring_requests', [
            'student_id' => $student->id,
            'mentor_id' => $mentorA->id,
            'status' => MentoringRequest::STATUS_PENDING,
        ]);

        $request = MentoringRequest::where('student_id', $student->id)->first();

        // 2. Mentor approves student
        $request->update([
            'status' => MentoringRequest::STATUS_APPROVED,
            'reviewed_at' => now(),
        ]);

        $this->assertTrue($student->fresh()->activeMentorship()->exists());
        $this->assertEquals($mentorA->id, $student->fresh()->activeMentorship->mentor_id);

        // 3. Student purchases Course 2 (new entitlement) -> auto bypasses mentor selection
        $course2 = Course::create([
            'name' => 'Advanced Coloring',
            'slug' => 'advanced-coloring',
            'price' => 250000,
            'category_id' => $category->id,
            'user_id' => $mentorB->id,
            'is_published' => true,
        ]);

        $transaction2 = Transaction::create([
            'user_id' => $student->id,
            'course_id' => $course2->id,
            'price' => 250000,
            'status' => 'PAID',
            'payment_method' => 'manual_midtrans',
            'paid_at' => now(),
        ]);

        $entitlement2 = MentoringEntitlement::create([
            'transaction_id' => $transaction2->id,
            'student_id' => $student->id,
            'course_id' => $course2->id,
            'total_quota' => 2,
            'used_quota' => 0,
            'status' => 'active',
            'granted_at' => now(),
        ]);

        // Accessing booking route directly without parameter (/mentoring/book) works seamlessly
        $responseNoParam = $this->get(route('mentoring.book'));
        $responseNoParam->assertStatus(200);
        $responseNoParam->assertSee('Mentor Alpha');

        // Accessing booking route with specific entitlement (/mentoring/{entitlement}/book) also works seamlessly
        $response = $this->get(route('mentoring.book.entitlement', ['entitlement' => $entitlement2->id]));
        $response->assertStatus(200);
        $response->assertSee('Mentor Alpha');

        // Create slot for Mentor A and book
        $slot = MentorAvailabilitySlot::create([
            'mentor_id' => $mentorA->id,
            'starts_at' => now()->addDays(5)->setTime(14, 0),
            'ends_at' => now()->addDays(5)->setTime(15, 0),
            'status' => MentorAvailabilitySlot::STATUS_AVAILABLE,
        ]);

        $bookResponse = $this->post(route('mentoring.store', ['entitlement' => $entitlement2->id]), [
            'slot_id' => $slot->id,
        ]);
        $bookResponse->assertRedirect(route('mentoring.index'));

        $this->assertEquals(1, $entitlement2->fresh()->used_quota);
        // Mentorship relationship remains APPROVED (not completed)
        $this->assertEquals(MentoringRequest::STATUS_APPROVED, $request->fresh()->status);

        // 4. Student terminates mentorship relationship with reason
        $terminateResponse = $this->post(route('mentoring.terminate'), [
            'termination_reason' => 'Ingin beralih ke mentor spesialis pewarnaan rambut.',
        ]);
        $terminateResponse->assertRedirect(route('mentoring.mentors'));

        $this->assertEquals(MentoringRequest::STATUS_TERMINATED, $request->fresh()->status);
        $this->assertEquals('Ingin beralih ke mentor spesialis pewarnaan rambut.', $request->fresh()->termination_reason);
        $this->assertEquals('student', $request->fresh()->terminated_by);
        $this->assertNotNull($request->fresh()->terminated_at);

        // Student now has no active mentorship and can choose Mentor B
        $this->assertNull($student->fresh()->activeMentorship);

        $applyMentorBResponse = $this->post(route('mentoring.apply', ['entitlement' => $entitlement1->id]), [
            'mentor_id' => $mentorB->id,
            'student_notes' => 'Halo Mentor B, ingin bimbingan pewarnaan rambut.',
        ]);
        $applyMentorBResponse->assertRedirect(route('mentoring.index'));

        $this->assertDatabaseHas('mentoring_requests', [
            'student_id' => $student->id,
            'mentor_id' => $mentorB->id,
            'status' => MentoringRequest::STATUS_PENDING,
        ]);
    }
}
