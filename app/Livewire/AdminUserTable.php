<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;


class AdminUserTable extends Component
{

    public function render()
    {
        $users = User::where('user_type', 'user')->latest()->paginate(3);
        return view('livewire.admin-user-table', compact('users'));
    }
}
