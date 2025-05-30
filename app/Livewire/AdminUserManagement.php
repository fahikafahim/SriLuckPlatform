<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
class AdminUserManagement extends Component
{
     public $users;

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::where('user_type', 'user')->latest()->get();

    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('message', 'User deleted successfully.');
        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.admin-user-management');
    }
}
