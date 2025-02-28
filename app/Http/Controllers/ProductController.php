<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::latest()->paginate(10);
        // Cek stok produk yang kurang dari 5
        $lowStockProducts = Product::where('stock', '<', 5)->get();
    
        return view('dashboard.product.index', compact('products', 'lowStockProducts'));
    }

   
    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('dashboard.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('dashboard.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();
    
        // Cek apakah ada file gambar yang diunggah
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
    
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        } else {
            // Jika tidak ada gambar baru yang diunggah, gunakan gambar lama
            $validated['image'] = $product->image;
        }
    
        // Update produk
        $product->update($validated);
    
        return redirect()->route('dashboard.products.index')->with('success', 'Product updated successfully.');
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $imagePath = $request->file('image')->store('products', 'public');
                $validated['image'] = $imagePath;
            } else {
                return back()->withErrors(['image' => 'File tidak valid atau rusak']);
            }
        } else {
            return back()->withErrors(['image' => 'File tidak terkirim']);
        }

        Product::create($validated);

        return redirect()->route('dashboard.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dashboard.product.create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('dashboard.products.index')->with('success', 'Product deleted successfully.');
    }
}
