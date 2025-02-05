<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\RekamMedis;
use App\Models\Resep;
use Illuminate\Http\Request;

class ObatController extends Controller
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

        $search = $request->input('search');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $obats = Obat::when($search, function ($query) use ($search) {
            return $query
                ->where('obat', 'like', "%{$search}%")
                ->orWhere('harga', 'like', "%{$search}%");
        })
            ->when($minPrice, function ($query) use ($minPrice) {
                return $query->where('harga', '>=', $minPrice);
            })
            ->when($maxPrice, function ($query) use ($maxPrice) {
                return $query->where('harga', '<=', $maxPrice);
            })
            ->paginate(10);

        $resep = Resep::all();
        return view('obat.index', compact('obats', 'resep', 'layout', 'content'));
    }

    public function create()
    {
        return view('obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'obat' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'harga' => 'required|numeric|min:1',
        ], [
            'obat.required' => 'Nama obat wajib diisi.',
            'jumlah.required' => 'Jumlah obat wajib diisi.',
            'jumlah.numeric' => 'Jumlah obat harus berupa angka.',
            'jumlah.min' => 'Jumlah obat minimal 1.',
            'harga.required' => 'Harga obat wajib diisi.',
            'harga.numeric' => 'Harga obat harus berupa angka.',
            'harga.min' => 'Harga obat minimal 1.',
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
            'jumlah' => 'required|numeric|min:1',
            'harga' => 'required|numeric|min:1',
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
