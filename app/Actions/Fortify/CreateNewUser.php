<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

// class CreateNewUser implements CreatesNewUsers
// {
//     use PasswordValidationRules;

//     /**
//      * Validate and create a newly registered user.
//      *
//      * @param  array<string, string>  $input
//      */
//     public function create(array $input): User
//     {
//         Validator::make($input, [
//             'name' => ['required', 'string', 'max:255'],
//             'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//             'password' => $this->passwordRules(),
//             'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
//         ])->validate();

//         return User::create([
//             'name' => $input['name'],
//             'email' => $input['email'],
//             'password' => Hash::make($input['password']),
//         ]);
//     }
// }
use App\Services\FirebaseService;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Create in Firebase
        $firebaseUser = $this->firebase->createUser(
            $input['email'],
            $input['password'],
            $input['name']
        );

        // Optional: Save Firebase UID locally
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'firebase_uid' => $firebaseUser->uid,
            'password' => Hash::make($input['password']), // You can still store hash locally if needed
        ]);
    }
}
