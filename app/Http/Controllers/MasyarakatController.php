<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MasyarakatController extends Controller
{
    public function index()
    {
        return view('mastermasyarakat', [
            'masyarakats' => Masyarakat::with('user')->latest()->paginate(10),
            'users'       => User::doesntHave('masyarakat')->get(),
            'editData'    => null,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik'               => 'required|digits:16|unique:masyarakats,nik',
            'pekerjaan'         => 'nullable|string',
            'alamat'            => 'required|string',
            'desa'              => 'required|string',
            'kecamatan'         => 'required|string',
            'kabupaten'         => 'required|string',
            'provinsi'          => 'required|string',
            'penghasilan'       => 'required|numeric|min:0',
            'jumlah_tanggungan' => 'required|integer|min:0',
            'status_rumah'      => 'nullable|in:milik,sewa,kontrak',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();

            if ($user->masyarakat) {
                throw new \Exception('User ini sudah memiliki data masyarakat');
            }

            $statusEkonomi = $this->hitungStatusEkonomi(
                $request->penghasilan,
                $request->jumlah_tanggungan,
                $request->status_rumah
            );

            [$statusPenerima, $nominalBantuan] = $this->hitungBantuan($statusEkonomi);

            Masyarakat::create([
                'user_id'           => $user->id,
                'nama_lengkap'      => $user->name,
                'nik'               => $request->nik,
                'pekerjaan'         => $request->pekerjaan,
                'alamat'            => $request->alamat,
                'desa'              => $request->desa,
                'kecamatan'         => $request->kecamatan,
                'kabupaten'         => $request->kabupaten,
                'provinsi'          => $request->provinsi,
                'penghasilan'       => $request->penghasilan,
                'jumlah_tanggungan' => $request->jumlah_tanggungan,
                'status_rumah'      => $request->status_rumah,

                'status_ekonomi'    => $statusEkonomi,
                'status_penerima'   => $statusPenerima,
                'nominal_bantuan'   => $nominalBantuan,
            ]);

            DB::commit();

            return redirect()->route('mastermasyarakat')
                ->with('success', 'Data masyarakat berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, Masyarakat $masyarakat)
    {
        $data = $request->validate([
            'nik'               => 'required|digits:16|unique:masyarakats,nik,' . $masyarakat->id,
            'pekerjaan'         => 'nullable|string',
            'alamat'            => 'required|string',
            'desa'              => 'required|string',
            'kecamatan'         => 'required|string',
            'kabupaten'         => 'required|string',
            'provinsi'          => 'required|string',
            'penghasilan'       => 'required|numeric|min:0',
            'jumlah_tanggungan' => 'required|integer|min:0',
            'status_rumah'      => 'nullable|in:milik,sewa,kontrak',
        ]);

        DB::beginTransaction();

        try {
            // hitung ulang status ekonomi
            $statusEkonomi = $this->hitungStatusEkonomi(
                $data['penghasilan'],
                $data['jumlah_tanggungan'],
                $data['status_rumah'] ?? null
            );

            // hitung ulang bantuan
            [$statusPenerima, $nominalBantuan] = $this->hitungBantuan($statusEkonomi);

            $masyarakat->update([
                'nik'               => $data['nik'],
                'pekerjaan'         => $data['pekerjaan'],
                'alamat'            => $data['alamat'],
                'desa'              => $data['desa'],
                'kecamatan'         => $data['kecamatan'],
                'kabupaten'         => $data['kabupaten'],
                'provinsi'          => $data['provinsi'],
                'penghasilan'       => $data['penghasilan'],
                'jumlah_tanggungan' => $data['jumlah_tanggungan'],
                'status_rumah'      => $data['status_rumah'],

                'status_ekonomi'    => $statusEkonomi,
                'status_penerima'   => $statusPenerima,
                'nominal_bantuan'   => $nominalBantuan,
            ]);

            DB::commit();

            return redirect()->route('mastermasyarakat')
                ->with('success', 'Data masyarakat berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function destroy(Masyarakat $masyarakat)
    {
        $masyarakat->delete();

        return redirect()->route('mastermasyarakat')
            ->with('success', 'Data masyarakat berhasil dihapus');
    }

    private function hitungStatusEkonomi($penghasilan, $tanggungan, $statusRumah)
    {
        if ($penghasilan <= 1500000) {
            $skorPenghasilan = 3;
        } elseif ($penghasilan <= 3000000) {
            $skorPenghasilan = 2;
        } else {
            $skorPenghasilan = 1;
        }

        if ($tanggungan >= 4) {
            $skorTanggungan = 3;
        } elseif ($tanggungan >= 2) {
            $skorTanggungan = 2;
        } else {
            $skorTanggungan = 1;
        }

        $skorRumah = in_array($statusRumah, ['sewa', 'kontrak']) ? 2 : 1;

        $totalSkor = $skorPenghasilan + $skorTanggungan + $skorRumah;

        if ($totalSkor >= 7) {
            return 'miskin';
        } elseif ($totalSkor >= 5) {
            return 'rentan';
        }

        return 'mampu';
    }

    private function hitungBantuan($statusEkonomi)
    {
        switch ($statusEkonomi) {
            case 'miskin':
                return ['layak', 1500000];
            case 'rentan':
                return ['layak', 750000];
            default:
                return ['tidak_layak', null];
        }
    }
}
