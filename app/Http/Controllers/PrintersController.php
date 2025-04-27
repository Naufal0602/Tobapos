<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Printers;

class PrintersController extends Controller
{
    
    public function index()
{
    $printers = Printers::all();
    if (!isset($printers)) {
        $printers = collect(); // Berikan koleksi kosong jika tidak ada data
    }
    return view('dashboard.product.index', compact('printers'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_printer' => 'required|string|max:255|unique:printers,nama_printer',
        ]);

        Printers::create([
            'nama_printer' => $request->nama_printer,
        ]);

        return redirect()->back()->with('success', 'Printer berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $printer = Printers::findOrFail($id);
        $printer->delete();

        return redirect()->back()->with('success', 'Printer berhasil dihapus');
    }

    /**
     * Mengatur printer default untuk produk.
     */
    public function setPrinter(Request $request)
    {
        // Tambahkan kode untuk menyimpan printer yang dipilih
        // Misalnya menyimpan ke dalam tabel settings atau ke user preferences

        return redirect()->back()->with('success', 'Printer berhasil diatur');
    }
}