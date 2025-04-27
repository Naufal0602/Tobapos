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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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
            .dataTables_length, .dataTables_filter, .dataTables_paginate, .dataTables_info {
                display: none !important;
            }
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            margin-left: 0.5rem;
        }
        /* Custom style for search inputs */
        .search-input-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
            margin-bottom: 1rem;
        }
        .search-input {
            flex: 1 1 150px;
            min-width: 120px;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }
        @media (max-width: 640px) {
            .search-input-container {
                flex-direction: column;
                align-items: stretch;
            }
            .search-input {
                width: 100%;
                height: 90px !important;
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
            <!-- Search Inputs Container -->
            <div class="search-input-container">
                <button onclick="printTable()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Print
                </button>
                <input type="text" id="searchName" placeholder="Cari nama..." class="search-input">
                <input type="text" id="searchEmail" placeholder="Cari email..." class="search-input">
                <button onclick="window.location.reload()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Reset
                </button>
            </div>

            <div class="overflow-x-auto" id="printArea">
                <table class="w-full border-collapse border border-gray-300 stripe hover" id="contacts-table">
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
                            <tr>
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
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">
                                    <div class="flex justify-center space-x-2">
                                        <button onclick="showFullMessage('{{ addslashes($contact->message) }}')" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg text-xs md:text-sm">
                                            <i class='bx bx-show'></i>
                                        </button>
                                        <form action="{{ route('dashboard.contact.destroy', $contact->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg text-xs md:text-sm">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#contacts-table').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                },
                dom: '<"flex flex-col md:flex-row md:justify-between"<"mb-4"l><"mb-4"f>>rt<"flex flex-col md:flex-row md:justify-between"<"mb-4"i><"mb-4"p>>',
                initComplete: function() {
                    // Apply search for name and email when inputs change
                    $('#searchName').on('keyup', function() {
                        table.columns(1).search(this.value).draw();
                    });
                    
                    $('#searchEmail').on('keyup', function() {
                        table.columns(2).search(this.value).draw();
                    });
                }
            });
        });

        function showFullMessage(message) {
            Swal.fire({
                title: 'Pesan Lengkap',
                text: message,
                icon: 'info',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#B689B0'
            });
        }

        function printTable() {
            window.print();
        }
        
        document.addEventListener('DOMContentLoaded', function () {
        // Attach SweetAlert to delete buttons
        document.querySelectorAll('form.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Pesan ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    });

        @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#B689B0'
        });
        @endif
    </script>
</body>
</html>