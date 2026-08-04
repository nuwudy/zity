<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LoginResponse as Responsable;
use Illuminate\Http\RedirectResponse;
use Filament\Facades\Filament;

class LoginResponse implements Responsable
{
    public function toResponse($request)
    {
        $user = Filament::auth()->user();

        // If user is a Master Admin, follow default redirect to dashboard
        if ($user && method_exists($user, 'isMasterAdmin') && $user->isMasterAdmin()) {
            return redirect()->to(Filament::getHomeUrl());
        }

        // If user owns a business, redirect to the shop's public page
        if ($user && $user->business) {
            return redirect()->to($user->business->getUrl());
        }

        return redirect()->to(Filament::getHomeUrl());
    }
}
