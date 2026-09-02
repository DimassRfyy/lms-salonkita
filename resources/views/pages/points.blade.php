<x-layout title="Redeem Point - Salonkita">
    <x-navbar />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-12 text-slate-800">

        <x-breadcrumb :label="'Kembali ke Dashboard'" />

        {{-- HERO BANNER --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-pink-600 via-purple-600 to-indigo-700 rounded-2xl p-6 sm:p-8 text-white shadow-lg mb-7">
            <div class="absolute -right-10 -top-10 w-36 h-36 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="absolute right-16 -bottom-10 w-48 h-48 bg-pink-400/20 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-semibold uppercase tracking-wider text-pink-100 mb-3 border border-white/20">
                        ✨ Redeem Point Salonkita
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Tukarkan Poin & Dapatkan Hadiah!</h1>
                    <p class="mt-1.5 text-pink-100 text-sm max-w-md leading-relaxed">
                        Kumpulkan poin dari setiap aktivitas belajarmu dan tukarkan dengan reward menarik pilihan kamu.
                    </p>
                </div>

                {{-- Saldo Poin Display Card --}}
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-5 flex items-center gap-4 shadow-xl shrink-0 min-w-[220px]">
                    <div class="w-12 h-12 rounded-xl bg-amber-400 flex items-center justify-center text-amber-950 font-black text-2xl shadow-md shadow-amber-400/30">
                        🪙
                    </div>
                    <div>
                        <span class="text-[10px] uppercase tracking-wider font-semibold text-pink-200">Total Poin Saya</span>
                        <div class="text-3xl font-black text-white flex items-baseline gap-1.5">
                            {{ number_format($pointsBalance, 0, ',', '.') }}
                            <span class="text-sm font-semibold text-amber-300">Poin</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT/MAIN (2 Cols): ITEM CATALOG --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Katalog Hadiah</h2>
                        <p class="text-slate-500 text-xs mt-0.5">Pilih item yang ingin kamu tukarkan dengan poinmu</p>
                    </div>
                    <span class="px-3 py-1 bg-pink-100 text-pink-700 font-semibold text-[11px] rounded-full">
                        {{ $rewardItems->count() }} Item Tersedia
                    </span>
                </div>

                @if ($rewardItems->isEmpty())
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-10 text-center shadow-sm">
                        <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-3xl">
                            🎁
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Katalog Hadiah Belum Tersedia</h3>
                        <p class="text-slate-500 text-xs mt-1.5 max-w-xs mx-auto">
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
                            <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
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
                                        <button disabled class="w-full py-2.5 rounded-xl bg-slate-100 text-slate-400 font-semibold text-xs cursor-not-allowed">
                                            Stok Habis
                                        </button>
                                    @elseif ($canAfford)
                                        <form method="POST" action="{{ route('points.redeem', $item->id) }}"
                                              class="redeem-form"
                                              data-item-name="{{ $item->name }}"
                                              data-points="{{ number_format($item->points_required) }}">
                                            @csrf
                                            <button type="button"
                                                    onclick="confirmRedeem(this)"
                                                    class="w-full py-2.5 rounded-xl bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs transition shadow shadow-pink-500/20 active:scale-[0.98]">
                                                Tukar Sekarang
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full py-2.5 rounded-xl bg-amber-50 text-amber-600 font-semibold text-[11px] border border-amber-200 cursor-not-allowed">
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
            <div class="space-y-5">

                {{-- Riwayat Penukaran --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <h3 class="font-bold text-slate-900 text-sm">Riwayat Penukaran Saya</h3>
                    </div>

                    @if ($rewardRedemptions->isEmpty())
                        <div class="text-center py-6 text-slate-400 text-xs">
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

                {{-- Histori Mutasi Poin --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="font-bold text-slate-900 text-sm">Histori Mutasi Poin</h3>
                    </div>

                    @if ($pointTransactions->isEmpty())
                        <div class="text-center py-6 text-slate-400 text-xs">
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

    <!-- SweetAlert2 Handlers -->
    <script>
        // Flash session alerts
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Penukaran Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#db2777',
                timer: 4500,
                timerProgressBar: true,
                customClass: { popup: 'rounded-3xl font-sans' }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#db2777',
                customClass: { popup: 'rounded-3xl font-sans' }
            });
        @endif

        // Confirm before redeem
        function confirmRedeem(btn) {
            const form = btn.closest('.redeem-form');
            const itemName = form.dataset.itemName;
            const points = form.dataset.points;

            Swal.fire({
                title: 'Tukar Poin?',
                html: `Kamu akan menukarkan <strong class="text-amber-600">${points} Poin</strong> untuk item <strong>${itemName}</strong>.<br><span class="text-xs text-slate-400 mt-1 block">Pastikan pilihanmu sudah benar ya!</span>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#db2777',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: '✅ Ya, Tukar Sekarang',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-3xl font-sans' }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

</x-layout>
