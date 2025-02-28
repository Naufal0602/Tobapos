<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('input.css') }}">
</head>
<body class="bg-gray-100">

    <!-- Include the Sidebar and Header Components -->
    @include('layouts.sidebar')
    @include('layouts.navbar') 

    <div class="ml-60 p-6">
        <div class="mt-4 text-right">
            <button onclick="downloadReceipt()" class="bg-green-500 text-white p-2 rounded-lg">Download Struk</button>
        </div>
    </div>

</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script>
    function downloadReceipt() {
        html2canvas(document.querySelector("#receipt-content")).then(canvas => {
            let link = document.createElement('a');
            link.href = canvas.toDataURL();
            link.download = 'receipt.png';
            link.click();
        });
    }
</script>

