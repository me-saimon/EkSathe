<x-app-layout>
    <div class="pt-32 pb-24 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Header & Filter Bar -->
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <h1 class="text-4xl font-bold text-on-surface mb-2">Explore Campaigns</h1>
                    <p class="text-secondary">Discover initiatives making a real-world difference today.</p>
                </div>

                <!-- Category Filter UI -->
                <div class="flex gap-2 bg-white p-1.5 rounded-full shadow-sm border border-slate-200">
                    @foreach(['All', 'Winter', 'Food', 'Disaster', 'Education'] as $cat)
                    <a href="{{ route('campaigns.index', ['category' => $cat]) }}"
                       class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ (request('category', 'All') == $cat) ? 'bg-primary text-white shadow-md' : 'text-slate-600 hover:bg-slate-100' }}">
                        {{ $cat }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Campaign Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($campaigns as $campaign)
                <div class="glass-card rounded-3xl overflow-hidden group hover:-translate-y-2 transition-all duration-300 border border-white/50 flex flex-col">
                    <div class="relative h-56 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ asset('storage/' . $campaign->banner_image) }}" alt="{{ $campaign->title }}" />
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/80 backdrop-blur-md text-emerald-700 text-[10px] font-bold uppercase tracking-wider rounded-full shadow-sm">
                                {{ $campaign->category }}
                            </span>
                        </div>
                        @if($campaign->is_volunteer_need)
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 bg-amber-500 text-white text-[10px] font-bold uppercase tracking-wider rounded-full shadow-lg">
                                Volunteer Needed
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="p-6 flex-grow">
                        <h3 class="text-xl font-bold mb-2 group-hover:text-primary transition-colors line-clamp-1">{{ $campaign->title }}</h3>
                        <p class="text-sm text-secondary mb-6 line-clamp-2">{{ $campaign->description }}</p>

                        <!-- Progress Bar Logic -->
                        <div class="mb-4">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-bold text-on-surface">৳{{ number_format($campaign->donations->sum('amount')) }} <span class="text-secondary font-normal text-xs uppercase">raised</span></span>
                                <span class="text-sm font-bold text-primary">
                                    {{ $campaign->goal_amount > 0 ? round(($campaign->donations->sum('amount') / $campaign->goal_amount) * 100) : 0 }}%
                                </span>
                            </div>
                            <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500" style="width: {{ $campaign->goal_amount > 0 ? ($campaign->donations->sum('amount') / $campaign->goal_amount) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t border-slate-100/50 flex items-center justify-between bg-white/30">
                        <div class="flex items-center gap-2">
                            <img class="w-8 h-8 rounded-full border border-white" src="https://ui-avatars.com/api/?name={{ urlencode($campaign->creator->full_name) }}" />
                            <span class="text-xs font-semibold text-secondary">{{ $campaign->creator->full_name }}</span>
                        </div>
                        <a class="text-primary text-xs font-bold hover:underline flex items-center gap-1" href="{{ route('campaigns.show', $campaign->id) }}">
                            View Details <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-20">
                    <span class="material-symbols-outlined text-6xl text-slate-300">search_off</span>
                    <p class="text-slate-500 mt-4">No campaigns found in this category.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $campaigns->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
