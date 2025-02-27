<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Traits\HasRoles;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        // Tentukan layout dan content berdasarkan peran pengguna
        if (auth()->user()->hasRole('user')) {
            $layout = 'layouts.app';
            $content = 'content';
            $pasiens = Pasien::where('user_id', auth()->id());  // Non-admin hanya dapat melihat pasien mereka
        } else {
            $layout = 'layouts.sidebar';
            $content = 'side';
            $pasiens = Pasien::query();  // Admin dapat melihat semua pasien
        }
        // Ambil input pencarian
        $search = $request->input('search');

        // Ambil data pasien dengan pencarian dan pagination
        $pasiens = $pasiens
            ->when($search, function ($query, $search) {
                $query
                    ->where('nama', 'like', "%$search%")
                    ->orWhere('alamat', 'like', "%$search%")
                    ->orWhere('no_hp', 'like', "%$search%");
            })
            ->paginate(10);

        // Ambil semua data dokter
        $dokters = Dokter::all();  // Ambil semua dokter

        return view('pasien.index', compact('pasiens', 'layout', 'content', 'dokters'));  // Kirim $dokters ke view
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|numeric|unique:pasiens,no_hp',
            'tanggal_lahir' => 'nullable|date|before:today',  // Lebih simpel
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'no_hp.unique' => 'Nomor HP ini sudah digunakan.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak boleh hari ini atau di masa depan.',
        ]);

        // Simpan data
        Pasien::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'user_id' => auth()->id(),
        ]);

        // Redirect dengan pesan sukses
        return redirect()
            ->route(auth()->user()->hasRole('admin') || auth()->user()->hasRole('dokter') ? 'pasien.index' : 'home')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function show(Pasien $pasien)
    {
        $pasien->load('kunjungan', 'rekamMedis');  // Eager load kunjungan dan rekam medis
        return view('pasien.show', compact('pasien'));
    }

    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|unique:pasiens,no_hp,' . $pasien->id,
            'tanggal_lahir' => 'nullable|date',
            'dokter_id' => 'required|exists:dokters,id',
            'keluhan' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
        ]);

        // Update data pasien
        $pasien->update($request->only(['nama', 'alamat', 'no_hp', 'tanggal_lahir']));

        // Buat kunjungan
        Kunjungan::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $request->dokter_id,
            'keluhan' => $request->keluhan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'user_id' => auth()->id(),  // Menyimpan ID pengguna yang membuat kunjungan
        ]);

        return redirect()->route('pasien.index')->with('success', 'Data pasien dan kunjungan berhasil diperbarui.');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        if (auth()->user()->hasRole('user')) {
            return redirect()->route('home')->with('success', 'Data pasien berhasil dihapus.');
        } else {
            return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
        }
    }

    public function adminHome()
    {
        $jumlahPasien = Pasien::count();  // Hitung total pasien dari tabel 'pasiens'
        return view('admin-home', compact('jumlahPasien'));
    }
}
