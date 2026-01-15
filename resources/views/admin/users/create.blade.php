@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); max-width: 600px; margin: 0 auto;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
            Create New User
        </h2>

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <!-- Name -->
            <div style="margin-bottom: 20px;">
                <label for="name" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
                @error('name')
                    <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
                @error('email')
                    <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Role Selection -->
            <div style="margin-bottom: 20px;">
                <label for="role" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Role</label>
                <select id="role" name="role" required
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; background-color: white;">
                    <option value="" disabled selected>Select a role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="border-top: 1px solid #e2e8f0; margin: 25px 0; padding-top: 20px;">
                <h3 style="font-size: 1.1rem; font-weight: 600; color: #1e293b; margin-bottom: 15px;">Security</h3>
                
                <!-- Password -->
                <div style="margin-bottom: 20px;">
                    <label for="password" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
                    @error('password')
                        <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div style="margin-bottom: 25px;">
                    <label for="password_confirmation" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px;">
                <a href="{{ route('admin.users') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Cancel</a>
                <button type="submit" style="background: #4f46e5; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
