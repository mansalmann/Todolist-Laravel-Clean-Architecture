<?php

namespace App\Services\Impl{
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

    class UserServiceImpl implements UserService{
        // data user
        
        function login(string $email, string $password):bool{
            // mencoba login dengan informasi kredensial yang diberikan
            return Auth::attempt([
                "email" => $email,
                "password" => $password
            ],true); 
        }
    }
}