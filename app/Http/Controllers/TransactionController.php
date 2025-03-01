<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $transactions = Transaction::latest()->paginate(10);

        return view('dashboard.transactions.index', compact('transactions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        try {
            $validated = $request->validated();

            $transaction = Transaction::create([
                'payment_method' => $validated['payment_method'],
                'total' => collect($validated['items'])->sum(fn ($item) => $item['quantity'] * $item['price']),
            ]);

            $transaction->items()->createMany($validated['items']);

            // Kurangi stok produk
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->stock -= $item['quantity'];
                    $product->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'redirect' => route('dashboard.transactions.index'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dashboard.transactions.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction): View
    {
        return view('dashboard.transactions.show', ['transaction' => $transaction->load(['items.product'])]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction): View
    {
        return view('dashboard.transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validated();

        $transaction->update([
            'payment_method' => $validated['payment_method'] ?? $transaction->payment_method,
        ]);

        if (isset($validated['items'])) {
            $transaction->items()->delete();
            $transaction->items()->createMany($validated['items']);
        }

        return redirect()->route('dashboard.transactions.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return redirect()->route('dashboard.transactions.index')->with('success', 'Transaction has been deleted');
    }

    public function income(): View
    {
        $transactions = Transaction::with('items')->get();
        $totalIncome = $transactions->sum('total');
    
        return view('dashboard.income.index', compact('transactions', 'totalIncome'));
    }
}