<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardUserIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $users = User::paginate(3);
        return view('livewire.dashboard-user-index', compact('users'));
    }
}
