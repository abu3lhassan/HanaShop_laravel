@extends('layouts.appdash')

@section('content')
<style>
    .admin-users-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .admin-users-actions .btn {
        min-width: 82px;
        padding: 6px 14px;
        font-size: 0.82rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .admin-users-meta {
        min-width: 0;
    }

    .admin-users-meta strong,
    .admin-users-email {
        word-break: break-word;
    }

    .admin-users-protected {
        opacity: 0.75;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .admin-users-actions {
            justify-content: flex-start;
        }

        .admin-users-actions .btn {
            min-width: auto;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Admin Access</span>
        <h1 class="premium-title mb-1">Admin Users</h1>
        <p class="text-muted mb-0">
            Create and manage dashboard users who can access the admin area.
        </p>
    </div>

    <a class="btn btn-outline-dark" href="{{ route('dashboard') }}">
        Back to Dashboard
    </a>
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="premium-card p-4 h-100">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="icon-pill">
                    <i class="bi bi-person-plus"></i>
                </div>

                <div>
                    <h3 class="mb-1">Create Admin User</h3>
                    <p class="text-muted mb-0">Add a new user who can sign in to the dashboard.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin-users.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        maxlength="80"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        maxlength="120"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        minlength="8"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        minlength="8"
                        required
                    >
                </div>

                <button class="btn btn-primary w-100">
                    <i class="bi bi-save me-1"></i> Create Admin User
                </button>
            </form>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="glass-card table-card">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                <div>
                    <h3 class="mb-1">Existing Admin Users</h3>
                    <p class="text-muted mb-0">
                        All users listed here can access the admin dashboard.
                    </p>
                </div>

                <span class="status">{{ $users->count() }} User(s)</span>
            </div>

            <div class="table-row">
                <strong>User</strong>
                <strong>Email</strong>
                <strong class="text-end">Actions</strong>
            </div>

            @forelse($users as $user)
                <div class="table-row align-items-center">
                    <span class="admin-users-meta">
                        <strong>{{ $user->name }}</strong>
                        @if(auth()->id() === $user->id)
                            <small class="d-block text-muted">Current signed-in user</small>
                        @else
                            <small class="d-block text-muted">Admin user</small>
                        @endif
                    </span>

                    <span class="admin-users-email">
                        {{ $user->email }}
                    </span>

                    <span class="admin-users-actions">
                        <button
                            class="btn btn-sm btn-light border rounded-pill"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#editUser{{ $user->id }}"
                            aria-expanded="false"
                            aria-controls="editUser{{ $user->id }}"
                        >
                            Edit
                        </button>

                        @if(auth()->id() !== $user->id && $users->count() > 1)
                            <form
                                method="POST"
                                action="{{ route('admin-users.destroy', $user->id) }}"
                                onsubmit="return confirm('Delete this admin user?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-outline-danger rounded-pill">
                                    Delete
                                </button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-light border rounded-pill admin-users-protected" disabled>
                                Protected
                            </button>
                        @endif
                    </span>
                </div>

                <div class="collapse" id="editUser{{ $user->id }}">
                    <div class="premium-card p-4 my-3">
                        <h4 class="mb-3">Edit {{ $user->name }}</h4>

                        <form method="POST" action="{{ route('admin-users.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name', $user->name) }}"
                                        maxlength="80"
                                        required
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        value="{{ old('email', $user->email) }}"
                                        maxlength="120"
                                        required
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">New Password</label>
                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        minlength="8"
                                        placeholder="Leave blank to keep current password"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Confirm New Password</label>
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        class="form-control"
                                        minlength="8"
                                        placeholder="Leave blank to keep current password"
                                    >
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="table-row">
                    <span class="text-muted">No admin users found.</span>
                    <span>-</span>
                    <span>-</span>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection