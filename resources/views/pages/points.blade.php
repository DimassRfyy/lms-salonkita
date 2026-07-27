<x-layout title="Redeem Point - Salonkita">
    <x-navbar />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 pt-24 pb-12 text-slate-800">
        
        {{-- Alert Flash Messages --}}
        @if (session('success'))
            <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-2.5 shadow-sm text-xs sm:text-sm">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl flex items-center gap-2.5 shadow-sm text-xs sm:text-sm">
                <svg class="w-5 h-5 text-rose-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="font-medium">{{ session('error') }}</div>
            </div>
        @endif

        {{-- HERO BANNER / USER POINTS CARD (Compact 80% Scale Layout) --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-pink-600 via-purple-600 to-indigo-700 rounded-2xl p-5 sm:p-7 text-white shadow-lg mb-6">
            <div class="absolute -right-10 -top-10 w-36 h-36 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="absolute right-16 -bottom-10 w-48 h-48 bg-pink-400/20 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-semibold uppercase tracking-wider text-pink-100 mb-2 border border-white/20">
                        ✨ Redeem Point Salonkita
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Tukarkan Poin & Dapatkan Hadiah!</h1>
                    <p class="mt-1 text-pink-100 text-xs sm:text-sm max-w-lg leading-relaxed">
                        Dapatkan <span class="font-bold text-amber-300">+50 Poin</span> setiap kali kamu membeli kelas. Kumpulkan poin sebanyak-banyaknya dan tukarkan dengan voucher atau item menarik.
                    </p>
                </div>

                {{-- Saldo Poin Display Card --}}
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-xl p-4 flex items-center gap-4 shadow-xl shrink-0 min-w-[220px]">
                    <div class="w-11 h-11 rounded-xl bg-amber-400 flex items-center justify-center text-amber-950 font-black text-xl shadow-md shadow-amber-400/30">
                        🪙
                    </div>
                    <div>
                        <span class="text-[10px] uppercase tracking-wider font-semibold text-pink-200">Total Poin Saya</span>
                        <div class="text-2xl font-black text-white flex items-baseline gap-1">
                            {{ number_format($pointsBalance, 0, ',', '.') }}
                            <span class="text-xs font-semibold text-amber-300">Poin</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT SECTION (COMPACT 80% SCALE SPACING) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            
            {{-- LEFT/MAIN (2 Cols): ITEM CATALOG --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Katalog Hadiah</h2>
                        <p class="text-slate-500 text-xs">Pilih item yang ingin kamu tukarkan dengan poinmu</p>
                    </div>
                    <span class="px-2.5 py-0.5 bg-pink-100 text-pink-700 font-semibold text-[11px] rounded-full">
                        {{ $rewardItems->count() }} Item Tersedia
                    </span>
                </div>

                @if ($rewardItems->isEmpty())
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center shadow-sm">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                            🎁
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Katalog Hadiah Belum Tersedia</h3>
                        <p class="text-slate-500 text-xs mt-1 max-w-xs mx-auto">
                            Admin sedang menyiapkan item hadiah menarik untukmu. Nantikan segera!
                        </p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($rewardItems as $item)
                            @php
                                $canAfford = $pointsBalance >= $item->points_required;
                                $hasStock = $item->stock === null || $item->stock > 0;
                            @endphp
                            <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow transition duration-200 flex flex-col justify-between">
                                <div>
                                    {{-- Image / Banner --}}
                                    <div class="relative h-36 bg-slate-100 overflow-hidden">
                                        @if ($item->image)
                                            <img src="{{ Str::startsWith($item->image, ['http://', 'https://']) ? $item->image : Storage::url($item->image) }}"
                                                 alt="{{ $item->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center text-3xl">
                                                🎁
                                            </div>
                                        @endif
                                        
                                        {{-- Type Badge --}}
                                        <div class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-full bg-slate-900/75 backdrop-blur-md text-white text-[10px] font-semibold">
                                            {{ $item->type }}
                                        </div>

                                        {{-- Points Badge --}}
                                        <div class="absolute bottom-2.5 right-2.5 px-2.5 py-1 rounded-lg bg-amber-400 text-amber-950 text-[11px] font-black shadow flex items-center gap-1">
                                            🪙 {{ number_format($item->points_required, 0, ',', '.') }} Poin
                                        </div>
                                    </div>

                                    {{-- Item Body --}}
                                    <div class="p-4">
                                        <h3 class="font-bold text-slate-900 text-base line-clamp-1">{{ $item->name }}</h3>
                                        <p class="text-slate-500 text-xs mt-1 line-clamp-2 leading-relaxed">
                                            {{ $item->description ?? 'Tidak ada deskripsi item.' }}
                                        </p>
                                        
                                        <div class="mt-2.5 flex items-center justify-between text-[11px] text-slate-500 border-t border-slate-100 pt-2">
                                            <span>Stok:</span>
                                            <span class="font-semibold text-slate-700">
                                                {{ $item->stock === null ? 'Tidak Terbatas' : $item->stock . ' tersisa' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Button --}}
                                <div class="p-4 pt-0">
                                    @if (! $hasStock)
                                        <button disabled class="w-full py-2 rounded-xl bg-slate-100 text-slate-400 font-semibold text-xs cursor-not-allowed">
                                            Stok Habis
                                        </button>
                                    @elseif ($canAfford)
                                        <form method="POST" action="{{ route('points.redeem', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menukarkan {{ number_format($item->points_required) }} Poin untuk {{ $item->name }}?');">
                                            @csrf
                                            <button type="submit" class="w-full py-2 rounded-xl bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs transition shadow shadow-pink-500/20 active:scale-[0.98]">
                                                Tukar Sekarang
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full py-2 rounded-xl bg-amber-50 text-amber-600 font-semibold text-[11px] border border-amber-200 cursor-not-allowed">
                                            Kurang {{ number_format($item->points_required - $pointsBalance) }} Poin Lagi
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- RIGHT (1 Col): HISTORI & MUTASI POIN --}}
            <div class="space-y-4">
                
                {{-- TAB 1: RIWAYAT PENUKARAN ITEM --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <h3 class="font-bold text-slate-900 text-sm">Riwayat Penukaran Saya</h3>
                    </div>

                    @if ($rewardRedemptions->isEmpty())
                        <div class="text-center py-5 text-slate-400 text-xs">
                            Belum ada riwayat penukaran item.
                        </div>
                    @else
                        <div class="space-y-2.5 max-h-72 overflow-y-auto pr-1">
                            @foreach ($rewardRedemptions as $redemption)
                                <div class="p-2.5 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-between gap-2 text-xs">
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-800 truncate text-[11px]">
                                            {{ $redemption->rewardItem->name ?? 'Item Hadiah' }}
                                        </div>
                                        <div class="text-slate-400 text-[10px] mt-0.5">
                                            Kode: <span class="font-mono text-slate-600 font-semibold">{{ $redemption->redemption_code }}</span>
                                        </div>
                                        <div class="text-slate-400 text-[9px]">
                                            {{ $redemption->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="font-bold text-rose-600 text-[11px]">
                                            -{{ number_format($redemption->points_spent) }} Poin
                                        </span>
                                        <div class="mt-0.5">
                                            <span class="inline-block px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700 font-semibold text-[9px]">
                                                {{ $redemption->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- TAB 2: RIWAYAT MUTASI POIN (LOG) --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="font-bold text-slate-900 text-sm">Histori Mutasi Poin</h3>
                    </div>

                    @if ($pointTransactions->isEmpty())
                        <div class="text-center py-5 text-slate-400 text-xs">
                            Belum ada riwayat mutasi poin.
                        </div>
                    @else
                        <div class="space-y-2.5 max-h-80 overflow-y-auto pr-1">
                            @foreach ($pointTransactions as $trx)
                                <div class="p-2.5 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-between gap-2 text-xs">
                                    <div>
                                        <div class="font-semibold text-slate-800 text-[11px]">
                                            {{ $trx->description }}
                                        </div>
                                        <div class="text-slate-400 text-[9px] mt-0.5">
                                            {{ $trx->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="font-bold text-xs {{ $trx->amount > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ $trx->amount > 0 ? '+' : '' }}{{ number_format($trx->amount) }}
                                        </span>
                                        <div class="text-[9px] text-slate-400">
                                            Saldo: {{ number_format($trx->balance_after) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </main>

    <x-footer />
</x-layout>
