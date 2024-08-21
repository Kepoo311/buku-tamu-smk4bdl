<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- @vite('resources/css/app.css') --}}
    <link rel="stylesheet" href="{{asset('css/build.css')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.png')}}">
    <title>Admin Login</title>
</head>

<body>
    <section class="flex w-full h-dvh justify-center items-center">
        <div class="w-[35rem] h-fit bg-white shadow-lg border rounded-lg flex flex-col">
            <h1 class="text-center font-semibold text-3xl mt-2">Login</h1>
            <form action="/login" method="POST" >
                @csrf
                <div class="mb-3 pt-10 px-7">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                    <input type="text" id="name" name="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="John" value="{{ old('name') }}" required />
                    @error('name')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3 px-7 relative">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                    <div class="flex items-center">
                        <input type="password" id="password" name="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Enter your password" required />
                        <button type="button" id="togglePassword"
                            class="absolute right-8 bg-transparent border-none text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="m4 15.6 3.055-3.056A4.913 4.913 0 0 1 7 12.012a5.006 5.006 0 0 1 5-5c.178.009.356.027.532.054l1.744-1.744A8.973 8.973 0 0 0 12 5.012c-5.388 0-10 5.336-10 7A6.49 6.49 0 0 0 4 15.6Z" />
                                <path
                                    d="m14.7 10.726 4.995-5.007A.998.998 0 0 0 18.99 4a1 1 0 0 0-.71.305l-4.995 5.007a2.98 2.98 0 0 0-.588-.21l-.035-.01a2.981 2.981 0 0 0-3.584 3.583c0 .012.008.022.01.033.05.204.12.402.211.59l-4.995 4.983a1 1 0 1 0 1.414 1.414l4.995-4.983c.189.091.386.162.59.211.011 0 .021.007.033.01a2.982 2.982 0 0 0 3.584-3.584c0-.012-.008-.023-.011-.035a3.05 3.05 0 0 0-.21-.588Z" />
                                <path
                                    d="m19.821 8.605-2.857 2.857a4.952 4.952 0 0 1-5.514 5.514l-1.785 1.785c.767.166 1.55.25 2.335.251 6.453 0 10-5.258 10-7 0-1.166-1.637-2.874-2.179-3.407Z" />
                            </svg>

                        </button>
                    </div>
                    @error('password')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="px-7 pt-5 mb-5">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-full focus:outline-none">Login</button>
                </div>

            </form>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the eye icon
            this.querySelector('svg').classList.toggle('hidden');
        });

        let error = {{ session()->has('failed') ? 1 : 0 }}
        let errorMsg = @json(session('failed'))

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
        });

        if (error) {
            Toast.fire({
                icon: 'error',
                title: errorMsg,
            })
        }
    </script>

    <style>
        /* Hide the second SVG initially */
        #togglePassword svg:nth-child(2) {
            display: none;
        }

        /* Show the second SVG when the password is visible */
        #password[type="text"]~#togglePassword svg:nth-child(2) {
            display: block;
        }

        /* Hide the first SVG when the password is visible */
        #password[type="text"]~#togglePassword svg:nth-child(1) {
            display: none;
        }

        .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
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
