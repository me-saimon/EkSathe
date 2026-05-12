<x-app-layout>
    <div class="flex pt-16 min-h-screen font-manrope">
        <!-- Sidebar Navigation (Same as Profile) -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-12 bg-slate-50 min-h-screen">
            <div class="max-w-6xl mx-auto">

                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900">Manage Campaigns</h1>
                        <p class="text-slate-500">Track your impact and manage your community.</p>
                    </div>
                    <a href="{{ route('campaigns.create') }}"
                        class="px-6 py-3 bg-emerald-600 text-white rounded-xl font-bold flex items-center gap-2 hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">
                        <span class="material-symbols-outlined">add</span>
                        New Campaign
                    </a>
                </div>

                <!-- Campaign Management Cards -->
                <div class="space-y-6">
                    @forelse($campaigns as $campaign)
                        <div
                            class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col lg:flex-row gap-8 items-center">
                            <!-- Image & Basic Info -->
                            <div class="flex items-center gap-6 w-full lg:w-1/3">
                                <img src="{{ asset('storage/' . $campaign->banner_image) }}"
                                    class="w-24 h-24 rounded-2xl object-cover shadow-sm">
                                <div>
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">{{ $campaign->category }}</span>
                                    <h3 class="text-lg font-bold text-slate-900 mt-1 line-clamp-1">
                                        {{ $campaign->title }}</h3>
                                    <div class="flex items-center gap-2 mt-2">
                                        @php
                                            $statusColors = [
                                                'active' => 'bg-emerald-500',
                                                'paused' => 'bg-amber-500',
                                                'completed' => 'bg-slate-400',
                                            ];
                                        @endphp
                                        <span
                                            class="w-2 h-2 rounded-full {{ $statusColors[$campaign->status] }}"></span>
                                        <span
                                            class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ $campaign->status }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Stats: Raised & Volunteers -->
                            <div class="grid grid-cols-2 gap-8 w-full lg:w-1/3 border-x border-slate-50 px-8">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">
                                        Raised</p>
                                    <p class="text-xl font-extrabold text-emerald-700">
                                        ৳{{ number_format($campaign->total_raised ?? 0) }}</p>
                                    <p class="text-[10px] text-slate-400">Target:
                                        ৳{{ number_format($campaign->goal_amount) }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">
                                        Volunteers</p>
                                    <p class="text-xl font-extrabold text-slate-900">
                                        {{ $campaign->volunteer_applications_count }}</p>
                                    <p class="text-[10px] text-slate-400">Applicants</p>
                                </div>
                            </div>
                            <!-- Inside the Campaign Management card -->
                            <div class="mt-4 p-4 rounded-2xl bg-slate-900 text-white">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                            Internal Streaming</p>
                                        <h4 class="text-sm font-bold mt-1">Status:
                                            {{ $campaign->is_live ? '🔴 LIVE' : '⚪ Offline' }}</h4>
                                    </div>

                                    @if ($campaign->is_live)
                                        <form action="{{ route('campaigns.stream.stop', $campaign) }}" method="POST">
                                            @csrf
                                            <button class="px-4 py-2 bg-red-600 rounded-lg text-xs font-bold">End
                                                Stream</button>
                                        </form>
                                    @else
                                        <form action="{{ route('campaigns.stream.start', $campaign) }}" method="POST">
                                            @csrf
                                            <button class="px-4 py-2 bg-emerald-600 rounded-lg text-xs font-bold">Go
                                                Live</button>
                                        </form>
                                    @endif
                                </div>

                                @if ($campaign->is_live)
                                    {{-- <div class="mt-4 pt-4 border-t border-slate-800">
                                        <p class="text-[10px] text-slate-400 mb-1 uppercase font-bold">Your Stream Key
                                            (Keep Secret)</p>
                                        <code
                                            class="text-xs bg-black p-2 rounded block border border-slate-700 text-emerald-400">{{ $campaign->stream_key }}</code>
                                        <p class="text-[10px] text-slate-500 mt-2 italic">Connect via OBS to:
                                            rtmp://your-server-ip/live</p>
                                    </div> --}}
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-3 w-full lg:w-1/3 justify-end">
                                <a href="{{ route('campaigns.show', $campaign) }}"
                                    class="p-3 bg-slate-50 text-slate-600 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-all shadow-sm"
                                    title="View Public Page">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>

                                <!-- Trigger for Progress Update Modal (logic to be implemented) -->
                                <a href="#"
                                    class="flex items-center gap-2 px-4 py-3 bg-emerald-50 text-emerald-700 rounded-xl font-bold text-xs hover:bg-emerald-100 transition-all">
                                    <span class="material-symbols-outlined text-sm">post_add</span>
                                    Post Update
                                </a>

                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="flex items-center gap-2 px-4 py-3 bg-slate-900 text-white rounded-xl font-bold text-xs hover:bg-slate-800 transition-all">
                                        <span class="material-symbols-outlined text-sm">settings</span>
                                        Manage
                                    </button>
                                    <!-- Simple Dropdown for Status -->
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 z-50 p-2">
                                        <form action="{{ route('campaigns.status', $campaign) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button name="status" value="active"
                                                class="w-full text-left px-4 py-2 text-xs font-bold hover:bg-emerald-50 rounded-lg {{ $campaign->status == 'active' ? 'text-emerald-600' : '' }}">Set
                                                as Active</button>
                                            <button name="status" value="paused"
                                                class="w-full text-left px-4 py-2 text-xs font-bold hover:bg-amber-50 rounded-lg {{ $campaign->status == 'paused' ? 'text-amber-600' : '' }}">Pause
                                                Campaign</button>
                                            <button name="status" value="completed"
                                                class="w-full text-left px-4 py-2 text-xs font-bold hover:bg-slate-50 rounded-lg {{ $campaign->status == 'completed' ? 'text-slate-600' : '' }}">Mark
                                                Completed</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                            <span class="material-symbols-outlined text-6xl text-slate-200">campaign</span>
                            <p class="text-slate-500 mt-4">You haven't created any campaigns yet.</p>
                            <a href="{{ route('campaigns.create') }}"
                                class="text-emerald-600 font-bold hover:underline mt-2 block">Start your first
                                journey</a>
                        </div>
                    @endforelse

                    <div class="mt-8">
                        {{ $campaigns->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>



    {{-- <!-- Inside the @foreach ($campaigns as $campaign) loop in manage.blade.php --> --}}

    <div x-data="{ openUpdateModal: false }">
        <!-- Trigger Button -->
        <button @click="openUpdateModal = true"
            class="flex items-center gap-2 px-4 py-3 bg-emerald-50 text-emerald-700 rounded-xl font-bold text-xs hover:bg-emerald-100 transition-all">
            <span class="material-symbols-outlined text-sm">post_add</span>
            Post Update
        </button>

        <!-- Modal Backdrop -->
        <div x-show="openUpdateModal"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm px-4">
            <!-- Modal Content -->
            <div @click.away="openUpdateModal = false"
                class="bg-white max-w-lg w-full p-8 rounded-[2rem] shadow-2xl border border-emerald-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-slate-900">Post Progress Update</h2>
                    <button @click="openUpdateModal = false" class="text-slate-400 hover:text-slate-600">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form action="{{ route('campaigns.progress.store', $campaign) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Update Title</label>
                        <input type="text" name="title" placeholder="e.g. Distribution Started in Bogura"
                            class="w-full border-none border-b-2 border-slate-100 focus:border-emerald-500 focus:ring-0 font-bold py-2"
                            required>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Details</label>
                        <textarea name="description" rows="4" placeholder="Describe what happened... (Max 1000 chars)"
                            class="w-full border-2 border-dashed border-slate-100 rounded-xl p-4 focus:border-emerald-500 focus:ring-0 mt-2"
                            required></textarea>
                    </div>

                    <button type="submit"
                        class="w-full py-4 bg-emerald-600 text-white rounded-xl font-bold shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all">
                        Publish to Timeline
                    </button>
                </form>
            </div>
        </div>
    </div>


</x-app-layout>
