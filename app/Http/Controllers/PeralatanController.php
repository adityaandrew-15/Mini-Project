<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peralatan;

class PeralatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if (auth()->user()->hasRole('admin')) {
        $layout = 'layouts.sidebar';
        $content = 'side';
    } else {
        $layout = 'layouts.app';
        $content = 'content';
    }

    // Ambil nilai pencarian dari input
    $search = $request->input('search');

    // Jika ada pencarian, lakukan pencarian pada nama_peralatan
    if ($search) {
        $peralatan = Peralatan::where('nama_peralatan', 'like', '%' . $search . '%')->get();
    } else {
        // Jika tidak ada pencarian, ambil semua data peralatan
        $peralatan = Peralatan::all();
    }

    return view('peralatan.index', compact('peralatan', 'content', 'layout'));
}


    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('peralatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the input
    $validated = $request->validate([
        'nama_peralatan' => 'required|string|max:255',
        'jumlah' => 'required|integer|min:1',
        'harga' => 'required|integer|min:0',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Add validation for gambar
    ]);

    // Handle image upload if provided
    $data = $request->all();
    if ($request->hasFile('gambar')) {
        $gambarName = time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('storage/peralatan'), $gambarName);
        $data['gambar'] = $gambarName;
    } else {
        // If no image is provided, you can set a default image or leave it null
        $data['gambar'] = null; // or 'default_image.jpg' if you want a default image
    }

    // Create the Peralatan entry
    Peralatan::create($data);

    return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil ditambahkan!');
}

    /**
     * Display the specified resource.
     */
    public function show(Peralatan $peralatan)
    {
        return view('peralatan.show', compact('peralatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peralatan $peralatan)
    {
        return view('peralatan.edit', compact('peralatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peralatan $peralatan)
{
    // Validasi input
    $validated = $request->validate([
        'nama_peralatan' => 'required|string|max:255',
        'jumlah' => 'required|integer|min:1',
        'harga' => 'required|integer|min:0',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar (opsional)
    ]);

    // Jika ada gambar baru yang diupload
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($peralatan->gambar) {
            unlink(public_path('storage/peralatan/' . $peralatan->gambar));
        }

        // Proses upload gambar baru
        $gambarName = time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('storage/peralatan'), $gambarName);
        $validated['gambar'] = $gambarName; // Tambahkan gambar baru ke data
    }

    // Perbarui data peralatan
    $peralatan->update($validated);

    return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peralatan $peralatan)
    {
        $peralatan->delete();

        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil dihapus!');
    }
}