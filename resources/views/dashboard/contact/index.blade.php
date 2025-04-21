<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kontak</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
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
        }
    </style>
</head>
<body class="" style="background:#F5E6F0;"> 

    @include('layouts.sidebar')
    @include('layouts.navbar')

    <div class="ml-0 sm:ml-60 p-3 md:p-6">
        <h2 class="text-2xl md:text-4xl font-bold mb-4">Kontak</h2>

        <div class="bg-white p-3 md:p-6 rounded-lg shadow-md">
            <div class="mb-4 flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4">
                <input type="text" id="searchName" placeholder="Cari nama..." class="px-4 py-2 border rounded-lg shadow-md">
                <input type="text" id="searchEmail" placeholder="Cari email..." class="px-4 py-2 border rounded-lg shadow-md">
                <button onclick="filterContacts()" class="bg-purple-500 text-white px-4 py-2 rounded-lg">Filter</button>
                <button onclick="printTable()" class="bg-blue-500 text-white px-4 py-2 rounded-lg justify-end">Print</button>
            </div>

            <div class="overflow-x-auto" id="printArea">
                <table class="w-full border-collapse border border-gray-300" id="contacts-table">
                    <thead class="bg-gradient-to-b from-[#D5A4CF] to-[#B689B0]">
                        <tr>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">No</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Nama</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Email</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Pesan</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Tanggal</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $index => $contact)
                            <tr class="contact-row">
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $index + 1 }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $contact->name }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $contact->email }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">
                                    {{ Str::limit($contact->message, 50) }}
                                    @if(strlen($contact->message) > 50)
                                        <button class="text-blue-500 hover:underline" onclick="showFullMessage('{{ addslashes($contact->message) }}')">Selengkapnya</button>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $contact->created_at->format('d-m-Y') }}</td>
                            </div>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">
                                    <div class="flex justify-center space-x-2">
                                        <button onclick="showFullMessage('{{ addslashes($contact->message) }}')" class="bg-blue-500 text-white px-2 py-1 rounded-lg text-xs md:text-sm">
                                            <i class='bx bx-show'></i>
                                        </button>
                                        <form action="{{ route('dashboard.contact.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-lg text-xs md:text-sm">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr id="noDataRow" class="hidden">
                            <td colspan="6" class="text-center py-4">Tidak ada kontak</td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>

    <script>
        function showFullMessage(message) {
            Swal.fire({
                title: 'Pesan Lengkap',
                text: message,
                icon: 'info',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#B689B0'
            });
        }

        function filterContacts() {
            let searchName = document.getElementById("searchName").value.toLowerCase();
            let searchEmail = document.getElementById("searchEmail").value.toLowerCase();
            let rows = document.querySelectorAll(".contact-row");
            let visibleRows = 0;

            rows.forEach(row => {
                let name = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
                let email = row.querySelector("td:nth-child(3)").textContent.toLowerCase();
                let showRow = true;

                if (searchName && !name.includes(searchName)) {
                    showRow = false;
                }
                if (searchEmail && !email.includes(searchEmail)) {
                    showRow = false;
                }

                row.style.display = showRow ? "table-row" : "none";
                if (showRow) {
                    visibleRows++;
                }
            });

            document.getElementById("noDataRow").style.display = visibleRows ? "none" : "table-row";
        }

        function printTable() {
            window.print();
        }
    </script>
</body>
</html>