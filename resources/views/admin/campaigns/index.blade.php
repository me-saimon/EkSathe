<x-app-layout>
    <div class="flex pt-16 min-h-screen bg-slate-50 font-manrope">
        <!-- Admin Sidebar -->
       @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-12">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900">Campaign Audit</h1>
                    <p class="text-slate-500">Monitor community trust and project authenticity.</p>
                </div>

                <div class="flex bg-white p-1 rounded-xl shadow-sm border border-slate-200">
                    @foreach(['all', 'active', 'paused', 'completed'] as $st)
                    <a href="{{ route('admin.campaigns', ['status' => $st]) }}"
                       class="px-4 py-2 rounded-lg text-[10px] font-bold uppercase transition-all {{ request('status', 'all') == $st ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-50' }}">
                        {{ $st }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Campaign & Creator</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Trust Score</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Raised</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Rank</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($campaigns as $campaign)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset('storage/' . $campaign->banner_image) }}" class="w-12 h-12 rounded-xl object-cover">
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">{{ $campaign->title }}</p>
                                        <p class="text-[10px] text-emerald-600 font-bold uppercase">By {{ $campaign->creator->full_name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $votes = $campaign->factChecks;
                                    $trustVotes = $votes->where('vote', 1)->count();
                                    $totalVotes = $votes->count();
                                    $score = $totalVotes > 0 ? round(($trustVotes / $totalVotes) * 100) : 0;
                                @endphp
                                <div class="flex flex-col items-center">
                                    <span class="text-lg font-black {{ $score < 50 && $totalVotes > 0 ? 'text-red-500' : 'text-slate-900' }}">{{ $score }}%</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ $totalVotes }} Verifications</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 font-bold text-slate-700">
                                ৳{{ number_format($campaign->total_raised ?? 0) }}
                            </td>
                            <td class="px-8 py-6">
                                <form action="{{ route('admin.campaigns.rank', $campaign) }}" method="POST" class="flex items-center gap-2">
                                    @csrf @method('PATCH')
                                    <input type="number" name="rank" value="{{ $campaign->rank }}" class="w-16 px-2 py-1 bg-slate-50 border border-slate-200 rounded text-xs font-bold text-center focus:ring-emerald-500">
                                    <button type="submit" class="text-emerald-600"><span class="material-symbols-outlined text-sm">save</span></button>
                                </form>
                            </td>
                            <td class="px-8 py-6">
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" class="px-4 py-2 bg-slate-900 text-white rounded-lg text-[10px] font-bold uppercase tracking-widest flex items-center gap-1">
                                        {{ $campaign->status }} <span class="material-symbols-outlined text-xs">expand_more</span>
                                    </button>

                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white shadow-xl rounded-xl border border-slate-100 z-50 p-2">
                                        <form action="{{ route('admin.campaigns.status', $campaign) }}" method="POST" class="flex flex-col gap-1">
                                            @csrf @method('PATCH')
                                            <button name="status" value="active" class="text-left px-3 py-2 text-[10px] font-bold hover:bg-emerald-50 rounded-lg text-emerald-600">Reactivate</button>
                                            <button name="status" value="paused" class="text-left px-3 py-2 text-[10px] font-bold hover:bg-amber-50 rounded-lg text-amber-600">Suspend/Pause</button>
                                            <button name="status" value="completed" class="text-left px-3 py-2 text-[10px] font-bold hover:bg-slate-50 rounded-lg text-slate-400">Complete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $campaigns->links() }}
            </div>
        </main>
    </div>
</x-app-layout>
