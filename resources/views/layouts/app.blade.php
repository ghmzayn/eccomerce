<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Qios | High-End Editorial Elegance')</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface text-on-surface font-body-md selection:bg-secondary-fixed selection:text-on-secondary-fixed">
<!-- Trust Banner -->
<div class="bg-primary text-on-primary py-2 text-center overflow-hidden">
    <p class="font-label-caps text-[10px] tracking-[0.3em] uppercase opacity-90">Free Shipping on Luxury Orders Above Rp 2.000.000 &bull; Secure Checkout</p>
</div>

<!-- TopNavBar -->
<header class="fixed top-12 left-1/2 -translate-x-1/2 w-[95%] max-w-[1440px] z-50 rounded-full bg-surface/90 backdrop-blur-md border-[0.5px] border-outline-variant/30 shadow-[0_20px_40px_rgba(0,0,0,0.02)] overflow-hidden">
    <nav class="flex justify-between items-center px-10 py-4">
        <a class="font-headline-md text-headline-md tracking-tighter text-primary" href="{{ route('home') }}">Qios</a>

        <div class="hidden md:flex gap-8 items-center">
            <a class="font-label-caps text-[11px] tracking-[0.2em] text-primary border-b border-primary pb-1" href="{{ route('categories.index') }}">SHOP</a>
            <a class="font-label-caps text-[11px] tracking-[0.2em] text-on-surface-variant hover:text-primary transition-colors duration-300" href="{{ route('broadcasts.index') }}">NEW ARRIVALS</a>
            <a class="font-label-caps text-[11px] tracking-[0.2em] text-on-surface-variant hover:text-primary transition-colors duration-300" href="{{ route('categories.index') }}">CATEGORIES</a>
            <a class="font-label-caps text-[11px] tracking-[0.2em] text-on-surface-variant hover:text-primary transition-colors duration-300" href="#">EDITORIAL</a>
        </div>

        <div class="flex items-center gap-6">
            <button class="text-primary hover:opacity-70 transition-opacity" aria-label="Search">
                <span class="material-symbols-outlined font-light">search</span>
            </button>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-primary hover:opacity-70 transition-opacity" aria-label="Account">
                        <span class="material-symbols-outlined font-light">person</span>
                    </a>
                @else
                    <a href="{{ route('profile.edit') }}" class="text-primary hover:opacity-70 transition-opacity" aria-label="Account">
                        <span class="material-symbols-outlined font-light">person</span>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-primary hover:opacity-70 transition-opacity" aria-label="Account">
                    <span class="material-symbols-outlined font-light">person</span>
                </a>
            @endauth
            <a href="{{ route('checkout.index') }}" class="text-primary hover:opacity-70 transition-opacity relative" aria-label="Cart">
                <span class="material-symbols-outlined font-light">shopping_bag</span>
                @if(session('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-1 -right-1 bg-primary text-on-primary text-[8px] w-4 h-4 rounded-full flex items-center justify-center font-bold">{{ count(session('cart')) }}</span>
                @endif
            </a>
            <button class="md:hidden text-primary" aria-label="Menu">
                <span class="material-symbols-outlined font-light">menu</span>
            </button>
        </div>
    </nav>
</header>

<main class="pt-24">
    @if(session('success'))
        <div class="max-w-[1440px] mx-auto px-6 md:px-20 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-[1440px] mx-auto px-6 md:px-20 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                {{ session('error') }}
            </div>
        </div>
    @endif

    @yield('content')
</main>

<!-- Footer - Editorial Style -->
<footer class="bg-surface pt-[128px] pb-12 border-t border-outline-variant/30">
    <div class="px-6 md:px-20 max-w-[1440px] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-16 mb-24">
            <div class="md:col-span-5">
                <span class="font-headline-lg text-[48px] text-primary mb-8 block editorial-spacing">Qios</span>
                <p class="font-body-md text-[16px] text-on-surface-variant max-w-xs leading-relaxed font-light mb-8">
                    Mendefinisikan ulang kemudahan belanja online dengan kurasi produk berkualitas dan layanan prima.
                </p>
                <div class="flex gap-12 items-center opacity-70">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">verified_user</span>
                        <span class="font-label-caps text-[9px] tracking-widest">SECURE PAYMENT</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">local_shipping</span>
                        <span class="font-label-caps text-[9px] tracking-widest">GLOBAL DELIVERY</span>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <h5 class="font-label-caps text-[12px] tracking-widest text-primary mb-8 uppercase">Shop</h5>
                <div class="flex flex-col gap-5">
                    <a class="font-label-caps text-[11px] tracking-widest text-on-surface-variant hover:text-primary transition-all" href="{{ route('categories.index') }}">New Arrivals</a>
                    <a class="font-label-caps text-[11px] tracking-widest text-on-surface-variant hover:text-primary transition-all" href="{{ route('categories.index') }}">Collections</a>
                    <a class="font-label-caps text-[11px] tracking-widest text-on-surface-variant hover:text-primary transition-all" href="#">Best Sellers</a>
                </div>
            </div>

            <div class="md:col-span-2">
                <h5 class="font-label-caps text-[12px] tracking-widest text-primary mb-8 uppercase">Concierge</h5>
                <div class="flex flex-col gap-5">
                    <a class="font-label-caps text-[11px] tracking-widest text-on-surface-variant hover:text-primary transition-all" href="#">Shipping & Returns</a>
                    <a class="font-label-caps text-[11px] tracking-widest text-on-surface-variant hover:text-primary transition-all" href="#">Size Guide</a>
                    <a class="font-label-caps text-[11px] tracking-widest text-on-surface-variant hover:text-primary transition-all" href="#">Contact Us</a>
                </div>
            </div>

            <div class="md:col-span-3">
                <h5 class="font-label-caps text-[12px] tracking-widest text-primary mb-8 uppercase">Connect</h5>
                <div class="flex flex-col gap-5">
                    <p class="font-label-caps text-[11px] tracking-widest text-on-surface-variant">Jakarta, Indonesia</p>
                    <p class="font-label-caps text-[11px] tracking-widest text-on-surface-variant">support@qios.com</p>
                    <div class="flex gap-6 mt-4">
                        <a class="text-on-surface-variant hover:text-primary transition-colors" href="#" aria-label="Website"><span class="material-symbols-outlined text-[20px]">public</span></a>
                        <a class="text-on-surface-variant hover:text-primary transition-colors" href="#" aria-label="Email"><span class="material-symbols-outlined text-[20px]">alternate_email</span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center border-t border-outline-variant/20 pt-12 gap-6">
            <p class="font-label-caps text-[10px] tracking-[0.2em] text-on-surface-variant/50">&copy; 2024 QIOS. ALL RIGHTS RESERVED.</p>
            <div class="flex gap-8 opacity-20">
                <span class="material-symbols-outlined">payments</span>
                <span class="material-symbols-outlined">credit_card</span>
                <span class="material-symbols-outlined">account_balance</span>
            </div>
        </div>
    </div>
</footer>

@if(env('WA_NUMBER'))
    <a href="https://wa.me/{{ env('WA_NUMBER') }}?text=Halo%20Qios%2C%20saya%20ada%20pertanyaan" target="_blank" class="fixed bottom-6 right-6 bg-green-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 transition z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>
@endif

<!-- Histats.com (keep if needed) -->
<script type="text/javascript">var _Hasync= _Hasync|| []; _Hasync.push(['Histats.start', '1,5026466,4,0,0,0,00010000']); _Hasync.push(['Histats.fasi', '1']); _Hasync.push(['Histats.track_hits', '']); (function() { var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true; hs.src = ('//s10.histats.com/js15_as.js'); (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs); })();</script>
<noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?5026466&101" alt="" border="0"></a></noscript>

@stack('scripts')

<script>
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
</body>
</html>