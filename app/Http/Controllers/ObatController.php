<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Resep;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->hasRole('admin|dokter')){
            $layout = 'layouts.sidebar';
            $content = 'side';
        }else{
            $layout = 'layouts.app';
            $content = 'content';
        }
        $search = $request->input('search');

    // Query untuk mendapatkan data obat
    $obats = Obat::when($search, function($query) use ($search) {
        return $query->where('obat', 'like', "%{$search}%")
                     ->orWhere('harga', 'like', "%{$search}%");
    })->paginate(10);

        $resep = Resep::all();
        return view('obat.index', compact('obats','resep','layout','content'));
    }

    public function create()
    {
        return view('obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'obat' => 'required',
            'jumlah' => 'required|numeric|min:0',
            'harga' => 'required|string',
        ]);

        Obat::create($request->only(['obat', 'jumlah', 'harga']));
        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    public function show(Obat $obat)
    {
        return view('obat.show', compact('obat'));
    }

    public function edit(Obat $obat)
    {
        $reseps = Resep::all();
        return view('obat.edit', compact('obat', 'reseps'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'obat' => 'required',
            'jumlah' => 'required|numeric|min:0',
            'harga' => 'required|string',
        ]);
        

        $obat = Obat::findOrFail($id);
        $obat->update($request->only(['obat', 'jumlah', 'harga']));
        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();
        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus.');
    }
}
