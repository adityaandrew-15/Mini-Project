<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('admin|dokter')) {
            $layout = 'layouts.sidebar';
            $content = 'side';
        } else {
            $layout = 'layouts.app';
            $content = 'content';
        }

        $query = Dokter::query();

        // Filter berdasarkan nama atau no_hp
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('nama', 'LIKE', "%$search%")
                    ->orWhere('no_hp', 'LIKE', "%$search%");
            });
        }

        // Filter berdasarkan spesialis
        if ($request->filled('spesialis')) {
            $query->where('spesialis', 'LIKE', "%{$request->spesialis}%");
        }

        $dokters = $query->paginate(10);

        return view('dokter.index', compact('dokters', 'layout', 'content'));
    }

    public function create()
    {
        return view('dokter.create');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $dokter = $user->dokter;  // Asumsikan ada relasi `dokter` di model `User`

        return view('home-dokter', compact('dokter'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'no_hp' => 'required|unique:dokters,no_hp|numeric',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle user creation for the doctor
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Handle the image upload if provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('dokters', 'public');
        }

        // Create the doctor entry and associate with the created user
        $dokter = Dokter::create([
            'nama' => $request->nama,
            'spesialis' => $request->spesialis,
            'no_hp' => $request->no_hp,
            'image' => $imagePath,
            'user_id' => $user->id,
        ]);

        // Set the role for the doctor
        $user->assignRole('dokter');

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dokter = Dokter::findOrFail($id);
        return response()->json($dokter);
    }

    // ProfileController.php
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Cari dokter berdasarkan ID
        $dokter = Dokter::findOrFail($id);

        // Update data dokter
        $dokter->nama = $request->nama;
        $dokter->spesialis = $request->spesialis;

        // Jika ada file gambar yang diunggah, perbarui gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($dokter->image && Storage::exists('public/dokters/' . $dokter->image)) {
                Storage::delete('public/dokters/' . $dokter->image);
            }

            // Simpan gambar baru
            $dokter->image = $request->file('image')->store('dokters', 'public');
        }

        // Simpan perubahan
        $dokter->save();

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);

        // Hapus gambar dari storage
        if ($dokter->image && file_exists(public_path('storage/dokters/' . $dokter->image))) {
            unlink(public_path('storage/dokters/' . $dokter->image));
        }

        $dokter->delete();

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil dihapus.');
    }
}
