<x-app-layout>
    <div class="flex pt-16 min-h-screen font-manrope">
        <!-- Sidebar Navigation -->
        <aside class="h-screen w-64 fixed left-0 top-16 border-r border-slate-100 bg-white shadow-none z-40">
            <div class="flex flex-col p-6 h-full justify-between">
                <div class="space-y-6">
                    <nav class="space-y-2">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-lg transition-all">
                            <span class="material-symbols-outlined">person</span>
                            <span>General Profile</span>
                        </a>
                        <a href="{{ route('profile.donations') }}" class="flex items-center gap-3 px-4 py-3 text-emerald-700 bg-emerald-50/50 rounded-lg transition-all font-bold">
                            <span class="material-symbols-outlined">history</span>
                            <span>Donation History</span>
                        </a>
                        <a href="{{ route('campaigns.mine') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-lg transition-all">
                            <span class="material-symbols-outlined">campaign</span>
                            <span>My Campaigns</span>
                        </a>
                    </nav>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-12 bg-slate-50 min-h-screen">
            <div class="max-w-5xl mx-auto space-y-8">

                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900">Donation History</h1>
                        <p class="text-slate-500">Track your contributions and their impact on global communities.</p>
                    </div>
                    <div class="glass-card px-6 py-4 rounded-2xl border border-white shadow-sm flex items-center gap-4">
                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Impact</p>
                            <p class="text-xl font-black text-emerald-700">৳{{ number_format($totalDonated) }}</p>
                        </div>
                    </div>
                </div>

                <!-- History Table -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Campaign</th>
                                <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Amount</th>
                                <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Date</th>
                                <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Receipt</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($donations as $donation)
                            <tr class="hover:bg-slate-50/30 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                                            <img src="{{ asset('storage/' . $donation->campaign->banner_image) }}" class="w-full h-full object-cover">
                                        </div>
                                        <a href="{{ route('campaigns.show', $donation->campaign) }}" class="font-bold text-slate-900 hover:text-emerald-600 transition-colors line-clamp-1">
                                            {{ $donation->campaign->title }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-8 py-6 font-black text-slate-700">
                                    ৳{{ number_format($donation->amount) }}
                                </td>
                                <td class="px-8 py-6 text-sm text-slate-500">
                                    {{ $donation->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $statusStyles = [
                                            'verified' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'failed' => 'bg-red-100 text-red-700 border-red-200',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusStyles[$donation->status] ?? 'bg-slate-100' }}">
                                        {{ $donation->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    @if($donation->status == 'verified')
                                    <button class="text-slate-400 hover:text-emerald-600 transition-colors" title="Download Receipt">
                                        <span class="material-symbols-outlined">download_for_offline</span>
                                    </button>
                                    @else
                                    <span class="material-symbols-outlined text-slate-200 cursor-not-allowed">block</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <span class="material-symbols-outlined text-5xl text-slate-200 mb-4">volunteer_activism</span>
                                    <p class="text-slate-500 font-medium">You haven't made any donations yet.</p>
                                    <a href="{{ route('campaigns.index') }}" class="text-emerald-600 font-bold hover:underline mt-2 inline-block">Explore Campaigns</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $donations->links() }}
                </div>

            </div>
        </main>
    </div>
</x-app-layout>
