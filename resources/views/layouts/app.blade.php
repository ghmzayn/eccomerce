<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Qios - Toko Online Terpercaya')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-stone-50 text-stone-800">
    <nav class="bg-white shadow-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-2xl font-bold" style="color: #0D9488;">Qios</span>
                </a>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-[#0D9488] transition font-medium">Home</a>
                    <a href="{{ route('categories.index') }}" class="hover:text-[#0D9488] transition font-medium">Kategori</a>
                    <a href="{{ route('pages.cara-pembelian') }}" class="hover:text-[#0D9488] transition font-medium">Cara Pembelian</a>
                    <a href="{{ route('pages.tentang-kami') }}" class="hover:text-[#0D9488] transition font-medium">Tentang Kami</a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('cart.index') }}" class="relative p-2 hover:text-[#0D9488] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                            </svg>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ count(session('cart')) }}</span>
                            @endif
                        </a>

                        <div class="relative group">
                            <button class="flex items-center space-x-1 hover:text-[#0D9488] transition font-medium">
                                <span>{{ auth()->user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-stone-100">Profil</a>
                                    <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm hover:bg-stone-100">Pesanan Saya</a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-stone-100 text-[#0D9488] font-semibold">Dashboard Admin</a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-stone-100">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="font-medium hover:text-[#0D9488] transition">Login</a>
                        <a href="{{ route('register') }}" class="bg-[#0D9488] text-white px-4 py-2 rounded-lg hover:bg-[#0f766e] transition font-medium">Register</a>
                    @endauth
                </div>

                <button id="mobile-menu-btn" class="md:hidden p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden border-t">
            <div class="px-4 py-2 space-y-2">
                <a href="{{ route('home') }}" class="block py-2 hover:text-[#0D9488]">Home</a>
                <a href="{{ route('categories.index') }}" class="block py-2 hover:text-[#0D9488]">Kategori</a>
                <a href="{{ route('pages.cara-pembelian') }}" class="block py-2 hover:text-[#0D9488]">Cara Pembelian</a>
                <a href="{{ route('pages.tentang-kami') }}" class="block py-2 hover:text-[#0D9488]">Tentang Kami</a>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-stone-900 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Qios</h3>
                    <p class="text-stone-200">Toko online terpercaya. Belanja mudah, aman, dan menyenangkan.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Menu</h4>
                    <ul class="space-y-2 text-stone-200">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('categories.index') }}" class="hover:text-white transition">Kategori</a></li>
                        <li><a href="{{ route('pages.cara-pembelian') }}" class="hover:text-white transition">Cara Pembelian</a></li>
                        <li><a href="{{ route('pages.tentang-kami') }}" class="hover:text-white transition">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-stone-200">
                        <li>Email: hello@copi.com</li>
                        <li>Telepon: 0812-3456-7890</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-stone-400 mt-8 pt-6 text-center text-stone-200">
                &copy; {{ date('Y') }} Qios. All rights reserved.
            </div>
        </div>
    </footer>

    @if(env('WA_NUMBER'))
        <a href="https://wa.me/{{ env('WA_NUMBER') }}?text=Halo%20Qios%2C%20saya%20ada%20pertanyaan" target="_blank" class="fixed bottom-6 right-6 bg-green-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 transition z-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        </a>
    @endif

    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
