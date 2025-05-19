<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        // Redirect ke login setelah register
        return redirect()->route('login')->with('status', 'Register berhasil! Silakan login.');
    }
}