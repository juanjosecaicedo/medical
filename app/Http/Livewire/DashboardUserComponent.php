<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rules;

class DashboardUserComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $name;
    public $email;
    public $status;
    public $password;
    public $password_confirmation;
    public $search;
    public $userId;
    public $perPage = 25;

    /**
     * @var string
     */
    public $actionName = 'save';


    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'status' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ];
    }

    public function render()
    {
        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.dashboard-user-component', compact('users'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function register()
    {
        $this->resetForm();
        $this->emit('display-user-modal', ['show' => true]);
    }

    public function edit(int $id)
    {
        $this->actionName = 'update';
        $this->userId = $id;
        //$user = User::where('id', $id)->first();
        $user = User::find($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->status = $user->status;
        $this->emit('display-user-modal', ['show' => true]);
    }

    /**
     * @return void
     */
    public function setAction()
    {
        $this->actionName === 'save' ? $this->stores() : $this->update();
    }

    private function stores()
    {
        $this->validate();
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'password' => Hash::make($this->password),
        ]);
        event(new Registered($user));
        $this->resetForm();
        session()->flash('message', 'User successfully created.');
    }

    private function update()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'status' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);
        /**
         * @var $user User
         */
        $user = User::find($this->userId);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->status = $this->status;
        $user->password = $this->password;
        $user->save();

        $this->resetForm();
        session()->flash('message', 'User successfully updated.');
    }

    private function resetForm()
    {
        $this->status = null;
        $this->actionName = 'save';
        $this->reset('name', 'email', 'password', 'password_confirmation');
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message-deleted', 'User successfully deleted.');
    }
}
