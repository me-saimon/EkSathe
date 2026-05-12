<x-app-layout>
    <div class="flex pt-16 min-h-screen bg-slate-50 font-manrope">
        <!-- Admin Sidebar (Same as Dashboard) -->
       @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-12">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900">Help Request Inbox</h1>
                    <p class="text-slate-500">Manage direct requests for assistance from the community.</p>
                </div>

                <!-- Status Tabs -->
                <div class="flex bg-white p-1 rounded-xl shadow-sm border border-slate-200">
                    @foreach(['all', 'new', 'processing', 'resolved'] as $status)
                    <a href="{{ route('admin.help.requests', ['status' => $status]) }}"
                       class="px-4 py-2 rounded-lg text-xs font-bold uppercase transition-all {{ request('status', 'all') == $status ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-50' }}">
                        {{ $status }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Requests Table -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden" x-data="{ openRequest: null }">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sender</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Subject</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Location</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($requests as $request)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <p class="font-bold text-slate-900 text-sm">{{ $request->user->full_name ?? 'Anonymous' }}</p>
                                <p class="text-[10px] text-slate-400">{{ $request->contact_info }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-sm font-medium text-slate-700 line-clamp-1">{{ $request->subject }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-1 text-slate-500">
                                    <span class="material-symbols-outlined text-xs">location_on</span>
                                    <span class="text-xs">{{ $request->location }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $statusColors = [
                                        'new' => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'processing' => 'bg-blue-50 text-blue-700 border-blue-100',
                                        'resolved' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'closed' => 'bg-slate-100 text-slate-600 border-slate-200'
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusColors[$request->status] }}">
                                    {{ $request->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-xs text-slate-400">
                                {{ $request->created_at->diffForHumans() }}
                            </td>
                            <td class="px-8 py-6">
                                <button @click="openRequest = {{ $request->id }}" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </button>
                            </td>
                        </tr>

                        {{-- <!-- Modal (Alpine.js) -->
                        <template x-if="openRequest === {{ $request->id }}">
                            <div class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm px-4">
                                <div @click.away="openRequest = null" class="bg-white max-w-2xl w-full rounded-[2.5rem] shadow-2xl p-10 relative overflow-hidden">
                                    <div class="flex justify-between items-start mb-8">
                                        <div class="space-y-1">
                                            <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-2 py-1 rounded">HELP REQUEST #{{ $request->id }}</span>
                                            <h2 class="text-2xl font-black text-slate-900 mt-2">{{ $request->subject }}</h2>
                                        </div>
                                        <button @click="openRequest = null" class="text-slate-400 hover:text-slate-600">
                                            <span class="material-symbols-outlined">close</span>
                                        </button>
                                    </div>

                                    <div class="space-y-6">
                                        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Message Description</p>
                                            <p class="text-slate-700 leading-relaxed">{{ $request->message }}</p>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="p-4 border border-slate-100 rounded-xl">
                                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Contact Person</p>
                                                <p class="text-sm font-bold text-slate-900">{{ $request->user->full_name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="p-4 border border-slate-100 rounded-xl">
                                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Contact Detail</p>
                                                <p class="text-sm font-bold text-emerald-600">{{ $request->contact_info }}</p>
                                            </div>
                                        </div>

                                        <!-- Update Status Form -->
                                        <form action="{{ route('admin.help.status', $request) }}" method="POST" class="pt-6 border-t border-slate-100">
                                            @csrf @method('PATCH')
                                            <p class="text-xs font-bold text-slate-400 uppercase mb-4">Take Action</p>
                                            <div class="flex flex-wrap gap-2">
                                                <button name="status" value="processing" class="px-4 py-2 rounded-lg text-xs font-bold bg-blue-600 text-white shadow-lg shadow-blue-100">Move to Processing</button>
                                                <button name="status" value="resolved" class="px-4 py-2 rounded-lg text-xs font-bold bg-emerald-600 text-white shadow-lg shadow-emerald-100">Mark as Resolved</button>
                                                <button name="status" value="closed" class="px-4 py-2 rounded-lg text-xs font-bold bg-slate-200 text-slate-700">Close Request</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </template> --}}

                        @foreach($requests as $request)
            <div x-show="openRequest === {{ $request->id }}"
                 x-cloak
                 class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm px-4">

                <div @click.away="openRequest = null"
                     class="bg-white max-w-2xl w-full rounded-[2.5rem] shadow-2xl p-10 relative">

                    <div class="flex justify-between items-start mb-8">
                        <h2 class="text-2xl font-black text-slate-900">{{ $request->subject }}</h2>
                        <button @click="openRequest = null" class="text-slate-400 hover:text-slate-600">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <div class="space-y-6">
                        <p class="text-slate-700 bg-slate-50 p-6 rounded-2xl">{{ $request->message }}</p>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 border rounded-xl">
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Contact</p>
                                <p class="text-sm font-bold">{{ $request->contact_info }}</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.help.status', $request) }}" method="POST" class="pt-6 border-t">
                            @csrf @method('PATCH')
                            <div class="flex gap-2">
                                <button name="status" value="resolved" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-xs font-bold">Mark Resolved</button>
                                <button name="status" value="closed" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg text-xs font-bold">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach


                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center text-slate-400 italic">No help requests found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $requests->links() }}
            </div>
        </main>
    </div>
</x-app-layout>
