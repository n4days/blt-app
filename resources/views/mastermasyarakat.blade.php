@extends('layouts.app')

@section('title', 'Master Masyarakat')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h4>Master Data Masyarakat</h4>
        @if(!auth()->user()->masyarakat)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
            + Tambah Data
        </button>
        @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Nominal Bantuan</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($masyarakats as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->desa }}, {{ $item->kecamatan }}</td>
                        <td>
                            <span class="badge {{ $item->status_penerima=='layak'?'bg-success':'bg-danger' }}">
                                {{ ucfirst($item->status_penerima) }}
                            </span>
                        </td>
                        <td>{{ number_format($item->nominal_bantuan,0,',','.') }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                Edit
                            </button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $item->id }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data kosong</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <form method="POST" action="{{ route('mastermasyarakat.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Masyarakat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        {{-- NIK --}}
                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" maxlength="16" required>
                            @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- PEKERJAAN --}}
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control">
                        </div>

                        {{-- ALAMAT --}}
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2" required></textarea>
                        </div>

                        {{-- DESA --}}
                        <div class="col-md-3">
                            <label class="form-label">Desa</label>
                            <input type="text" name="desa" class="form-control" required>
                        </div>

                        {{-- KECAMATAN --}}
                        <div class="col-md-3">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" required>
                        </div>

                        {{-- KABUPATEN --}}
                        <div class="col-md-3">
                            <label class="form-label">Kabupaten</label>
                            <input type="text" name="kabupaten" class="form-control" required>
                        </div>

                        {{-- PROVINSI --}}
                        <div class="col-md-3">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" required>
                        </div>

                        {{-- PENGHASILAN --}}
                        <div class="col-md-4">
                            <label class="form-label">Penghasilan</label>
                            <input type="number" name="penghasilan" class="form-control" min="0" required>
                        </div>

                        {{-- TANGGUNGAN --}}
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Tanggungan</label>
                            <input type="number" name="jumlah_tanggungan" class="form-control" min="0" required>
                        </div>

                        {{-- STATUS RUMAH --}}
                        <div class="col-md-4">
                            <label class="form-label">Status Rumah</label>
                            <select name="status_rumah" class="form-select">
                                <option value="">-- pilih --</option>
                                <option value="milik">Milik</option>
                                <option value="sewa">Sewa</option>
                                <option value="kontrak">Kontrak</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>

@foreach($masyarakats as $item)
<div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <form method="POST" action="{{ route('mastermasyarakat.update', $item->id) }}">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Masyarakat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        {{-- NIK --}}
                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" maxlength="16" required value="{{ $item->nik }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required value="{{ $item->nama_lengkap }}">
                        </div>

                        {{-- PEKERJAAN --}}
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" value="{{ $item->pekerjaan }}">
                        </div>

                        {{-- ALAMAT --}}
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ $item->alamat }}</textarea>
                        </div>

                        {{-- DESA --}}
                        <div class="col-md-3">
                            <label class="form-label">Desa</label>
                            <input type="text" name="desa" class="form-control" required value="{{ $item->desa }}">
                        </div>

                        {{-- KECAMATAN --}}
                        <div class="col-md-3">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" required value="{{ $item->kecamatan }}">
                        </div>

                        {{-- KABUPATEN --}}
                        <div class="col-md-3">
                            <label class="form-label">Kabupaten</label>
                            <input type="text" name="kabupaten" class="form-control" required value="{{ $item->kabupaten }}">
                        </div>

                        {{-- PROVINSI --}}
                        <div class="col-md-3">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" required value="{{ $item->provinsi }}">
                        </div>

                        {{-- PENGHASILAN --}}
                        <div class="col-md-4">
                            <label class="form-label">Penghasilan</label>
                            <input type="number" name="penghasilan" class="form-control" min="0" required value="{{ $item->penghasilan }}">
                        </div>

                        {{-- TANGGUNGAN --}}
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Tanggungan</label>
                            <input type="number" name="jumlah_tanggungan" class="form-control" min="0" required value="{{ $item->jumlah_tanggungan }}">
                        </div>

                        {{-- STATUS RUMAH --}}
                        <div class="col-md-4">
                            <label class="form-label">Status Rumah</label>
                            <select name="status_rumah" class="form-select">
                                <option value="">-- pilih --</option>
                                <option value="milik" {{ $item->status_rumah == 'milik' ? 'selected' : '' }}>Milik</option>
                                <option value="sewa" {{ $item->status_rumah == 'sewa' ? 'selected' : '' }}>Sewa</option>
                                <option value="kontrak" {{ $item->status_rumah == 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endforeach

@foreach($masyarakats as $item)
<div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <form method="POST" action="{{ route('mastermasyarakat.destroy', $item->id) }}">
                @csrf @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Masyarakat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <div class="col-12">
                            <h5>Apakah anda yakin ingin menghapus data masyarakat dengan NIK <strong>{{ $item->nik }}</strong>?</h5>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
