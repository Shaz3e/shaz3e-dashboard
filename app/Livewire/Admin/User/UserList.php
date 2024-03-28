<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

    public $id, $name, $email, $password;

    public $showCreateModal = false;

    /**
     * Main Blade Render
     */
    public function render()
    {
        $query = User::query();

        // Get all columns in the users table
        $columns = Schema::getColumnListing('users');

        // Filter users based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        $users = $query->orderBy('id', 'desc')->paginate(10);

        return view('livewire.admin.user.user-list', [
            'users' => $users
        ]);
    }

    /**
     * Reset Search
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Create Modal and Reset form and validations
     */
    public function create()
    {
        $this->resetValidation();
        $this->reset();
    }

    /**
     * Save Record
     */
    public function save()
    {
        // Validate data
        $validated = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:' . User::class,
            'password' => 'required|min:8|max:255',
        ]);

        User::create($validated);

        // Reset Form
        $this->reset();

        // Show success message
        session()->flash('success', 'User created successfully!');

        // Dipatch browser event
        $this->dispatch('user-created');
    }

    /**
     * Edi Model
     */
    public function edit($id)
    {
        $this->id = $id;
        $user = User::find($id);
        if (!$user) {
            session()->flash('error', 'User not found!');
            // Dispatch browser event to close modal
            $this->dispatch('user-not-found');
        } else {
            $this->id = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = $user->password;
        }
    }

    /**
     * Update Record
     */
    public function update()
    {
        // Validate data
        $validated = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:' . User::class . ',email,' . $this->id,
            'password' => 'nullable|min:8|max:255',
        ]);

        // If password is not provided, remove it from the validated data
        $emptyValidated = empty($validated['password']);
        if ($emptyValidated) {
            unset($validated['password']);
        }

        // Save the user
        $user = User::find($this->id);
        $user->update($validated);

        // Reset Form
        $this->reset();

        // Show a success message
        session()->flash('success', 'User updated successfully!');

        // Dispatch browser event to close modal
        $this->dispatch('user-updated');
    }
}
