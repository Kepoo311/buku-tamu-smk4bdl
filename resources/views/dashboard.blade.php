<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    {{-- @vite('resources/css/app.css') --}}
    <link rel="stylesheet" href="{{asset('css/build.css')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.png')}}">
    <title>Dashboard Admin</title>
</head>

<body>
    @include('fragments.header')
    <div class="w-full px-0 md:px-10 mt-9">

        <form class="flex flex-row" action="{{ route('data-tamu.filter') }}" method="POST">
            @csrf
            <div class="relative max-w-sm mb-6">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input name="date" datepicker type="text" autocomplete="off"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                    placeholder="Select date">
                </div>
                <button type="submit" class="px-6 py-2 w-20 h-10 text-sm font-semibold text-white bg-purple-600 mr-2 rounded-md">Filter</button>
        </form>

        <p class="mx-2 text-xl">*Default hanya menampilkan tamu hari ini</p>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Foto tamu
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama tamu
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tamu dari
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Menemui
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Alasan
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataTamu as $tamu)
                        <tr class="odd:bg-white even:bg-gray-50 border-b">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <img src="{{ asset('img/foto_tamu/' . $tamu->foto_tamu) }}" alt="Foto Tamu"
                                    class="w-20 h-20 rounded-full">
                            </td>
                            <td class="px-6 py-4">{{ $tamu->nama_lengkap }}</td>
                            <td class="px-6 py-4">{{ $tamu->asal_tamu }}</td>
                            <td class="px-6 py-4">{{ $tamu->menemui }}</td>
                            <td class="px-6 py-4">{{ $tamu->alasan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex gap-3 justify-end items-end">
            <form action="{{ route('data-tamu.export-all') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 text-sm font-semibold text-white bg-purple-600 rounded-md">Unduh semua data</button>
            </form>
            <form action="{{ route('data-tamu.export-month') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 text-sm font-semibold text-white bg-purple-600 rounded-md">Unduh data bulan {{date('M')}}</button>
            </form>
        </div>
    </div>

    <script src="js/modal.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>

    <script>

        let emptyData = {{ session()->has('emptyData') ? 1 : 0 }}
        let emptyDataMsg = @json(session('emptyData'))

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });

        if (emptyData) {
            Toast.fire({
                icon: 'error',
                title: emptyDataMsg,
            })
        }
    </script>

    <style>
        .colored-toast.swal2-icon-success {
            background-color: #a5dc86 !important;
        }

        .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
        }

        .colored-toast.swal2-icon-warning {
            background-color: #f8bb86 !important;
        }

        .colored-toast.swal2-icon-info {
            background-color: #3fc3ee !important;
        }

        .colored-toast .swal2-title {
            color: white;
        }

        .colored-toast .swal2-close {
            color: white;
        }

        .colored-toast .swal2-html-container {
            color: white;
        }
    </style>
</body>

</html>
