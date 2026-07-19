<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    public function getTitle(): string | Htmlable
    {
        $role = Filament::auth()->user()?->role;
        $roleLabel = match ($role) {
            'admin' => 'Admin',
            'mentor' => 'Mentor',
            'coach' => 'Coach',
            default => 'User',
        };

        return 'Dashboard ' . $roleLabel;
    }
}
