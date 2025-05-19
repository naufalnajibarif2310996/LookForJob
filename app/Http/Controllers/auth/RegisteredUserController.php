<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\RegisterResponse;

class RegisteredUserController
{
    public function store(Request $request, CreateNewUser $creator, RegisterResponse $response)
    {
        // Validasi dan buat user (tanpa Auth::login)
        $creator->create($request->all());

        // Redirect ke login (sesuai RegisterResponse custom-mu)
        return $response->toResponse($request);
    }
}