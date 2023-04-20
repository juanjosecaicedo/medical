<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardUserIndex extends Component
{
    use WithPagination;

    public $search;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->paginate(3);
        return view('livewire.dashboard-user-index', compact('users'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


}
