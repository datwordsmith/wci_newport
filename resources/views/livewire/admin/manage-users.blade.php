<div>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Manage Users</h1>
                        <p class="text-muted mb-0">Add, edit, or remove user accounts and manage their roles</p>
                    </div>
                    <div>
                        <button wire:click="create" class="btn btn-primary-custom">
                            <i class="fas fa-user-plus me-2"></i>Add New User
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="searchInput" class="form-label fw-semibold">Search Users</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text"
                                           wire:model.live.debounce.300ms="search"
                                           class="form-control"
                                           id="searchInput"
                                           placeholder="Search by name or email...">
                                    @if($search)
                                        <button class="btn btn-outline-secondary" wire:click="$set('search', '')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="roleFilter" class="form-label fw-semibold">Filter by Role</label>
                                <select wire:model.live="roleFilter" id="roleFilter" class="form-select">
                                    <option value="all">All Roles</option>
                                    @foreach($this->roles as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="row">
            <div class="col-12">
                <div class="card p-3">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="col-3">Name</th>
                                    <th class="col-4">Email</th>
                                    <th class="col-2">Role</th>
                                    <th class="col-2">Created</th>
                                    <th class="col-1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {{-- <div class="avatar-circle me-2">
                                                    {{ strtoupper(substr($user->firstname, 0, 1) . substr($user->surname, 0, 1)) }}
                                                </div> --}}
                                                <div>
                                                    <div class="fw-semibold">{{ $user->firstname }} {{ $user->surname }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role === 'administrator')
                                                <span class="badge bg-danger">Administrator</span>
                                            @elseif($user->role === 'editor')
                                                <span class="badge bg-primary">Editor</span>
                                            @else
                                                <span class="badge bg-info">Moderator</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('M j, Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button wire:click="edit({{ $user->id }})"
                                                        class="btn btn-sm btn-warning text-white"
                                                        title="Edit user">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $user->id }})"
                                                        class="btn btn-sm btn-danger"
                                                        title="Delete user">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-users fa-2x mb-3"></i>
                                                <p class="mb-0">No users found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($users->hasPages())
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                                </div>
                                <div>
                                    {{ $users->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- User Modal -->
    @if($showModal)
        <div class="modal fade show d-block admin-modal-backdrop" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-user-{{ $editMode ? 'edit' : 'plus' }} me-2"></i>
                            {{ $editMode ? 'Edit User' : 'Add New User' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text"
                                       wire:model="firstname"
                                       class="form-control @error('firstname') is-invalid @enderror"
                                       id="firstname">
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="surname" class="form-label">Surname</label>
                                <input type="text"
                                       wire:model="surname"
                                       class="form-control @error('surname') is-invalid @enderror"
                                       id="surname">
                                @error('surname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                       wire:model="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="role" class="form-label">Role</label>
                                <select wire:model="role"
                                        class="form-select @error('role') is-invalid @enderror"
                                        id="role">
                                    <option value="">Select a role</option>
                                    @foreach($this->roles as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">
                                    Password
                                    @if($editMode)
                                        <small class="text-muted">(leave blank to keep current password)</small>
                                    @endif
                                </label>
                                <input type="password"
                                       wire:model="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                        <button type="button" class="btn btn-primary-custom" wire:click="save">
                            <i class="fas fa-save me-1"></i>
                            {{ $editMode ? 'Update User' : 'Create User' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('confirm-user-deletion', (event) => {
                if (confirm(`Are you sure you want to delete ${event[0].name}?`)) {
                    @this.delete(event[0].user_id);
                }
            });
        });
    </script>
    @endpush
</div>
