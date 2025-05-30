<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class AdminLogin extends Component
{
    public $email, $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post(config('app.url').'/api/login', [
            'email' => $this->email,
            'password' => $this->password,
            'user_type' => 'admin',
        ]);

        if ($response->successful()) {
            session(['api_token' => $response->json('token')]);
            return redirect()->route('admin.dashboard');
        } else {
            session()->flash('error', 'Invalid admin credentials');
        }
    }

    public function render()
    {
        return view('livewire.admin-login');
    }
}
