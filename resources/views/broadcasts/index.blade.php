@extends('layouts.app')

@section('title', 'New Arrivals & Siaran Langsung - Qios')

@section('content')
<div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto py-section-gap">
    <!-- Header -->
    <div class="mb-20 reveal">
        <a href="{{ route('home') }}" class="font-label-caps text-[11px] tracking-[0.2em] text-on-surface-variant hover:text-primary transition-colors inline-block mb-6">&larr; BACK TO HOME</a>
        <h1 class="font-headline-lg text-[48px] editorial-spacing uppercase text-primary">New Arrivals</h1>
        <p class="font-body-md text-[16px] text-on-surface-variant mt-4 max-w-xl leading-relaxed font-light">Temukan produk-produk terbaru dan siaran langsung eksklusif dari toko-toko pilihan kami.</p>
    </div>

    @if($broadcasts->count() > 0)
        <div class="space-y-24">
            @foreach($broadcasts as $broadcast)
                <div class="max-w-3xl reveal">
                    <!-- Konten -->
                    <div>
                        @if($broadcast->store)
                            <span class="font-label-caps text-[10px] tracking-[0.3em] text-secondary mb-4 uppercase block">{{ $broadcast->store->name }}</span>
                        @endif
                        <div class="flex items-center gap-4 mb-4">
                            @if($broadcast->is_live)
                                <span class="bg-red-500 text-white text-[10px] tracking-widest px-4 py-1 font-label-caps uppercase flex items-center gap-2">
                                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                    Live
                                </span>
                            @endif
                        </div>
                        <h2 class="font-headline-md text-[36px] editorial-spacing uppercase text-primary mb-6">{{ $broadcast->title }}</h2>
                        @if($broadcast->description)
                            <p class="font-body-md text-[16px] text-on-surface-variant leading-relaxed font-light mb-8">{{ $broadcast->description }}</p>
                        @endif

                        @if($broadcast->product)
                            <a href="{{ route('products.show', $broadcast->product) }}" class="inline-flex items-center gap-3 font-label-caps text-[11px] tracking-[0.2em] text-primary border-b border-primary pb-1 hover:opacity-70 transition-opacity">
                                <span>VIEW PRODUCT</span>
                                <span class="material-symbols-outlined text-sm">arrow_right_alt</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty state -->
        <div class="text-center py-32 reveal">
            <div class="mb-8">
                <span class="material-symbols-outlined text-stone-300" style="font-size: 80px;">play_circle</span>
            </div>
            <h2 class="font-headline-md text-[32px] editorial-spacing uppercase text-primary mb-4">Belum Ada Siaran Langsung</h2>
            <p class="font-body-md text-[16px] text-on-surface-variant max-w-md mx-auto leading-relaxed font-light">
                Belum ada siaran langsung atau rilis terbaru saat ini. Pantau terus untuk mendapatkan update produk-produk terbaru dari kami.
            </p>
            <a href="{{ route('categories.index') }}" class="inline-block mt-10 px-12 py-5 bg-primary text-on-primary font-label-caps text-[13px] tracking-widest hover:bg-on-surface-variant transition-all cta-hover">
                EXPLORE CATEGORIES
            </a>
        </div>
    @endif
</div>
@endsection
