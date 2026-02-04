@extends('layouts.auth')

@section('title', 'Edit Hak Akses')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <strong>Edit Hak Akses User</strong>
        </div>

        <div class="card-body">
            <form action="{{ route('users.updateHakAkses', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hak Akses</label>
                    <select name="hak_akses" class="form-select" required>
                        <option value="masyarakat" {{ $user->hak_akses == 'masyarakat' ? 'selected' : '' }}>
                            Masyarakat
                        </option>
                        <option value="petugas" {{ $user->hak_akses == 'petugas' ? 'selected' : '' }}>
                            Petugas
                        </option>
                    </select>
                </div>

                <button class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
