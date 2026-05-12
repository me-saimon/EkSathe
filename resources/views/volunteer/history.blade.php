<x-app-layout>
    <div class="flex pt-16 min-h-screen font-manrope">
        <!-- Sidebar Navigation -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-12 bg-slate-50 min-h-screen">
            <div class="max-w-6xl mx-auto space-y-8">

                <!-- Page Header & Stats -->
                <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900">Volunteer History</h1>
                        <p class="text-slate-500">Your journey of selfless service and community impact.</p>
                    </div>

                    <div class="flex gap-4">
                        <div class="glass-card px-6 py-4 rounded-2xl border border-white shadow-sm text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Applied</p>
                            <p class="text-xl font-black text-slate-700">{{ $totalApplications }}</p>
                        </div>
                        <div class="glass-card px-6 py-4 rounded-2xl border border-white shadow-sm text-center">
                            <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">Approved</p>
                            <p class="text-xl font-black text-emerald-700">{{ $approvedCount }}</p>
                        </div>
                    </div>
                </div>

                <!-- History Table -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Campaign</th>
                                <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Applied On</th>
                                <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($applications as $app)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0 shadow-sm">
                                            <img src="{{ asset('storage/' . $app->campaign->banner_image) }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <a href="{{ route('campaigns.show', $app->campaign) }}" class="font-bold text-slate-900 hover:text-emerald-600 transition-colors">
                                                {{ $app->campaign->title }}
                                            </a>
                                            <p class="text-xs text-slate-400 flex items-center gap-1 mt-1">
                                                <span class="material-symbols-outlined text-xs">location_on</span>
                                                {{ $app->campaign->address }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-sm text-slate-500">
                                    {{ $app->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $statusStyles = [
                                            'pending'   => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'approved'  => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'rejected'  => 'bg-red-50 text-red-600 border-red-100',
                                            'completed' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusStyles[$app->status] ?? 'bg-slate-50' }}">
                                        {{ $app->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ route('campaigns.show', $app->campaign) }}" class="inline-flex items-center justify-center w-10 h-10 bg-slate-100 text-slate-500 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-24 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                            <span class="material-symbols-outlined text-4xl text-slate-200">hail</span>
                                        </div>
                                        <p class="text-slate-500 font-bold">You haven't applied for any campaigns yet.</p>
                                        <p class="text-xs text-slate-400 mt-1">Be the change you want to see in the world.</p>
                                        <a href="{{ route('campaigns.index') }}" class="mt-6 px-8 py-3 bg-emerald-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all">
                                            Find a Campaign
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $applications->links() }}
                </div>

            </div>
        </main>
    </div>
</x-app-layout>
