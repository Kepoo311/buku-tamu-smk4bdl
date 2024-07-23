<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.png')}}">
    {{-- @vite('resources/css/app.css') --}}
    <link rel="stylesheet" href="{{asset('css/build.css')}}">
    <title>{{ Request::is('admin') ? 'Dashboard Admin' : 'Buku Tamu' }}</title>
</head>

<body>
    @include('fragments.header')
    <main id="body-home" class="header">
        <div class="header-container min-h-screen flex flex-col-reverse md:flex-row-reverse items-center px-10 container m-auto">
            <div class="px-8 py-6 w-full md:w-3/6 mt-20 md:mt-1">
                <form id="form_list" action="/add/data" method="POST" enctype="multipart/form-data">
                    @csrf

                  <div class="mb-4">
                      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                          Nama lengkap
                      </label>
                      <input name="nama_lengkap"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                          id="Nama_lengkap" type="text" placeholder="Nama lengkap" required>
                  </div>
                  <div class="mb-4">
                      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                          Instansi
                      </label>
                      <input name="asal_tamu"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                          id="asal_tamu" type="text" placeholder="Ex. SMK 4/Pt. Mencari jodoh" required>
                  </div>
                  <div class="mb-4">
                      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                          Bertemu
                      </label>
                      <input name="menemui"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                          id= "menemui" type="text" placeholder="Ex. Pak John" required>
                  </div>
                  <div class="mb-4">
                      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                          Keperluan
                      </label>
                      <textarea name="alasan" placeholder="Alasan saya adalah..."
                          class="resize-none rounded-md shadow appearance-none border w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                          required></textarea>
                  </div>
                  <div class="mb-4">
                    <p class="text-sm font-bold">Ambil Foto:</p>
                    <input type="hidden" id="photoInput" name="foto_tamu">
                    <video id="video" width="320" height="240" autoplay></video>
                    <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
                    <img id="photo" src="#" alt="Your photo" style="display: none;">
                  </div>
                  <button type="button" id="captureBtn"
                  class="px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">Ambil
                  Foto</button>
              <button type="button" id="submitBtn" data-bs-dismiss="modal"
                  class="hidden px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">Kirim</button>
                </form>

            </div>
            <div class="h-full w-full mt-24 md:mt-0 md:w-3/6">
                <h1 id="typed" class="text-2xl mt-2 md:mt-0 sm:text-4xl md:text-6xl font-bold leading-tight">
                </h1>
                <p class="text-gray-600 mb-6 mt-2">Terima kasih atas kunjungan Anda ke SMK 4. Silakan catat kehadiran
                    Anda.</p>
                <p class="mx-40 text-xl font-bold">Terkoneksi dengan pusat</p>
            </div>

        </div>
    </main>
    {{-- modal start --}}
    <div class="hidden" id="modalList">
        @include('fragments.modal.modal-list-tamu')
    </div>
    {{-- modal end --}}

    @include('fragments.footer')
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/modal.js')}}"></script>
    <script src="{{asset('js/validasiForm.js')}}"></script>
    <script src="{{asset('js/ambil_foto.js')}}"></script>
    <script>
        navigator.mediaDevices
        .getUserMedia({
            video: true,
        })
        .then(function (stream) {
            var video = document.getElementById("video");
            video.srcObject = stream;
            video.play();
        })
        .catch(function (err) {
            console.log("Gagal mengakses kamera: " + err);
        });
    </script>
    <script>
        const nav = document.getElementById("nav");
        const menu = document.querySelector(".menu")
        window.addEventListener("scroll", () => {
            let offset = window.pageYOffset;
            if (offset > 50) {
                if (!nav.classList.contains("nav-bg-show")) {
                    nav.classList.add("nav-bg-show")
                }
            } else {
                if (nav.classList.contains("nav-bg-show")) {
                    nav.classList.remove("nav-bg-show")
                }
            }
        })

        const navOpen = () => menu.classList.add("active");
        const navClose = () => menu.classList.remove("active");

       


        var typed = new Typed('#typed', {
            strings: ["Selamat Datang di SMKN 4!",
                "Silakan Catat Kehadiran Anda",
                "SMKN 4 - SMK Pusat Keunggulan",
                "Masukkan Data Kunjungan Anda",
                "Terima Kasih Telah Berkunjung ke SMKN 4"
            ],
            typeSpeed: 50,
            backSpeed: 25,
            loop: true,
            showCursor: false,
        });

        let succ = {{ session()->has('succ') ? 1 : 0 }}
        let succMsg = @json(session('succ'))

        let error = {{ session()->has('error') ? 1 : 0 }}
        let errorMsg = @json(session('error'))

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

        if (succ) {
            Toast.fire({
                icon: 'info',
                title: succMsg,
            })
        }

        if (error) {
            Toast.fire({
                icon: 'error',
                title: errorMsg,
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
