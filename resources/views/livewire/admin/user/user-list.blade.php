<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Users</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                        <li class="breadcrumb-item active">Starter page</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <x-alert-message />

    <div class="row">
        <div class="col-12">
            <div class="row d-flex align-items-center mb-2">
                <div class="col-md-3 col-sm-12">
                    <form class="app-search">
                        <div class="position-relative">
                            <input type="search" wire:model.live="search" class="form-control form-control-sm"
                                placeholder="Search Users">
                            <span class="ri-search-line"></span>
                        </div>
                    </form>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button wire:click="create" type="button"
                            class="btn btn-success btn-sm waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#createModal">Create</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- .col --}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0">
                            <table id="tech-companies-1" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr wire:key="{{ $user->id }}">
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>

                                                <div class="dropdown mt-4 mt-sm-0">
                                                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>

                                                    <div class="dropdown-menu">
                                                        <button wire:click="edit({{ $user->id }})"
                                                            class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#updateModal">
                                                            Edit
                                                        </button>
                                                        <button wire:click="confirmDelete({{ $user->id }})" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal">
                                                            Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $users->links() }}

                    </div>
                    {{-- /.table-class --}}
                </div>
                {{-- .card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    @include('livewire.admin.user.create')
    @include('livewire.admin.user.edit')
    @include('livewire.admin.user.delete')
</div>

@push('styles')
@endpush

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            // close modal when user created
            Livewire.on('user-created', (event) => {
                $('#createModal').modal('hide');
            });
            // close modal when user updated
            Livewire.on('user-updated', (event) => {
                $('#updateModal').modal('hide');
            });
            // close mdal when user not found
            Livewire.on('user-not-found', (event) => {
                $('#createModal').modal('hide');
                $('#updateModal').modal('hide');
            });
            // close modal when user is delete
            Livewire.on('user-deleted', (event) => {
                $('#deleteModal').modal('hide');
            });
            // show confirm modal
            Livewire.on('showDeleteConfirmation', (event) => {
                $('#deleteModal').modal('show');
            });
            // show cancel deletion action modal
            Livewire.on('hideDeleteConfirmation', (event) => {
                $('#deleteModal').modal('hide');
            });
        });
    </script>
@endpush
