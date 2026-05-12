<x-app-layout>
    <div class="flex pt-16 min-h-screen bg-slate-50">
        <!-- Admin Sidebar -->
        @include('layouts.sidebar')

        <!-- Content Area -->
        <main class="flex-1 ml-64 p-12">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Admin Oversight</h1>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <span class="material-symbols-outlined text-emerald-600 mb-2">payments</span>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Raised</p>
                    <p class="text-2xl font-black text-slate-900">৳{{ number_format($stats['total_raised']) }}</p>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <span class="material-symbols-outlined text-blue-600 mb-2">campaign</span>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Active Campaigns</p>
                    <p class="text-2xl font-black text-slate-900">{{ $stats['active_campaigns'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <span class="material-symbols-outlined text-amber-600 mb-2">emergency</span>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pending Help</p>
                    <p class="text-2xl font-black text-slate-900">{{ $stats['pending_help'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <span class="material-symbols-outlined text-purple-600 mb-2">group</span>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Community</p>
                    <p class="text-2xl font-black text-slate-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>

            <!-- Recent Requests Table -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-900">Latest Help Requests</h3>
                    <a href="{{ route('admin.help.requests') }}" class="text-xs font-bold text-emerald-600 hover:underline tracking-widest uppercase">View All</a>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Subject</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Location</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentRequests as $request)
                        <tr>
                            <td class="px-6 py-4 font-bold text-slate-700">{{ $request->subject }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $request->location }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-amber-50 text-amber-700 text-[10px] font-bold uppercase rounded-full border border-amber-100">
                                    {{ $request->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.help.requests') }}" class="text-slate-400 hover:text-emerald-600">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</x-app-layout>
