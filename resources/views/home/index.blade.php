@extends('layouts.app')

@section('title', 'Qios - Toko Online Terpercaya')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img alt="Fashion collection" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1200&auto=format"/>
            <div class="absolute inset-0 bg-black/10"></div>
        </div>
        <div class="relative z-10 w-full px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto pt-20">
            <div class="max-w-4xl reveal">
                <span class="font-label-caps text-[12px] tracking-[0.4em] text-secondary mb-8 block uppercase">Autumn / Winter Series</span>
                <h1 class="font-headline-xl text-[64px] md:text-[96px] text-primary mb-12 leading-[1] editorial-spacing">
                    Belanja Lebih <br/><i class="font-light italic">Mudah & Cepat</i>
                </h1>
                <p class="font-body-lg text-[20px] text-on-surface-variant mb-16 max-w-xl leading-relaxed">
                    Qios hadir sebagai mitra belanja terpercaya Anda. Kurasi produk berkualitas tinggi dengan pengalaman transaksi yang mulus dan elegan.
                </p>
                <div class="flex flex-wrap gap-6">
                    <a href="{{ route('categories.index') }}" class="px-14 py-5 bg-primary text-on-primary font-label-caps text-[13px] tracking-widest hover:bg-on-surface-variant transition-all cta-hover block text-center">
                        SHOP THE COLLECTION
                    </a>
                    <a href="{{ route('pages.tentang-kami') }}" class="px-14 py-5 glass-btn text-primary font-label-caps text-[13px] tracking-widest transition-all block text-center">
                        EXPLORE STORY
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Trending Now / Featured Collections -->
    <section class="py-section-gap px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-24 reveal">
            <div class="max-w-xl">
                <span class="font-label-caps text-[12px] tracking-[0.3em] text-secondary mb-4 block uppercase">Featured Selection</span>
                <h2 class="font-headline-lg text-[48px] editorial-spacing uppercase">Trending Now</h2>
            </div>
            <a class="font-label-caps text-[12px] tracking-[0.2em] border-b border-primary pb-1 mt-6 md:mt-0" href="{{ route('categories.index') }}">DISCOVER ALL</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
            <!-- Pakaian -->
            <div class="reveal">
                <div class="relative group aspect-[16/10] overflow-hidden mb-8">
                    <img alt="Pakaian" class="w-full h-full object-cover transition-all duration-1000 scale-100 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida/AP1WRLvVqisSBLiA4gI35JJC4N50q-hayvIAGkL3b7x8SqlQZg5MnFJpuPc9V17YF5qnCZbVPT46KE7pkJCpxDMgSV6NpZyfcytXBDlt2jVdAl9W-SloAf2iKe3sqVXgua9xBjMbl5GkSqjB21sJek7X2OEXLCC9ON75NKg8Upzpm8Z2ZGVj-eadNg02Ssi4qt5gvc-KD_kp4O52LZwRCeenUMs6wbFltrzvJtx45dbSf8XJICFkVTnzDHQb_FiT"/>
                    <div class="absolute inset-0 bg-black/5 group-hover:bg-black/20 transition-all"></div>
                    <div class="absolute bottom-10 left-10 text-primary">
                        <span class="font-label-caps text-[11px] tracking-[0.3em] uppercase block mb-2 opacity-80">Curated Atelier</span>
                        <h3 class="font-headline-md text-[32px] editorial-spacing text-on-primary">Modern Apparel</h3>
                        <a class="inline-block mt-4 text-on-primary font-label-caps text-[10px] tracking-widest border-b border-on-primary/40 pb-1 hover:border-on-primary transition-all" href="{{ route('categories.show', 'pakaian') }}">SHOP CATEGORY</a>
                    </div>
                </div>
            </div>
            <!-- Electronics -->
            <div class="reveal" style="transition-delay: 0.2s;">
                <div class="relative group aspect-[16/10] overflow-hidden mb-8">
                    <img alt="Elektronik" class="w-full h-full object-cover transition-all duration-1000 scale-100 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida/AP1WRLvaQ6XmmNFdRKEThtY5iYPn22sdWL-3f8rxTlWOSXcpJMuNyy_oUyAOrG9I-FmGfZq6JiSIKGiVF0IyPF3nG2d8Fa2flG704JltFxSsNmgbpClzgpRJcYO03MWKElkyA9lfw5HuYgKlm3Amps1ibUjG9pgQ0sx5gr_Znd6ZK7KrqC0rfFXt6UwMqymj58fPAQsl9LoJo4qHJFmv6vsZtEGCa3AL6ZkmOlvCYsWm3JP3SBeDFlaTHg7wavcw"/>
                    <div class="absolute inset-0 bg-black/5 group-hover:bg-black/20 transition-all"></div>
                    <div class="absolute bottom-10 left-10 text-primary">
                        <span class="font-label-caps text-[11px] tracking-[0.3em] uppercase block mb-2 opacity-80">Modern Tech</span>
                        <h3 class="font-headline-md text-[32px] editorial-spacing text-on-primary">Elite Tech</h3>
                        <a class="inline-block mt-4 text-on-primary font-label-caps text-[10px] tracking-widest border-b border-on-primary/40 pb-1 hover:border-on-primary transition-all" href="{{ route('categories.show', 'elektronik') }}">SHOP CATEGORY</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Grid - Enhanced -->
    <section class="py-section-gap bg-surface-container-low">
        <div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
            <div class="flex justify-between items-baseline mb-24 reveal">
                <h2 class="font-headline-lg text-[48px] editorial-spacing uppercase">Produk Pilihan</h2>
                <div class="flex gap-8">
                    <button class="font-label-caps text-[12px] tracking-[0.2em] text-primary border-b border-primary">NEWEST</button>
                    <button class="font-label-caps text-[12px] tracking-[0.2em] text-on-surface-variant">POPULAR</button>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-32 reveal">
                @foreach($featuredProducts as $product)
                    <a href="{{ route('products.show', $product) }}" class="block group cursor-pointer">
                        <div class="relative aspect-[3/4] bg-white overflow-hidden mb-8">
                            @if($product->image)
                                <img alt="{{ $product->nama_produk }}" class="w-full h-full object-contain mix-blend-multiply opacity-95 group-hover:opacity-100 transition-opacity duration-700" src="{{ asset('storage/' . $product->image) }}"/>
                            @else
                                <div class="w-full h-full bg-white flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-all duration-500"></div>
                            <!-- Quick Actions -->
                            <div class="absolute bottom-4 left-4 right-4 flex gap-2 translate-y-12 group-hover:translate-y-0 transition-transform duration-500 pointer-events-none">
                                <span class="flex-1 bg-primary text-on-primary py-3 font-label-caps text-[10px] tracking-widest">ADD TO BAG</span>
                                <span class="w-12 bg-surface text-primary border border-outline-variant/30 flex items-center justify-center"><span class="material-symbols-outlined text-sm">visibility</span></span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center text-center px-4">
                            <span class="font-label-caps text-[10px] tracking-[0.3em] text-secondary mb-3 uppercase">{{ $product->category->name }}</span>
                            <h4 class="font-body-md text-[16px] text-primary mb-2 font-light tracking-wide">{{ $product->nama_produk }}</h4>
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex text-[10px] text-secondary">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="material-symbols-outlined text-[14px]">{{ $i <= 4 ? 'star' : 'star' }}</span>
                                    @endfor
                                </div>
                                <span class="text-[11px] text-on-surface-variant">(12)</span>
                            </div>
                            <span class="font-body-md text-[15px] font-medium text-primary">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Siaran Langsung -->
    @if($activeBroadcasts->count() > 0)
        <section class="py-section-gap px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 reveal">
                <div>
                    <span class="font-label-caps text-[12px] tracking-[0.3em] text-secondary mb-4 block uppercase">Live Now</span>
                    <h2 class="font-headline-lg text-[48px] editorial-spacing uppercase">Siaran Langsung</h2>
                </div>
                <a class="font-label-caps text-[12px] tracking-[0.2em] border-b border-primary pb-1 mt-6 md:mt-0" href="{{ route('broadcasts.index') }}">VIEW ALL</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($activeBroadcasts as $broadcast)
                    <div class="reveal group">
                        <div class="relative aspect-[16/10] bg-white overflow-hidden mb-6">
                            @if($broadcast->image)
                                <img alt="{{ $broadcast->title }}" class="w-full h-full object-cover mix-blend-multiply opacity-95 group-hover:opacity-100 transition-all duration-700" src="{{ asset('storage/' . $broadcast->image) }}"/>
                            @else
                                <div class="w-full h-full bg-stone-100 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-stone-300" style="font-size: 60px;">play_circle</span>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-red-500 text-white text-[10px] tracking-widest px-3 py-1.5 font-label-caps uppercase flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                    Live
                                </span>
                            </div>
                        </div>
                        @if($broadcast->store)
                            <span class="font-label-caps text-[10px] tracking-[0.3em] text-secondary uppercase block mb-2">{{ $broadcast->store->name }}</span>
                        @endif
                        <h3 class="font-body-lg text-[18px] text-primary mb-2 font-light">{{ $broadcast->title }}</h3>
                        @if($broadcast->description)
                            <p class="font-body-md text-[14px] text-on-surface-variant leading-relaxed font-light mb-4 line-clamp-2">{{ $broadcast->description }}</p>
                        @endif
                        @if($broadcast->product)
                            <a href="{{ route('products.show', $broadcast->product) }}" class="font-label-caps text-[11px] tracking-[0.2em] text-primary border-b border-primary pb-0.5 hover:opacity-70 transition-opacity">
                                VIEW PRODUCT
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Newsletter Section -->
    <section class="py-section-gap px-margin-mobile md:px-margin-desktop reveal">
        <div class="max-w-6xl mx-auto bg-primary text-on-primary p-20 md:p-32 flex flex-col items-center text-center">
            <span class="font-label-caps text-[12px] tracking-[0.4em] mb-10 opacity-60 uppercase">Join our community</span>
            <h2 class="font-headline-lg text-[48px] md:text-[64px] mb-12 editorial-spacing uppercase leading-tight">Stay Updated</h2>
            <p class="font-body-lg text-[18px] mb-20 opacity-70 max-w-lg mx-auto font-light leading-relaxed">
                Receive invitations to our exclusive private sales, new collection drops, and editorial features.
            </p>
            <form class="w-full max-w-md">
                <div class="relative group">
                    <input class="w-full bg-transparent border-0 border-b border-white/20 px-0 py-6 text-white focus:ring-0 focus:border-white transition-all font-light placeholder:text-white/30" placeholder="Email Address" type="email"/>
                    <button class="absolute right-0 bottom-6 text-white/50 hover:text-white transition-colors" type="submit">
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection