<?php

namespace App\Http\Controllers;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrintController extends Controller
{
    public function printReceipt(Request $request)
    {
        // Validasi request
        try {
            $validated = $request->validate([
                'items' => 'required|array',
                'items.*.name' => 'required|string',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'items.*.size' => 'sometimes|string', // Added size validation
                'total' => 'required|numeric|min:0',
                'payment_method' => 'required|string|in:cash,shopee_pay,dana',
                'amount_paid' => 'required|numeric|min:0',
                'change' => 'required|numeric|min:0',
                'print' => 'sometimes|boolean',
            ]);

            // Skip printing if not requested
            if (isset($validated['print']) && $validated['print'] === false) {
                return response()->json([
                    'success' => true,
                    'message' => 'Receipt printing skipped.',
                ]);
            }

            // Try multiple printer connection methods
            $printer = $this->connectToPrinter();
            if (!$printer) {
                throw new \Exception('Failed to connect to printer after multiple attempts');
            }

            // Print receipt content
            $this->printReceiptContent($printer, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Receipt printed successfully.',
            ]);

        } catch (\Exception $e) {
            Log::error('Printing error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error printing receipt: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function connectToPrinter()
    {
        try {
            $profile = CapabilityProfile::load("simple");
            
            // Try different printer connection methods
            $printerNames = [
                "epson_naufal",              // Nama printer lokal
                "EPSON L120 Series",       // Nama alternatif
                "smb://localhost/epson_naufal", // Shared printer
            ];

            foreach ($printerNames as $printerName) {
                try {
                    $connector = new WindowsPrintConnector($printerName);
                    return new Printer($connector, $profile);
                } catch (\Exception $e) {
                    Log::info("Failed to connect using printer name: $printerName - " . $e->getMessage());
                    continue;
                }
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Printer connection error: ' . $e->getMessage());
            return null;
        }
    }

    private function printReceiptContent($printer, $data)
    {
        try {
            // Header
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text("ECEU BAKO\n");
            $printer->setEmphasis(false);
            $printer->text("Jl. Pintu Ledeng, Ciomas\n");
            $printer->text("Kab. Bogor, Jawa Barat 16610\n");
            $printer->text("====================\n");
    
            // Items
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            foreach ($data['items'] as $item) {
                $itemTotal = $item['price'] * $item['quantity'];
                
                // Pastikan size akan muncul di struk
                $itemName = $item['name'];
                if (isset($item['size']) && !empty($item['size'])) {
                    $itemName .= " (" . $item['size'] . ")";
                }
                
                // Log untuk debug
                \Illuminate\Support\Facades\Log::info('Item untuk dicetak: ' . $itemName);
                
                $printer->text($item['quantity'] . "x " . $itemName . "\n");
                $printer->setJustification(Printer::JUSTIFY_RIGHT);
                $printer->text("Rp" . number_format($itemTotal, 0, ',', '.') . "\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
            }
    
            // Payment info
            $printer->text("\n");
            $this->printPaymentDetails($printer, $data);
    
            // Footer
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("\n====================\n");
            $printer->setEmphasis(true);
            $printer->text("Terima kasih\n");
            $printer->text("telah berbelanja\n");
            $printer->setEmphasis(false);
            $printer->text("====================\n");
            $printer->text(date("Y-m-d H:i:s") . "\n");
    
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
    private function printPaymentDetails($printer, $data)
    {
        $paymentMethod = $this->getPaymentMethodText($data['payment_method']);
        
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Metode Bayar: ");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text($paymentMethod . "\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Subtotal: ");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("Rp" . number_format($data['total'], 0, ',', '.') . "\n");

        if ($data['payment_method'] === "cash") {
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Cash: ");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("Rp" . number_format($data['amount_paid'], 0, ',', '.') . "\n");

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Kembali: ");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("Rp" . number_format($data['change'], 0, ',', '.') . "\n");
        }
    }

    private function getPaymentMethodText($method)
    {
        switch ($method) {
            case 'shopee_pay': return 'Shopee Pay';
            case 'dana': return 'DANA';
            default: return 'Tunai';
        }
    }
}