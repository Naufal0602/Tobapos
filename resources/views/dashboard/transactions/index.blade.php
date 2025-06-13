<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaksi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>

    <style>
     
@media print {
    @page {
        size: 58mm auto;
        margin: 0;
    }
    
    body {
        width: 58mm !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Hide all content by default */
    body * {
        display: none;
    }
    
    /* Show only receipt content */
    #printable-receipt, #printable-receipt * {
        display: block !important;
        visibility: visible !important;
    }
    
    #printable-receipt {
        position: absolute;
        left: 0;
        top: 0;
        width: 58mm;
        font-size: 12px !important;
        font-family: 'Courier New', monospace !important;
    }
    
    .no-print {
        display: none !important;
    }
}
    </style>
</head>
<body class="bg-[#F9FAFB] font-inter"> 

    @include('layouts.sidebar')
    @include('layouts.navbar')

    <div class="ml-0 sm:ml-60 p-3 md:p-6">
        <!-- Keep your existing content intact -->
       

        <div class="bg-[#f5f7fa] p-3 md:p-6 rounded-lg shadow-md">
             <h2 class="text-2xl md:text-4xl font-bold mb-4">Transaksi</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-[#1d4267] text-white font-inter">
                        <tr>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Produk</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Ukuran</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Kategori</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Jumlah</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base"> Harga </th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Subtotal</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items" class="bg-white">
                        <!-- Cart items will be loaded here -->
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <label for="payment_method" class="block font-semibold text-sm md:text-base">Metode Pembayaran</label>
                <select id="payment_method" class="w-full p-2 border rounded-lg mt-2 text-sm md:text-base" onchange="updateQRCode()">
                    <option value="cash">Tunai</option>
                    <option value="shopee_pay">Shopee Pay</option>
                    <option value="dana">DANA</option>
                </select>
            </div>
            
            <!-- QR Code Container -->
            <div id="qrcode-container" class="mt-4 flex justify-center"></div>
            <p class="text-base md:text-lg font-semibold mt-4">Total: <span id="total-price">Rp 0</span></p>
            
            <!-- Amount Paid -->
            <div id="amount-paid-container" class="mt-4">
                <label for="amount-paid" class="block font-semibold text-sm md:text-base">Uang Dibayarkan</label>
                <input type="text" id="amount-paid" class="w-full p-2 border rounded-lg mt-2 text-sm md:text-base" oninput="formatToRupiah(this)" onblur="removeNonNumeric(this)">
            </div>

            <!-- Change -->
            <p id="change-container" class="text-base md:text-lg font-semibold mt-4">Kembalian: <span id="change-amount">Rp 0</span></p>

            <div class="mt-4 text-right">
                <button onclick="confirmPayment()" class="bg-blue-500 text-white text-center ju  p-2 md:p-3 rounded-lg hover:bg-blue-700 text-sm md:text-base">
                   <i class='bx  bx-currency-note'></i>  Bayar
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden receipt content for printing - Never shown to user -->
    <div id="printable-receipt" style="display: none; width: 55mm; font-family: 'Courier New', monospace; font-size: 12px; padding: 5px;">
        <img src="{{ asset('img/logo-v3.png') }}" alt="Logo" style="width: 70px; height: 70px; margin-bottom: 5px;">
        <div style="text-align: center; margin-bottom: 5px;">
            <strong>ECEU BAKO</strong><br>
            Jl. Pintu Ledeng, Ciomas<br>
            Kab. Bogor, Jawa Barat 16610<br>
            ====================
        </div>
        <div id="print-receipt-items">
            <!-- Item akan diisi oleh JavaScript -->
        </div>
        <div style="border-top: 1px dashed #000; margin-bottom: 5px;">
            <div style="display: flex; justify-content: space-between;">
                <span><strong>Metode Bayar:</strong></span>
                <span id="print-receipt-method"></span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span><strong>Subtotal:</strong></span> 
                <span id="print-receipt-total"></span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span><strong>Cash:</strong></span>
                <span id="print-receipt-paid"></span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span><strong>Kembali:</strong></span>
                <span id="print-receipt-change"></span>
            </div>
        </div>
        <div style="text-align: center; margin-top: 10px;">
            ====================<br>
            <strong>Terima kasih </strong><br>
            <strong>telah berbelanja</strong><br>
            ====================
        </div>
    </div>
    
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
       const transactionUrl = "{{ route('dashboard.transactions.store') }}";
       const printReceiptUrl = "{{ route('dashboard.print.receipt') }}";
       const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        // Helper functions for localStorage management
        function getCart() {
            try {
                const cartData = localStorage.getItem("cart");
                return cartData ? JSON.parse(cartData) : [];
            } catch (error) {
                console.error("Error reading cart data:", error);
                return [];
            }
        }

        function saveCart(cart) {
            localStorage.setItem("cart", JSON.stringify(cart));
        }

        function getProducts() {
            try {
                const productsData = localStorage.getItem("products");
                return productsData ? JSON.parse(productsData) : [];
            } catch (error) {
                console.error("Error reading products data:", error);
                return [];
            }
        }

        function saveProducts(products) {
            localStorage.setItem("products", JSON.stringify(products));
        }

        // Cart functions
        function loadCart() {
            const cart = getCart();
            const cartContainer = document.getElementById("cart-items");
            let totalPrice = 0;

            if (!cartContainer) return;

            cartContainer.innerHTML = "";

            if (cart.length === 0) {
                cartContainer.innerHTML = `
                    <tr>
                        <td colspan="7" class="border font-inter font-bold px-4 py-2 text-center">
                            Keranjang belanja kosong
                        </td>
                    </tr>`;
            } else {
                cart.forEach((item, index) => {
                    const subtotal = item.price * item.quantity;
                    totalPrice += subtotal;

                    cartContainer.innerHTML += `
                        <tr>
                            <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">${item.name}</td>
                            <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">${item.size}</td>
                            <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">${item.category}</td>
                            <td class="border px-1 py-1 sm:px-2 sm:py-1 md:px-4 md:py-2 text-xs sm:text-sm md:text-base">
                            <div class="flex items-center justify-center space-x-1 sm:space-x-2">
                                <button onclick="changeQuantity(${index}, -1)" 
                                        class="px-1 py-0.5 sm:px-2 sm:py-1 md:px-3 md:py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs sm:text-sm md:text-base transition-colors">
                                    -
                                </button>
                                <span class="mx-1 sm:mx-2 md:mx-3 font-medium min-w-[20px] text-center">${item.quantity}</span>
                                <button onclick="changeQuantity(${index}, +1)" 
                                        class="px-1 py-0.5 sm:px-2 sm:py-1 md:px-3 md:py-1 bg-green-500 hover:bg-green-600 text-white rounded text-xs sm:text-sm md:text-base transition-colors">
                                    +
                                </button>
                            </div>
                        </td>
                        <td class="border px-1 py-1 sm:px-2 sm:py-1 md:px-4 md:py-2 text-xs sm:text-sm md:text-base text-right">
                            Rp ${item.price.toLocaleString()}
                        </td>
                        <td class="border px-1 py-1 sm:px-2 sm:py-1 md:px-4 md:py-2 text-xs sm:text-sm md:text-base font-semibold text-right">
                            Rp ${subtotal.toLocaleString()}
                        </td>
                            <td class="border px-2 py-1 md:px-4 md:py-2 text-center text-xs md:text-base">
                                <button onclick="removeItem(${index})" class="text-red-500">Hapus</button>
                            </td>
                        </tr>`;
                });
            }

            document.getElementById("total-price").textContent = `Rp ${totalPrice.toLocaleString()}`;
}

        function syncCartWithMenu() {
            const cart = getCart();
            const products = getProducts();

            cart.forEach(item => {
                const product = products.find(p => p.id === item.id);
                if (product) {
                    // Update stock in case it has changed
                    item.stock = product.stock;
                }
            });

            saveCart(cart);
        }

        function addToCart(productId, productName, productPrice, productStock, productCategory) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let existingProduct = cart.find(item => item.id === productId);

            if (existingProduct) {
                if (existingProduct.quantity < productStock) {
                    existingProduct.quantity += 1;
                } else {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: `Jumlah ${productName} di keranjang sudah mencapai stok maksimal (${productStock}).`,
                        icon: 'warning',
                        confirmButtonColor: '#4F46E5',
                        customClass: {
                            popup: 'swal2-responsive'
                        }
                    });
                    return;
                }
            } else {
                if (productStock > 0) {
                    cart.push({ id: productId, name: productName, price: productPrice, quantity: 1, stock: productStock, category: productCategory });
                } else {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: `${productName} sudah habis. Silakan tambahkan stok terlebih dahulu.`,
                        icon: 'warning',
                        confirmButtonColor: '#4F46E5',
                        customClass: {
                            popup: 'swal2-responsive'
                        }
                    });
                    return;
                }
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            Swal.fire({
                title: 'Berhasil!',
                text: `${productName} telah ditambahkan ke keranjang.`,
                icon: 'success',
                confirmButtonColor: '#4F46E5',
                customClass: {
                    popup: 'swal2-responsive'
                }
            });
        }

        function changeQuantity(index, delta) {
            const cart = getCart();

            if (index < 0 || index >= cart.length) return;

            const item = cart[index];
            const products = getProducts();
            const product = products.find(p => p.id === item.id);

            if (!product) {
                Swal.fire({
                    title: 'Peringatan!',
                    text: `Produk ${item.name} tidak ditemukan dalam daftar produk.`,
                    icon: 'warning'
                });
                return;
            }

            // Check available stock
            if (delta > 0 && item.quantity < product.stock) {
                item.quantity += delta;
            } else if (delta < 0 && item.quantity > 1) {
                // Only decrease if quantity will remain above 0
                item.quantity += delta;
            } else if (delta < 0 && item.quantity === 1) {
                // If quantity is 1 and trying to decrease, show alert but don't change
                Swal.fire({
                    title: 'Perhatian',
                    text: 'Jumlah sudah minimal. Gunakan tombol Hapus untuk menghapus item.',
                    icon: 'info'
                });
                return;
            } else {
                Swal.fire({
                    title: 'Peringatan!',
                    text: `Stok ${item.name} tidak mencukupi. Tersisa ${product.stock} item.`,
                    icon: 'warning'
                });
                return;
            }

            saveCart(cart);
            loadCart();
        }

        function removeItem(index) {
            const cart = getCart();
            
            if (index < 0 || index >= cart.length) return;
            
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus produk ini dari keranjang?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    cart.splice(index, 1);
                    saveCart(cart);
                    loadCart();
                    
                    Swal.fire(
                        'Terhapus!',
                        'Produk telah dihapus dari keranjang.',
                        'success'
                    );
                }
            });
        }

        function updateStock(productId, quantity) {
            const products = getProducts();
            const productIndex = products.findIndex(p => p.id === productId);
            
            if (productIndex === -1) return false;
            
            products[productIndex].stock -= quantity;
            saveProducts(products);
            return true;
        }

        // Payment functions
        function updateQRCode() {
            const paymentMethod = document.getElementById("payment_method").value;
            const qrcodeContainer = document.getElementById("qrcode-container");
            const amountPaidContainer = document.getElementById("amount-paid-container");
            const changeContainer = document.getElementById("change-container");

            qrcodeContainer.innerHTML = "";

            if (paymentMethod === "cash") {
                amountPaidContainer.style.display = "block";
                changeContainer.style.display = "block";
            } else {
                amountPaidContainer.style.display = "none";
                changeContainer.style.display = "none";

                const qrUrls = {
                    shopee_pay: "{{ asset('img/qr_3.jpg') }}",
                    dana: "{{ asset('img/qr_3.jpg') }}"
                };

                if (qrUrls[paymentMethod]) {
                    qrcodeContainer.innerHTML = `
                        <img src="${qrUrls[paymentMethod]}" alt="QR Code ${paymentMethod}" class="w-24 h-24 md:w-32 md:h-32 mx-auto">
                    `;
                }
            }
        }

        function calculateChange() {
            const totalText = document.getElementById("total-price").textContent;
            const totalPrice = parseInt(totalText.replace(/\D/g, "")) || 0;
            const amountPaid = parseInt(document.getElementById("amount-paid").value) || 0;
            const change = amountPaid - totalPrice;

            document.getElementById("change-amount").textContent = "Rp " + (change >= 0 ? change.toLocaleString() : "0");
        }
// Fungsi confirmPayment yang dimodifikasi
function confirmPayment() {
    const paymentMethod = document.getElementById("payment_method").value;
    
    if (paymentMethod === "cash") {
        // Untuk pembayaran tunai, gunakan konfirmasi yang sudah ada
        Swal.fire({
            title: "Konfirmasi Pembayaran Tunai",
            text: "Apakah pelanggan sudah membayar?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, sudah",
            cancelButtonText: "Belum"
        }).then((result) => {
            if (result.isConfirmed) {
                processPayment();
            }
        });
    } else {
        // Untuk e-wallet (Shopee Pay, DANA), tampilkan modal dengan QR code
        const totalPrice = document.getElementById("total-price").textContent;
        const qrCodeUrl = paymentMethod === "shopee_pay" ? 
            "{{ asset('img/qr_3.jpg') }}" : 
            "{{ asset('img/qr_3.jpg') }}";
        
        Swal.fire({
            title: `Pembayaran ${paymentMethod === "shopee_pay" ? "Shopee Pay" : "DANA"}`,
            html: `
                <div class="text-center">
                    <p class="mb-2">Total Pembayaran: <strong>${totalPrice}</strong></p>
                    <div class="my-4">
                        <img src="${qrCodeUrl}" alt="QR Code Pembayaran" class="mx-auto" style="width: 200px; height: 200px;">
                    </div>
                    <p class="text-sm text-gray-600">Silakan scan QR code di atas untuk melakukan pembayaran</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Pembayaran Selesai",
            cancelButtonText: "Batal",
            confirmButtonColor: '#4CAF50',
            cancelButtonColor: '#F44336',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    // Di sini bisa ditambahkan pengecekan ke API pembayaran jika tersedia
                    // Untuk contoh, kita langsung resolve saja
                    resolve(true);
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                processPayment();
            }
        });
    }
}

// Fungsi processPayment yang sudah diperbaiki

async function processPayment() {
    const cart = getCart();
    if (cart.length === 0) {
        Swal.fire("Keranjang kosong!", "Tambahkan produk terlebih dahulu.", "warning");
        return;
    }

    const totalPrice = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
    const paymentMethod = document.getElementById("payment_method").value;
    const amountPaid = parseInt(document.getElementById("amount-paid")?.value?.replace(/\D/g, "") || 0);
    const change = amountPaid - totalPrice;

    // Validasi pembayaran tunai
    if (paymentMethod === "cash" && amountPaid < totalPrice) {
        Swal.fire("Pembayaran kurang!", `Kurang Rp ${(totalPrice - amountPaid).toLocaleString()}`, "error");
        return;
    }

    try {
        // Tampilkan loading
        Swal.fire({
            title: 'Memproses Pembayaran',
            html: 'Mohon tunggu...<br><small>Jangan tutup halaman ini</small>',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        // Log data untuk debugging
        console.log("Data transaksi yang dikirim:", cart);

        // Kirim data transaksi
        const transactionResponse = await fetch(transactionUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                total: totalPrice,
                payment_method: paymentMethod,
                amount_paid: paymentMethod === "cash" ? amountPaid : totalPrice,
                change: paymentMethod === "cash" ? change : 0,
                items: cart.map(item => ({
                    product_id: item.id,
                    quantity: item.quantity,
                    price: item.price,
                    name: item.name,
                    size: item.size || "" // Pastikan size selalu dikirim, bahkan jika null
                }))
            })
        });

        // Handle response non-JSON
        const contentType = transactionResponse.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await transactionResponse.text();
            throw new Error(`Response tidak valid: ${text.substring(0, 100)}...`);
        }

        const transactionData = await transactionResponse.json();

        if (!transactionResponse.ok || !transactionData.success) {
            throw new Error(transactionData.message || 'Gagal memproses transaksi');
        }

        // Cetak struk
        const printSuccess = await printThermalReceipt(cart, totalPrice, paymentMethod, amountPaid, change);
        
        // Bersihkan keranjang hanya jika semuanya sukses
        localStorage.removeItem("cart");
        loadCart();

        // Tampilkan notifikasi sukses
        Swal.fire({
            title: "Sukses!",
            text: "Transaksi berhasil diproses" + (printSuccess ? " dan struk dicetak" : ""),
            icon: "success",
            timer: 3000
        });

    } catch (error) {
        console.error("Error:", error);
        
        let errorMessage = error.message;
        if (error.message.includes('session') || error.message.includes('login')) {
            errorMessage += '. Silakan refresh halaman dan login kembali';
        }

        Swal.fire({
            title: "Error!",
            html: `<div style="text-align:left">
                     <p>${errorMessage}</p>
                     <small>Jika masalah berlanjut, hubungi admin</small>
                   </div>`,
            icon: "error"
        });
    }
}
// Fungsi updateQRCode yang telah dimodifikasi (hapus QR code dari halaman utama)
function updateQRCode() {
    const paymentMethod = document.getElementById("payment_method").value;
    const qrcodeContainer = document.getElementById("qrcode-container");
    const amountPaidContainer = document.getElementById("amount-paid-container");
    const changeContainer = document.getElementById("change-container");

    // Kosongkan container QR code
    qrcodeContainer.innerHTML = "";

    if (paymentMethod === "cash") {
        amountPaidContainer.style.display = "block";
        changeContainer.style.display = "block";
    } else {
        amountPaidContainer.style.display = "none";
        changeContainer.style.display = "none";
        
        // Tidak menampilkan QR code di halaman utama lagi
        // QR code akan ditampilkan di modal saat konfirmasi
    }
}

// Fungsi printThermalReceipt yang lebih robust
// Fungsi untuk mengirim data ke printer thermal
async function printThermalReceipt(cart, totalPrice, paymentMethod, amountPaid, change) {
    try {
        // Log untuk debugging
        console.log("Mengirim data ke printer:", cart);
        
        const response = await fetch(printReceiptUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                items: cart.map(item => ({
                    name: item.name.substring(0, 30), // Batasi panjang nama
                    quantity: item.quantity,
                    price: item.price,
                    size: item.size || "" // Pastikan size selalu dikirim
                })),
                total: totalPrice,
                payment_method: paymentMethod,
                amount_paid: amountPaid,
                change: Math.max(change, 0), // Pastikan tidak negatif
                print: true
            })
        });

        // Handle response non-JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            throw new Error(`Printer response tidak valid: ${text.substring(0, 100)}...`);
        }

        const data = await response.json();

        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Gagal mencetak struk');
        }

        return true;

    } catch (error) {
        console.error("Gagal cetak thermal:", error);
        
        // Tawarkan opsi cetak alternatif
        const result = await Swal.fire({
            title: 'Printer Error',
            html: `<div style="text-align:left">
                     <p>${error.message}</p>
                     <small>Silakan coba cetak melalui browser atau hubungi admin</small>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Cetak via Browser',
            cancelButtonText: 'Tutup',
            focusConfirm: false
        });

        if (result.isConfirmed) {
            prepareReceiptForPrint(cart, totalPrice, paymentMethod, amountPaid, change);
            await printReceipt();
            return true;
        }

        return false;
    }
}
// Fungsi untuk menangani fallback printing
function handlePrintFallback(errorMessage) {
    console.warn("Thermal printer failed:", errorMessage);
    Swal.fire({
        title: 'Error Printer',
        text: 'Cetak menggunakan printer browser?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Cetak',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        if (result.isConfirmed) {
            setTimeout(() => printReceipt(), 500);
        } else {
            Swal.fire({
                title: "Transaksi Berhasil!",
                text: "Transaksi selesai tanpa cetak struk.",
                icon: "success",
                timer: 2000
            });
        }
    });
}

async function printReceipt() {
    return new Promise((resolve) => {
        const printContent = document.getElementById("printable-receipt").innerHTML;
        
        const printWindow = window.open('', '_blank', 'width=600,height=600');
        if (!printWindow) {
            Swal.fire("Error", "Browser memblokir popup. Izinkan popup untuk mencetak.", "error");
            return resolve(false);
        }

        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Struk Belanja</title>
                <style>
                    @page {
                        size: 58mm auto;
                        margin: 0;
                    }
                    body {
                        width: 58mm;
                        margin: 0;
                        padding: 2mm;
                        font-family: 'Courier New', monospace;
                        font-size: 12px;
                    }
                    img {
                        max-width: 100%;
                        height: auto;
                    }
                    .divider {
                        border-top: 1px dashed #000;
                        margin: 5px 0;
                    }
                </style>
            </head>
            <body>${printContent}</body>
            </html>
        `);
        
        printWindow.document.close();
        
        // Tunggu konten dimuat
        printWindow.onload = function() {
            try {
                setTimeout(() => {
                    printWindow.focus();
                    printWindow.print();
                    
                    // Tutup window setelah cetak
                    setTimeout(() => {
                        printWindow.close();
                        resolve(true);
                    }, 1000);
                }, 500);
            } catch (e) {
                console.error("Print error:", e);
                printWindow.close();
                resolve(false);
            }
        };
    });
}
        // Receipt function for direct printing
      // Receipt function for direct printing
// Fungsi prepareReceiptForPrint yang lebih baik
function prepareReceiptForPrint(cart, totalPrice, paymentMethod, amountPaid, change) {
    const printReceiptItems = document.getElementById("print-receipt-items");
    printReceiptItems.innerHTML = "";
    
    // Batasi panjang nama produk dan format angka
    cart.forEach(item => {
        const itemName = item.name.length > 20 ? item.name.substring(0, 17) + '...' : item.name;
        const itemTotal = item.price * item.quantity;
        
        printReceiptItems.innerHTML += `
            <div style="display: flex; justify-content: space-between; margin: 2px 0;">
                <span>${item.quantity}x ${itemName} (${item.size})</span>
                <span>Rp${itemTotal.toLocaleString('id-ID')}</span>
            </div>
        `;
    });

    // Format metode pembayaran
    const paymentMethods = {
        cash: "TUNAI",
        shopee_pay: "SHOPEE PAY",
        dana: "DANA"
    };
    
    document.getElementById("print-receipt-method").textContent = paymentMethods[paymentMethod] || paymentMethod;
    document.getElementById("print-receipt-total").textContent = `Rp${totalPrice.toLocaleString('id-ID')}`;
    
    // Format uang dibayar dan kembalian
    const paidAmount = paymentMethod === "cash" ? amountPaid : totalPrice;
    const changeAmount = paymentMethod === "cash" ? Math.max(change, 0) : 0;
    
    document.getElementById("print-receipt-paid").textContent = `Rp${paidAmount.toLocaleString('id-ID')}`;
    document.getElementById("print-receipt-change").textContent = `Rp${changeAmount.toLocaleString('id-ID')}`;
}
        
        function initializeProductsIfEmpty() {
            const products = getProducts();
            
            if (products.length === 0) {
                console.warn("Produk tidak ditemukan di localStorage. Pastikan data produk diinisialisasi dari menu.blade.php.");
            }
        }
        
        // Initialize on page load
        document.addEventListener("DOMContentLoaded", function() {
            initializeProductsIfEmpty();
            syncCartWithMenu();
            loadCart();
            updateQRCode();
        });

        function formatToRupiah(input) {
    let value = input.value.replace(/\D/g, "");
    if (!value) {
        input.value = "";
        return;
    }
    value = parseInt(value, 10);
    input.value = "Rp " + value.toLocaleString("id-ID");
    calculateChange();
}

function removeNonNumeric(input) {
    input.value = input.value.replace(/\D/g, "");
    calculateChange();
}

        function removeNonNumeric(input) {
            input.value = input.value.replace(/\D/g, ""); // Hapus format saat input kehilangan fokus
            calculateChange(); // Panggil fungsi untuk menghitung kembalian
        }
    </script>
</body>
</html>