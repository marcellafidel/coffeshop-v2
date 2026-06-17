@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')
<style>
    .profile-wrap { max-width: 680px; margin: 0 auto; }
    .profile-header { display: flex; align-items: center; gap: 24px; background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 24px; animation: fadeUp 0.4s ease; }
    .avatar { width: 80px; height: 80px; border-radius: 50%; background: #A8C8E8; display: flex; align-items: center; justify-content: center; font-size: 32px; color: #fff; overflow: hidden; flex-shrink: 0; }
    .avatar img { width: 100%; height: 100%; object-fit: cover; }
    .profile-name { font-family: 'Playfair Display', serif; font-size: 22px; }
    .profile-email { color: #888; font-size: 14px; margin-top: 4px; }
    .profile-role { display: inline-block; background: #EFF6FF; color: #A8C8E8; padding: 4px 12px; border-radius: 20px; font-size: 12px; margin-top: 8px; }

    .form-card { background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 24px; animation: fadeUp 0.5s ease; }
    .form-card h3 { font-family: 'Playfair Display', serif; font-size: 18px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #f0f0f0; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 12px; font-weight: 600; color: #888; margin-bottom: 6px; text-transform: uppercase; }
    .form-group input, .form-group textarea {
        width: 100%; padding: 12px 16px; border: 1.5px solid #e8e8e8;
        border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif;
        transition: border-color 0.2s; background: #fafafa;
    }
    .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #A8C8E8; background: #fff; }
    .btn-save { padding: 12px 28px; background: #A8C8E8; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s; }
    .btn-save:hover { background: #8BB5D9; transform: translateY(-1px); }
    .error-msg { color: #e74c3c; font-size: 12px; margin-top: 4px; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="profile-wrap">
    {{-- HEADER --}}
    <div class="profile-header">
        <div class="avatar">
            @if($user->avatar)
                <img src="{{ Storage::url($user->avatar) }}" alt="avatar">
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </div>
        <div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email }}</div>
            <span class="profile-role">{{ ucfirst($user->role) }}</span>
        </div>
    </div>

    {{-- EDIT PROFIL --}}
    <div class="form-card">
        <h3>✏️ Edit Profil</h3>
        <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label>Nomor HP</label>
                    <input type="text" name="phone" value="{{ $user->phone }}" placeholder="08xx-xxxx-xxxx">
                </div>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" rows="3" placeholder="Alamat lengkap...">{{ $user->address }}</textarea>
            </div>
            <div class="form-group">
                <label>Foto Profil</label>
                <input type="file" name="avatar" accept="image/*">
            </div>
            <button type="submit" class="btn-save">Simpan Perubahan</button>
        </form>
    </div>

    {{-- GANTI PASSWORD --}}
    <div class="form-card">
        <h3>🔒 Ganti Password</h3>
        <form action="{{ route('customer.profile.password') }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Password Lama</label>
                <input type="password" name="current_password" required>
                @error('current_password')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>
            </div>
            <button type="submit" class="btn-save">Ganti Password</button>
        </form>
    </div>
</div>
@endsection