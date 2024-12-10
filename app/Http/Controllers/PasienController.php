<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
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

    // Tambahkan pencarian
    $search = $request->input('search');
    $pasiens = $pasiens->when($search, function ($query, $search) {
        $query->where('nama', 'like', "%$search%")
              ->orWhere('alamat', 'like', "%$search%")
              ->orWhere('no_hp', 'like', "%$search%");
    })->paginate(10);

    return view('pasien.index', compact('pasiens', 'layout', 'content'));
}



    public function create()
    {
        return view('pasien.create');
    }

    public function store(Request $request)
{
    try {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|unique:pasiens,no_hp',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        Pasien::create($data);
        
        if (auth()->user()->hasRole('admin')) {
        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil ditambahkan.');
        }else
        return redirect()->route('home')->with('success', 'Data pasien berhasil ditambahkan.');
    } catch (ValidationException $e) {
        return redirect('/home#form-pasien')
            ->withInput()
            ->withErrors($e->errors());
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
    ]);

    $pasien->update($request->all());
    return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
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