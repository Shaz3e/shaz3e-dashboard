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

    public $perPage = 10;

    public $id, $name, $email, $password;

    // record to delete
    public $recordToDelete;

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

        $users = $query->orderBy('id', 'desc')->paginate($this->perPage);

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
     * Update perPage records
     */
    public function updatedPerPage()
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
        $this->dispatch('created');
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
            $this->dispatch('not-found');
        } else {
            $this->id = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = '';
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
        $this->dispatch('updated');
    }

    /**
     * Delete Record
     */
    public function delete($id)
    {
        // get id
        $user = User::find($id);

        // Check record exists
        if(!$user){
            session()->flash('error', 'User not found!');
            $this->dispatch('hideDeleteConfirmation');
            return;
        }else{
            // Delete record
            $user->delete();

            // Show a success message
            session()->flash('success', 'User deleted successfully!');

            // dispatch browser event
            $this->dispatch('deleted');

            // refresh the records table
            $this->render();
        }
    }

    /**
     * Confirm Delete
     */
    public function confirmDelete($id)
    {
        $this->recordToDelete = $id;
        $this->dispatch('showDeleteConfirmation');
    }

    /**
     * Cancel delete action
     */
    public function cancelDelete()
    {
        $this->dispatch('hideDeleteConfirmation');
    }
}
