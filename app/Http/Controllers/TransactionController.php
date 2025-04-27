<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
Use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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




public function printReceipt(Request $request)
{
    // Header untuk memastikan response JSON
    header('Content-Type: application/json');

    try {
        // Validasi input
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:50',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,shopee_pay,dana',
            'amount_paid' => 'required|numeric|min:0',
            'change' => 'required|numeric|min:0',
            'print' => 'sometimes|boolean',
        ]);

        // Skip printing if not requested
        if (isset($data['print']) && $data['print'] === false) {
            return response()->json([
                'success' => true,
                'message' => 'Struk berhasil dilewati'
            ]);
        }

        // Try multiple printer connection methods
        $printer = $this->connectToPrinter();
        if (!$printer) {
            throw new \Exception('Gagal menghubungkan ke printer setelah beberapa percobaan');
        }

        // Print receipt content
        $this->printReceiptContent($printer, $data);

        return response()->json([
            'success' => true,
            'message' => 'Struk berhasil dicetak'
        ]);

    } catch (\Exception $e) {
        Log::error('Gagal mencetak struk: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Gagal mencetak struk: ' . $e->getMessage()
        ], 500);
    }
}


private function connectToPrinter()
{
    try {
        $profile = CapabilityProfile::load("simple");

        // Ambil nama printer dari konfigurasi
        $printerName = config('app.printer_name', 'POS-58');

        if (!$printerName) {
            throw new \Exception('Printer tidak ditemukan. Menggunakan printer default.');
        }

        // Coba koneksi ke printer
        $connector = new WindowsPrintConnector($printerName);
        return new Printer($connector, $profile);
    } catch (\Exception $e) {
        Log::error('Kesalahan koneksi printer: ' . $e->getMessage());
        return null;
    }
}
private function printReceiptContent($printer, $data)
{
    try {
        // Set character width for 55mm printer
        $lineWidth = 32; // Standard 55mm printer width in characters
        
        // Logo/Brand - small logo at top left
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        // Store name
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setEmphasis(true);
        $printer->text("ECEU BAKO\n");
        $printer->setEmphasis(false);
        
        // Address
        $printer->text("Jl. Pintu Ledeng, Ciomas\n");
        $printer->text("Kab. Bogor, Jawa Barat 16610\n");
        
        // Divider with dashes
        $printer->text("================================\n");
        
        // Items with price on the right
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        foreach ($data['items'] as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $leftText = $item['quantity'] . "x " . $item['name'];
            $rightText = "Rp" . number_format($itemTotal, 0, ',', '.');
            
            $spaces = $lineWidth - (mb_strlen($leftText) + mb_strlen($rightText));
            $printer->text($leftText . str_repeat(" ", $spaces > 0 ? $spaces : 1) . $rightText . "\n");
        }
        
        // Divider with dashes
        $printer->text("================================\n");
        
        // Payment details aligned with label on left, value on right
        $this->printPaymentDetailAligned($printer, "Metode Bayar:", 
            $this->getPaymentMethodText($data['payment_method']), $lineWidth);
        $this->printPaymentDetailAligned($printer, "Subtotal:", 
            "Rp" . number_format($data['total'], 0, ',', '.'), $lineWidth);
        
        if ($data['payment_method'] === "cash") {
            $this->printPaymentDetailAligned($printer, "Cash:", 
                "Rp" . number_format($data['amount_paid'], 0, ',', '.'), $lineWidth);
            $this->printPaymentDetailAligned($printer, "Kembali:", 
                "Rp" . number_format($data['change'], 0, ',', '.'), $lineWidth);
        } else {
            // For non-cash payments like in your example (Shopee Pay)
            $this->printPaymentDetailAligned($printer, "Cash:", 
                "Rp" . number_format($data['total'], 0, ',', '.'), $lineWidth);
            $this->printPaymentDetailAligned($printer, "Kembali:", 
                "Rp0", $lineWidth);
        }
        
        // Divider with dashes
        $printer->text("================================\n");
        
        // Footer message - centered
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Terima kasih\n");
        $printer->text("telah berbelanja\n");
        
        // Final divider
        $printer->text("================================\n");
        
        // Finalize
        $printer->cut();
        $printer->close();

    } catch (\Exception $e) {
        if (isset($printer)) {
            $printer->close();
        }
        throw $e;
    }
}

private function printPaymentDetailAligned($printer, $label, $value, $lineWidth)
{
    // Calculate spaces needed for alignment
    $spaces = $lineWidth - (mb_strlen($label) + mb_strlen($value));
    
    // Print with proper alignment (label left, value right)
    $printer->text($label . str_repeat(" ", $spaces > 0 ? $spaces : 1) . $value . "\n");
}

private function getPaymentMethodText($method)
{
    switch ($method) {
        case 'shopee_pay': return 'Shopee Pay';
        case 'dana': return 'DANA';
        case 'cash': return 'Tunai';
        default: return 'Tunai';
    }
}
}