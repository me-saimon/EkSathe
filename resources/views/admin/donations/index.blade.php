<x-app-layout>
    <div class="flex pt-16 min-h-screen bg-slate-50 font-manrope">
        <!-- Admin Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-12">

            <!-- Page Header & Financial Stats -->
            <div class="flex flex-col lg:flex-row justify-between items-start mb-10 gap-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900">Financial Ledger</h1>
                    <p class="text-slate-500">Global audit of all platform transactions and funding flows.</p>
                </div>

                <div class="flex gap-4">
                    <div class="glass-card px-6 py-4 rounded-2xl border border-white shadow-sm">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Verified Revenue</p>
                        <p class="text-2xl font-black text-emerald-700">৳{{ number_format($totalRevenue) }}</p>
                    </div>
                    <div class="glass-card px-6 py-4 rounded-2xl border border-white shadow-sm">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Payment Success Rate</p>
                        <p class="text-2xl font-black text-blue-600">{{ $successRate }}%</p>
                    </div>
                </div>
            </div>

            <!-- Search & Filter Bar -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <form action="{{ route('admin.donations.index') }}" method="GET" class="relative w-full md:w-96">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Transaction ID..."
                           class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 shadow-sm transition-all text-sm">
                </form>

                <div class="flex bg-white p-1 rounded-xl shadow-sm border border-slate-200">
                    @foreach(['all', 'verified', 'pending', 'failed'] as $st)
                    <a href="{{ route('admin.donations.index', ['status' => $st]) }}"
                       class="px-4 py-2 rounded-lg text-[10px] font-bold uppercase transition-all {{ request('status', 'all') == $st ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-50' }}">
                        {{ $st }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Ledger Table -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Transaction ID</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Donor</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Campaign</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Amount</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($donations as $donation)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <code class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded">{{ $donation->transaction_id }}</code>
                            </td>
                            <td class="px-8 py-6">
                                <p class="font-bold text-slate-900">{{ $donation->user->full_name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $donation->user->email }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <a href="{{ route('campaigns.show', $donation->campaign) }}" class="text-xs font-bold text-emerald-600 hover:underline line-clamp-1">
                                    {{ $donation->campaign->title }}
                                </a>
                            </td>
                            <td class="px-8 py-6 font-black text-slate-900">
                                ৳{{ number_format($donation->amount) }}
                            </td>
                            <td class="px-8 py-6 text-center">
                                @php
                                    $statusStyles = [
                                        'verified' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'failed' => 'bg-red-50 text-red-700 border-red-100'
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusStyles[$donation->status] }}">
                                    {{ $donation->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-[11px] text-slate-400">
                                {{ $donation->created_at->format('M d, Y') }}<br>
                                {{ $donation->created_at->format('H:i A') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center text-slate-400 italic">No transactions found in the ledger.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $donations->appends(request()->query())->links() }}
            </div>
        </main>
    </div>
</x-app-layout>
