<x-app-layout>
    <div class="flex pt-16 min-h-screen font-manrope">
        <!-- Sidebar Navigation (Same as Profile) -->
        <aside class="h-screen w-64 fixed left-0 top-16 border-r border-slate-100 bg-white shadow-none z-40">
            <div class="flex flex-col p-6 h-full justify-between">
                <div class="space-y-6">
                    <nav class="space-y-2">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-lg transition-all">
                            <span class="material-symbols-outlined">person</span>
                            <span>General Profile</span>
                        </a>
                        <a href="{{ route('campaigns.mine') }}" class="flex items-center gap-3 px-4 py-3 text-emerald-700 bg-emerald-50/50 rounded-lg transition-all font-bold">
                            <span class="material-symbols-outlined">campaign</span>
                            <span>My Campaigns</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-lg transition-all">
                            <span class="material-symbols-outlined">volunteer_activism</span>
                            <span>Volunteer History</span>
                        </a>
                    </nav>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-12 bg-slate-50 min-h-screen">
            <div class="max-w-6xl mx-auto">

                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900">Manage Campaigns</h1>
                        <p class="text-slate-500">Track your impact and manage your community.</p>
                    </div>
                    <a href="{{ route('campaigns.create') }}" class="px-6 py-3 bg-emerald-600 text-white rounded-xl font-bold flex items-center gap-2 hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">
                        <span class="material-symbols-outlined">add</span>
                        New Campaign
                    </a>
                </div>

                <!-- Campaign Management Cards -->
                <div class="space-y-6">
                    @forelse($campaigns as $campaign)
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col lg:flex-row gap-8 items-center">
                        <!-- Image & Basic Info -->
                        <div class="flex items-center gap-6 w-full lg:w-1/3">
                            <img src="{{ asset('storage/' . $campaign->banner_image) }}" class="w-24 h-24 rounded-2xl object-cover shadow-sm">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">{{ $campaign->category }}</span>
                                <h3 class="text-lg font-bold text-slate-900 mt-1 line-clamp-1">{{ $campaign->title }}</h3>
                                <div class="flex items-center gap-2 mt-2">
                                    @php
                                        $statusColors = [
                                            'active' => 'bg-emerald-500',
                                            'paused' => 'bg-amber-500',
                                            'completed' => 'bg-slate-400'
                                        ];
                                    @endphp
                                    <span class="w-2 h-2 rounded-full {{ $statusColors[$campaign->status] }}"></span>
                                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ $campaign->status }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stats: Raised & Volunteers -->
                        <div class="grid grid-cols-2 gap-8 w-full lg:w-1/3 border-x border-slate-50 px-8">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Raised</p>
                                <p class="text-xl font-extrabold text-emerald-700">৳{{ number_format($campaign->total_raised ?? 0) }}</p>
                                <p class="text-[10px] text-slate-400">Target: ৳{{ number_format($campaign->goal_amount) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Volunteers</p>
                                <p class="text-xl font-extrabold text-slate-900">{{ $campaign->volunteer_applications_count }}</p>
                                <p class="text-[10px] text-slate-400">Applicants</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3 w-full lg:w-1/3 justify-end">
                            <a href="{{ route('campaigns.show', $campaign) }}" class="p-3 bg-slate-50 text-slate-600 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-all shadow-sm" title="View Public Page">
                                <span class="material-symbols-outlined">visibility</span>
                            </a>

                            <!-- Trigger for Progress Update Modal (logic to be implemented) -->
                            <a href="#" class="flex items-center gap-2 px-4 py-3 bg-emerald-50 text-emerald-700 rounded-xl font-bold text-xs hover:bg-emerald-100 transition-all">
                                <span class="material-symbols-outlined text-sm">post_add</span>
                                Post Update
                            </a>

                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center gap-2 px-4 py-3 bg-slate-900 text-white rounded-xl font-bold text-xs hover:bg-slate-800 transition-all">
                                    <span class="material-symbols-outlined text-sm">settings</span>
                                    Manage
                                </button>
                                <!-- Simple Dropdown for Status -->
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 z-50 p-2">
                                    <form action="{{ route('campaigns.status', $campaign) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button name="status" value="active" class="w-full text-left px-4 py-2 text-xs font-bold hover:bg-emerald-50 rounded-lg {{ $campaign->status == 'active' ? 'text-emerald-600' : '' }}">Set as Active</button>
                                        <button name="status" value="paused" class="w-full text-left px-4 py-2 text-xs font-bold hover:bg-amber-50 rounded-lg {{ $campaign->status == 'paused' ? 'text-amber-600' : '' }}">Pause Campaign</button>
                                        <button name="status" value="completed" class="w-full text-left px-4 py-2 text-xs font-bold hover:bg-slate-50 rounded-lg {{ $campaign->status == 'completed' ? 'text-slate-600' : '' }}">Mark Completed</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                        <span class="material-symbols-outlined text-6xl text-slate-200">campaign</span>
                        <p class="text-slate-500 mt-4">You haven't created any campaigns yet.</p>
                        <a href="{{ route('campaigns.create') }}" class="text-emerald-600 font-bold hover:underline mt-2 block">Start your first journey</a>
                    </div>
                    @endforelse

                    <div class="mt-8">
                        {{ $campaigns->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
