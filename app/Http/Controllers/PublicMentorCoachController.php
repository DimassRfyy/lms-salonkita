<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PublicMentorCoachController extends Controller
{
    /**
     * Tampilkan daftar mentor atau coach dalam 1 halaman dengan modal detail.
     */
    public function index(Request $request)
    {
        // Tentukan role berdasarkan route name atau query param
        $role = $request->routeIs('coaches.*') || $request->query('role') === 'coach' ? 'coach' : 'mentor';
        $search = trim((string) $request->query('search', ''));

        $users = User::query()
            ->where('role', $role)
            ->where('is_approved', true)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('job_title', 'like', '%' . $search . '%')
                        ->orWhere('bio', 'like', '%' . $search . '%')
                        ->orWhere('city', 'like', '%' . $search . '%');
                });
            })
            ->withCount([
                'courses' => fn ($q) => $q->where('is_published', true),
                'activeMentees as mentees_count',
            ])
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('pages.mentor_coach.index', compact('users', 'role', 'search'));
    }
}
