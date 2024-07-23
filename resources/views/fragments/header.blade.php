<nav class="w-full px-0 md:px-10 py-3 {{ Request::is('admin') ? '' : 'fixed' }} top-0 left-0 right-0 z-10" id="nav">
    <div class="flex justify-between items-center container m-auto px-4 md:px-10">
        <a href="#" class="logo text-md md:text-2xl font-bold flex text-purple-600">
            <img class="w-10 h-10" src="{{asset('img/logosmk.png')}}" alt="">
            <span class="">{{ Request::is('admin') ? 'Dashboard Admin' : 'Buku Tamu' }}</span>
        </a>
        <div class="menu">
            @if (!Request::is('admin'))
                <button class="hidden nav-close-btn mt-4 ml-5 p-1 focus:outline-none" onclick="navClose()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <ul class="flex">
                    <li><a href="#"
                            class="px-4 py-2 mx-1 text-md font-semibold text-gray-800 hover:text-purple-600">Home</a>
                    </li>
                    <li><a href="#"
                            class="px-4 py-2 mx-1 text-md font-semibold text-gray-800 hover:text-purple-600"
                            onclick="modalList()">List tamu</a></li>
                </ul>
            @endif

        </div>
        <div>
            @if (Request::is('admin'))
                <form action="/logout" method="post">
                    @csrf
                    <button
                        class="px-2 md:px-4 py-1 md:py-2 text-sm transition-all font-semibold text-purple-500 hover:text-white hover:bg-purple-500 bg-gray-100 rounded-md">Logout</button>
                </form>
            @else
                <a href="/login"
                    class="px-2 md:px-4 py-1 md:py-2 text-sm transition-all font-semibold text-purple-500 hover:text-white hover:bg-purple-500 bg-gray-100 rounded-md">Admin</a>
            @endif
            <button class="hidden nav-open-btn ml-1 focus:outline-none" onclick="navOpen()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
    </div>
</nav>
