<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseService
{
    protected Auth $auth;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(storage_path('app/firebase/firebase_credentials.json'));
        $this->auth = $factory->createAuth();
    }

    public function createUser(string $email, string $password, string $displayName)
    {
        return $this->auth->createUser([
            'email' => $email,
            'emailVerified' => false,
            'password' => $password,
            'displayName' => $displayName,
            'disabled' => false,
        ]);
    }
}
