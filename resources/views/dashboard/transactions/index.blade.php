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
</head>
<body class="" style="background:#F5E6F0;"> 

    @include('layouts.sidebar')
    @include('layouts.navbar')

    <div class="ml-0 sm:ml-60 p-3 md:p-6">
        <h2 class="text-2xl md:text-4xl font-bold mb-4">Transaksi</h2>

        <div class="bg-white p-3 md:p-6 rounded-lg shadow-md">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gradient-to-b from-[#D5A4CF] to-[#B689B0]">
                        <tr>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Produk</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Kuantitas</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Harga</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Subtotal</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        @foreach($transactions as $index => $transaction)
                            <tr>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $index * 2 + 1 }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $transaction->product }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $transaction->quantity }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $transaction->price }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $transaction->subtotal }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $transaction->action }}</td>
                            </tr>
                        @endforeach
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
            
            <!-- Tempat QR Code -->
            <div id="qrcode-container" class="mt-4 flex justify-center"></div>
            <p class="text-base md:text-lg font-semibold mt-4">Total: <span id="total-price">Rp 0</span></p>
            
            <!-- Uang Dibayarkan -->
            <div id="amount-paid-container" class="mt-4">
                <label for="amount-paid" class="block font-semibold text-sm md:text-base">Uang Dibayarkan</label>
                <input type="number" id="amount-paid" class="w-full p-2 border rounded-lg mt-2 text-sm md:text-base" oninput="calculateChange()">
            </div>

            <!-- Kembalian -->
            <p id="change-container" class="text-base md:text-lg font-semibold mt-4">Kembalian: <span id="change-amount">Rp 0</span></p>

            <div class="mt-4 text-right">
                <button onclick="confirmPayment()" class="bg-blue-500 text-white p-2 md:p-3 rounded-lg hover:bg-blue-700 text-sm md:text-base">
                    Bayar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Struk - Responsive -->
    <div id="receipt-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden p-4">
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-full max-w-xs md:max-w-sm text-center">
            <div class="p-4 " id="receipt-content">
                <div><img src="{{ asset('img/logo-v3.png') }}" alt="" class="w-10 h-10 justify-start"></div>
                <div class="border-b pb-4 mb-4">
                    <h2 class="text-lg font-bold">Eceu Bako</h2>
                    <p class="text-xs md:text-sm">Jl. Pintu Ledeng, Ciomas, Kabupaten Bogor, Jawa Barat 16610</p>
                </div>
                <div class="text-left mb-4 text-sm" id="receipt-items">
                </div>
                <div class="text-left border-t pt-2 text-sm">
                    <p><strong>Metode Pembayaran:</strong> <span class="float-right" id="receipt-method"></span></p>
                    <p><strong>Subtotal:</strong> <span class="float-right" id="receipt-total"></span></p>
                    <p><strong>Cash:</strong> <span class="float-right" id="receipt-paid"></span></p>
                    <p><strong>Kembali:</strong> <span class="float-right" id="receipt-change"></span></p>
                </div>
                
                <div class="border-t pt-4 mt-4 text-center">
                    <p class="text-xs md:text-sm font-semibold">Terima kasih telah berbelanja di toko kami!</p>
                </div>
            </div>
            <div class="mt-4 flex justify-between">
                <button onclick="downloadReceipt()" class="bg-green-500 text-white px-3 py-1 md:px-4 md:py-2 rounded text-sm">Download</button>
                <button onclick="closeReceipt()" class="bg-red-500 text-white px-3 py-1 md:px-4 md:py-2 rounded text-sm">Tutup</button>
            </div>
        </div>
    </div>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        const transactionUrl = @json(route('dashboard.transactions.store'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function loadCart() {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            console.log("Loaded cart from localStorage:", cart); // Debug log
            let cartContainer = document.getElementById("cart-items");
            let totalPrice = 0;

            if (!cartContainer) return;
            cartContainer.innerHTML = "";

            cart.forEach((item, index) => {
                console.log("Processing item:", item); // Debug log
                totalPrice += item.price * item.quantity;
                cartContainer.innerHTML += `
                    <tr>
                        <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">${item.name}</td>
                        <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">
                            <button onclick="changeQuantity(${index}, -1)" class="px-1 md:px-2 bg-red-500 text-white rounded text-xs md:text-base">-</button>
                            <span class="mx-1 md:mx-2">${item.quantity}</span>
                            <button onclick="changeQuantity(${index}, 1)" class="px-1 md:px-2 bg-green-500 text-white rounded text-xs md:text-base">+</button>
                        </td>
                        <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Rp ${item.price.toLocaleString()}</td>
                        <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Rp ${(item.price * item.quantity).toLocaleString()}</td>
                        <td class="border px-2 py-1 md:px-4 md:py-2 text-center text-xs md:text-base">
                            <button onclick="removeItem(${index})" class="text-red-500">Hapus</button>
                        </td>
                    </tr>`;
            });

            document.getElementById("total-price").textContent = `Rp ${totalPrice.toLocaleString()}`;
        }

        function changeQuantity(index, amount) {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            if (cart[index]) {
                cart[index].quantity += amount;
                if (cart[index].quantity <= 0) cart.splice(index, 1);
                localStorage.setItem("cart", JSON.stringify(cart));
                loadCart();
            }
        }

        function removeItem(index) {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            cart.splice(index, 1);
            localStorage.setItem("cart", JSON.stringify(cart));
            loadCart();
        }

        function updateStock(productId, quantity) {
    try {
        console.log(`Starting updateStock for productId=${productId}, quantity=${quantity}`);
        
        if (!productId) {
            console.error("Invalid product ID:", productId);
            return;
        }

        // Get products data
        const productsData = localStorage.getItem("products");
        console.log("Raw products data:", productsData);
        
        if (!productsData) {
            console.warn("No products data in localStorage");
            return;
        }
        
        let products;
        try {
            products = JSON.parse(productsData);
        } catch (parseError) {
            console.error("Failed to parse products data:", parseError);
            return;
        }
        
        // Check data structure
        if (!products) {
            console.error("Products is null or undefined after parsing");
            return;
        }
        
        if (!Array.isArray(products)) {
            console.error("Products is not an array. Type:", typeof products);
            
            // If it's an object with numeric keys, convert to array
            if (typeof products === 'object') {
                try {
                    const productsArray = Object.values(products);
                    console.log("Converted products object to array:", productsArray);
                    products = productsArray;
                } catch (convError) {
                    console.error("Failed to convert products to array:", convError);
                    return;
                }
            } else {
                return;
            }
        }
        
        // Find the product
        const product = products.find(item => {
            console.log("Checking product:", item);
            return item && item.id == productId; // Use loose equality for string/number comparison
        });
        
        if (!product) {
            console.warn(`Product with ID ${productId} not found`);
            return;
        }
        
        // Update the stock
        console.log(`Current stock for ${productId}: ${product.stock}`);
        product.stock = Math.max(0, product.stock - quantity);
        console.log(`New stock for ${productId}: ${product.stock}`);
        
        // Save back to localStorage
        localStorage.setItem("products", JSON.stringify(products));
        console.log("Successfully updated product stock");
        
    } catch (error) {
        console.error("Error in updateStock:", error);
    }
}

    function processPayment() {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        if (cart.length === 0) {
            Swal.fire("Keranjang kosong!", "Tambahkan produk terlebih dahulu.", "warning");
            return;
    }

    try {
        let totalPrice = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
        let paymentMethod = document.getElementById("payment_method").value;
        let amountPaid = parseInt(document.getElementById("amount-paid")?.value || 0);
        let change = amountPaid - totalPrice;

        if (paymentMethod === "cash" && amountPaid < totalPrice) {
            Swal.fire("Pembayaran kurang!", "Pastikan pelanggan membayar cukup.", "error");
            return;
        }

        // Add a loading indicator
        Swal.fire({
            title: 'Memproses Pembayaran',
            text: 'Mohon tunggu...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Prepare payload
        const payload = {
            total: totalPrice,
            payment_method: paymentMethod,
            amount_paid: paymentMethod === "cash" ? amountPaid : totalPrice, 
            change: paymentMethod === "cash" ? change : 0,
            items: cart.map(item => ({
                product_id: item.id,
                quantity: item.quantity,
                price: item.price,
            })),
        };

        console.log("Sending transaction payload:", payload);
        console.log("Transaction URL:", transactionUrl);

        // Use async/await for cleaner error handling
        (async () => {
            try {
                const response = await fetch(transactionUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(payload)
                });

                // Log the raw response for debugging
                console.log("Raw response:", response);

                // Check if the response is ok (status 200-299)
                if (!response.ok) {
                    throw new Error(`Server responded with status: ${response.status}`);
                }

                const data = await response.json();
                console.log("Response data:", data);

                if (data.success) {
                    // Only update stock after success confirmation
                    try {
                        cart.forEach(item => {
                            console.log(`Updating stock for item: ${item.id}`);
                            updateStock(item.id, item.quantity);
                        });
                    } catch (stockError) {
                        console.error("Error updating stock:", stockError);
                        // Continue with receipt even if stock update fails
                    }

                    showReceipt(cart, totalPrice, paymentMethod, amountPaid, change);
                    
                    Swal.fire({
                        title: "Pembayaran Berhasil!",
                        text: data.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        localStorage.removeItem("cart");
                        loadCart();
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: data.message || "Terjadi kesalahan pada sistem.",
                        icon: "error"
                    });
                }
            } catch (error) {
                console.error("Transaction error:", error);
                Swal.fire({
                    title: "Error!",
                    text: "Terjadi kesalahan pada sistem. Detail: " + error.message,
                    icon: "error"
                });
            }
        })();
    } catch (error) {
        console.error("Error in processPayment:", error);
        Swal.fire("Error!", "Terjadi kesalahan: " + error.message, "error");
    }
}

        function confirmPayment() {
            Swal.fire({
                title: "Konfirmasi Pembayaran",
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
        }

        document.addEventListener("DOMContentLoaded", loadCart);

        function showReceipt(cart, totalPrice, paymentMethod, amountPaid, change) {
            document.getElementById("receipt-method").textContent = paymentMethod;
            document.getElementById("receipt-total").textContent = `Rp ${totalPrice.toLocaleString()}`;
            document.getElementById("receipt-paid").textContent = `Rp ${amountPaid.toLocaleString()}`;
            document.getElementById("receipt-change").textContent = `Rp ${change.toLocaleString()}`;

            let receiptItems = document.getElementById("receipt-items");
            receiptItems.innerHTML = "";
            cart.forEach(item => {
                receiptItems.innerHTML += `<li>${item.quantity}x ${item.name} - Rp ${item.price.toLocaleString()}</li>`;
            });

            document.getElementById("receipt-modal").classList.remove("hidden");
        }

        function closeReceipt() {
            document.getElementById("receipt-modal").classList.add("hidden");
        }

        function printReceipt() {
            let printContent = document.getElementById("receipt-content").innerHTML;
            let originalContent = document.body.innerHTML;
            
            document.body.innerHTML = `<div>${printContent}</div>`;
            window.print();
            document.body.innerHTML = originalContent;
            location.reload();
        }

        function updateQRCode() {
            let paymentMethod = document.getElementById("payment_method").value;
            let qrcodeContainer = document.getElementById("qrcode-container");
            let amountPaidContainer = document.getElementById("amount-paid-container");
            let changeContainer = document.getElementById("change-container");

            qrcodeContainer.innerHTML = ""; // Kosongkan QR Code sebelumnya

            if (paymentMethod === "cash") {
                amountPaidContainer.style.display = "block"; // Tampilkan input uang jika tunai
                changeContainer.style.display = "block";
            } else {
                amountPaidContainer.style.display = "none"; // Sembunyikan jika non-tunai
                changeContainer.style.display = "none";

                let qrUrls = {
                    shopee_pay: "{{ asset('img/qrcode-shopeepay.png') }}",
                    dana: "{{ asset('img/qrcode-dana.png') }}"
                };

                if (qrUrls[paymentMethod]) {
                    qrcodeContainer.innerHTML = `
                        <img src="${qrUrls[paymentMethod]}" alt="QR Code ${paymentMethod}" class="w-24 h-24 md:w-32 md:h-32 mx-auto">
                    `;
                }
            }
        }

        function calculateChange() {
            let totalPrice = parseInt(document.getElementById("total-price").textContent.replace(/\D/g, "")) || 0;
            let amountPaid = parseInt(document.getElementById("amount-paid").value) || 0;
            let change = amountPaid - totalPrice;

            document.getElementById("change-amount").textContent = "Rp " + (change >= 0 ? change.toLocaleString() : "0");
        }

        function downloadReceipt() {
        html2canvas(document.querySelector("#receipt-content")).then(canvas => {
        let link = document.createElement('a');
        link.href = canvas.toDataURL();
        link.download = 'receipt.png';
        link.click();
    });
}

        // Initialize QR code display
        document.addEventListener("DOMContentLoaded", function() {
            updateQRCode();
        });
    </script>
</body>
</html>