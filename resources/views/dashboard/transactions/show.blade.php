<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Transaksi #{{ $transaction->id }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printArea, #printArea * {
                visibility: visible;
            }
            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print, .no-print * {
                display: none !important;
            }
        }
    </style>
</head>
<body class="font-inter" style="background:#F9FAFB;">

    @include('layouts.sidebar')
    @include('layouts.navbar')

    <div class="ml-0 sm:ml-60 p-3 md:p-6">
        <div class="bg-white p-3 md:p-6 rounded-lg shadow-md">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div>
                    <h2 class="text-2xl md:text-4xl font-bold mb-2">Detail Transaksi</h2>
                    <p class="text-gray-600">ID Transaksi: #{{ $transaction->id }}</p>
                </div>
                <div class="flex space-x-2 mt-4 md:mt-0 no-print">
                    <a href="{{ url()->previous() }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="bx bx-arrow-back mr-2"></i>Kembali
                    </a>
                    <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="bx bx-printer mr-2"></i>Print
                    </button>
                </div>
            </div>

            <div id="printArea">
                <!-- Print Header -->
                <div class="mb-6 hidden print:block text-center">
                    <h1 class="text-2xl font-bold">Detail Transaksi</h1>
                    <p class="text-gray-600">ID: #{{ $transaction->id }}</p>
                </div>

                <!-- Info Transaksi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Info Dasar -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3 text-gray-800">Informasi Transaksi</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Transaksi:</span>
                                <span class="font-medium">#{{ $transaction->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal:</span>
                                <span class="font-medium">{{ $transaction->created_at->format('d-m-Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Metode Pembayaran:</span>
                                <span class="font-medium">{{ $transaction->payment_method }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm">Selesai</span>
                            </div>
                        </div>
                    </div>

                    <!-- Info Pembayaran -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3 text-gray-800">Ringkasan Pembayaran</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </div>
                            @if(isset($transaction->tax) && $transaction->tax > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pajak:</span>
                                <span class="font-medium">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if(isset($transaction->discount) && $transaction->discount > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Diskon:</span>
                                <span class="font-medium text-red-600">-Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <hr class="my-2">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total:</span>
                                <span class="text-green-600">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Items -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Detail Pembelian</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-[#34495E] text-white">
                                <tr>
                                    <th class="border px-3 py-2 text-left">No</th>
                                    <th class="border px-3 py-2 text-left">Produk</th>
                                    <th class="border px-3 py-2 text-center">Qty</th>
                                    <th class="border px-3 py-2 text-right">Harga Satuan</th>
                                    <th class="border px-3 py-2 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaction->items as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-3 py-2">{{ $index + 1 }}</td>
                                    <td class="border px-3 py-2">
                                        <div class="font-medium">
                                            @if(isset($item->product))
                                                {{ $item->product->name }}
                                            @else
                                                {{ $item->product_name ?? 'Produk tidak ditemukan' }}
                                            @endif
                                        </div>
                                        @if(isset($item->product->description))
                                        <div class="text-sm text-gray-500">{{ $item->product->description }}</div>
                                        @endif
                                    </td>
                                    <td class="border px-3 py-2 text-center">{{ $item->quantity }}</td>
                                    <td class="border px-3 py-2 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="border px-3 py-2 text-right font-medium">
                                        Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                    </td>                                        
                                 </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="border px-3 py-4 text-center text-gray-500">Tidak ada item dalam transaksi ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($transaction->items->count() > 0)
                            <tfoot class="bg-gray-100">
                                <tr>
                                    <td colspan="4" class="border px-3 py-2 text-right font-semibold">Total:</td>
                                    <td class="border px-3 py-2 text-right font-bold text-green-600">
                                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- Info Tambahan -->
                @if(isset($transaction->notes) && $transaction->notes)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800">Catatan</h3>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <p class="text-gray-700">{{ $transaction->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- Footer Print -->
                <div class="mt-8 hidden print:block text-center text-sm text-gray-500">
                    <p>Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Auto focus untuk kemudahan navigasi
        document.addEventListener('DOMContentLoaded', function() {
            // Bisa ditambahkan script tambahan jika diperlukan
        });
    </script>
</body>
</html>