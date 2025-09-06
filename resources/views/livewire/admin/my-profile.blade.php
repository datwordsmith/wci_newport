<div>
    <div class="container-fluid py-4">
        <!-- Alerts (Bootstrap, no custom JS) -->
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">My Profile</h1>
                        <p class="text-muted mb-0">Manage your account information and security settings</p>
                    </div>
                    <div class="text-muted">
                        <i class="fas fa-user-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Profile Summary -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Account Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="user-avatar-large mb-3">
                                {{ strtoupper(string: substr(auth()->user()->firstname ?? 'U', 0, 1) . substr(auth()->user()->surname ?? 'U', 0, 1)) }}
                            </div>
                            <h6 class="mb-1">{{ auth()->user()->firstname }} {{ auth()->user()->surname }}</h6>
                            <span class="badge bg-{{ auth()->user()->role === 'administrator' ? 'danger' : (auth()->user()->role === 'editor' ? 'primary-custom' : 'info') }}">
                                {{ auth()->user()->role === 'super_admin' ? 'Super Administrator' : ucfirst(auth()->user()->role) }}
                            </span>
                        </div>

                        <div class="border-top pt-3">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="small text-muted">Member Since</div>
                                    <div class="fw-semibold">{{ auth()->user()->created_at->format('M Y') }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="small text-muted">Last Updated</div>
                                    <div class="fw-semibold">{{ auth()->user()->updated_at->format('M j, Y') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="border-top pt-3 mt-3">
                            <h6 class="text-muted mb-2">Security Tips</h6>
                            <ul class="small text-muted mb-0">
                                <li>Use a strong, unique password</li>
                                <li>Never share your login credentials</li>
                                <li>Log out when using shared computers</li>
                                <li>Keep your profile information up to date</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>Profile Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firstname" class="form-label fw-semibold">First Name</label>
                                <input type="text"
                                       wire:model="firstname"
                                       class="form-control @error('firstname') is-invalid @enderror"
                                       id="firstname">
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="surname" class="form-label fw-semibold">Surname</label>
                                <input type="text"
                                       wire:model="surname"
                                       class="form-control @error('surname') is-invalid @enderror"
                                       id="surname">
                                @error('surname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="text" class="form-control-plaintext" value="{{ auth()->user()->email }}" readonly>
                                <small class="text-muted">Email is managed by administrators and cannot be changed.</small>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button"
                                    wire:click="updateProfile"
                                    wire:loading.attr="disabled"
                                    wire:target="updateProfile"
                                    class="btn btn-primary-custom">
                                <span wire:loading wire:target="updateProfile">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    Saving...
                                </span>
                                <span wire:loading.remove wire:target="updateProfile">
                                    <i class="fas fa-save me-2"></i>Update Profile
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-lock me-2"></i>Password & Security
                            </h5>
                            <button type="button"
                                    wire:click="togglePasswordSection"
                                    class="btn btn-sm btn-outline-secondary">
                                @if($showPasswordSection)
                                    <i class="fas fa-times me-1"></i>Cancel
                                @else
                                    <i class="fas fa-key me-1"></i>Change Password
                                @endif
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(!$showPasswordSection)
                            <div class="text-center py-4">
                                <i class="fas fa-shield-alt text-muted fa-3x mb-3"></i>
                                <p class="text-muted mb-0">Click "Change Password" to update your password</p>
                            </div>
                        @else
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="current_password" class="form-label fw-semibold">Current Password</label>
                                    <input type="password"
                                           wire:model="current_password"
                                           class="form-control @error('current_password') is-invalid @enderror"
                                           id="current_password"
                                           placeholder="Enter your current password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="new_password" class="form-label fw-semibold">New Password</label>
                                    <input type="password"
                                           wire:model="new_password"
                                           class="form-control @error('new_password') is-invalid @enderror"
                                           id="new_password"
                                           placeholder="Enter new password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="new_password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                                    <input type="password"
                                           wire:model="new_password_confirmation"
                                           class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                           id="new_password_confirmation"
                                           placeholder="Confirm new password">
                                    @error('new_password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button"
                                        wire:click="changePassword"
                                        wire:loading.attr="disabled"
                                        wire:target="changePassword"
                                        class="btn btn-warning">
                                    <span wire:loading wire:target="changePassword">
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Changing...
                                    </span>
                                    <span wire:loading.remove wire:target="changePassword">
                                        <i class="fas fa-key me-2"></i>Change Password
                                    </span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .user-avatar-large {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.5rem;
            color: white;
            margin: 0 auto;
            border: 3px solid rgba(255,255,255,0.3);
        }

        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
            color: white;
        }
    </style>
    @endpush


</div>
