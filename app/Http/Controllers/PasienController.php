<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Traits\HasRoles;

class PasienController extends Controller
{
    public function index(Request $request)
{
    // Tentukan layout dan content berdasarkan peran pengguna
    if (auth()->user()->hasRole('admin')) {
        $layout = 'layouts.sidebar';
        $content = 'side';
        $pasiens = Pasien::query(); // Admin dapat melihat semua pasien
    } else {
        $layout = 'layouts.app';
        $content = 'content';
        $pasiens = Pasien::where('user_id', auth()->id()); // Non-admin hanya dapat melihat pasien mereka
    }
    // Ambil input pencarian
    $search = $request->input('search');

    // Ambil data pasien dengan pencarian dan pagination
    $pasiens = Pasien::query()
        ->when($search, function ($query, $search) {
            $query->where('nama', 'like', "%$search%")
                ->orWhere('alamat', 'like', "%$search%")
                ->orWhere('no_hp', 'like', "%$search%");
        })
        ->paginate(10);

    // Ambil semua data dokter
    $dokters = Dokter::all(); // Ambil semua dokter

    return view('pasien.index', compact('pasiens', 'layout', 'content', 'dokters')); // Kirim $dokters ke view
}



    public function create()
    {
        return view('pasien.create');
    }

    public function store(Request $request)
{
    if(auth()->user()->hasRole('user')){
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string',
                'no_hp' => 'required|unique:pasiens,no_hp|numeric',
                'tanggal_lahir' =>[
                    'required',
                    'date',
                    function ($attribute, $value, $fail) {
                        $today = now()->toDateString(); // Mendapatkan tanggal hari ini
            
                        if ($value >= $today) { // Jika tanggal inputan lebih besar atau sama dengan hari ini
                            $fail("$attribute tidak boleh hari ini atau di masa depan.");
                        }
                    },
                ],
            ]);
        

            $data = $request->all();
            $data['user_id'] = auth()->id();
        
            Pasien::create($data);
        
            return redirect()->route('home')->with('success', 'Data pasien berhasil ditambahkan.');
        }catch (ValidationException $e) {
            return redirect('/home#form-pasien')
                ->withInput()
                ->withErrors($e->errors());
        }
    }else{
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|unique:pasiens,no_hp|numeric',
            'tanggal_lahir' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $today = now()->toDateString(); // Mendapatkan tanggal hari ini
        
                    if ($value >= $today) { // Jika tanggal inputan lebih besar atau sama dengan hari ini
                        $fail("$attribute tidak boleh hari ini atau di masa depan.");
                    }
                },
            ],
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        Pasien::create($data);
        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil ditambahkan');
    }
}
    public function show(Pasien $pasien)
    {
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
        'user_id' => auth()->id(), // Menyimpan ID pengguna yang membuat kunjungan
    ]);

    return redirect()->route('pasien.index')->with('success', 'Data pasien dan kunjungan berhasil diperbarui.');
}
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function adminHome()
{
    $jumlahPasien = Pasien::count(); // Hitung total pasien dari tabel 'pasiens'
    return view('admin-home', compact('jumlahPasien'));
}


}
