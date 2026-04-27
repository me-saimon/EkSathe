<x-app-layout>
    <!-- Hero Banner Section -->
    <div class="relative h-[400px] w-full overflow-hidden pt-20">
        <img src="{{ asset('storage/' . $campaign->banner_image) }}" class="w-full h-full object-cover" alt="{{ $campaign->title }}">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-full py-12">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold uppercase rounded-full tracking-widest">
                        {{ $campaign->category }}
                    </span>
                    @if($campaign->status == 'active')
                    <div class="flex items-center gap-1.5 bg-white/20 backdrop-blur-md px-3 py-1 rounded-full">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        <span class="text-white text-[10px] font-bold uppercase">Live Campaign</span>
                    </div>
                    @endif
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white max-w-4xl font-manrope">
                    {{ $campaign->title }}
                </h1>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <!-- Left Column: Story & Transparency -->
            <div class="lg:col-span-8 space-y-12">

                <!-- Description -->
                <div class="prose prose-emerald max-w-none">
                    <h2 class="text-2xl font-bold text-on-surface mb-4">About this Campaign</h2>
                    <p class="text-secondary text-lg leading-relaxed">
                        {{ $campaign->description }}
                    </p>
                </div>

                <!-- Live Video Section -->
                @if($campaign->live_video_url)
                <div class="glass-card rounded-3xl p-8 border-l-4 border-l-emerald-500">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-emerald-600 text-3xl">videocam</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Live Transparency Stream</h3>
                            <p class="text-sm text-secondary">Real-time updates from the distribution site</p>
                        </div>
                    </div>
                    <!-- Responsive Video Embed Wrapper -->
                    <div class="aspect-video rounded-2xl overflow-hidden bg-black shadow-2xl">
                        @php
                            // Simple logic to convert YT link to Embed
                            $embedUrl = str_replace('watch?v=', 'embed/', $campaign->live_video_url);
                        @endphp
                        <iframe class="w-full h-full" src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                @endif

                <!-- Campaign Timeline (Progress Updates) -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold flex items-center gap-3">
                        <span class="material-symbols-outlined text-emerald-600">timeline</span>
                        Campaign Timeline
                    </h2>

                    <div class="relative border-l-2 border-slate-200 ml-4 pl-8 space-y-10">
                        @forelse($campaign->progressUpdates as $update)
                        <div class="relative">
                            <span class="absolute -left-[41px] top-0 w-5 h-5 bg-emerald-500 border-4 border-white rounded-full shadow-sm"></span>
                            <div class="glass-card p-6 rounded-2xl shadow-sm">
                                <span class="text-xs font-bold text-emerald-600 uppercase">{{ $update->created_at->format('M d, Y') }}</span>
                                <h4 class="font-bold text-lg mt-1">{{ $update->title }}</h4>
                                <p class="text-secondary mt-2">{{ $update->description }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-slate-400 italic">No updates have been posted yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Donation & Action Sidebar -->
            <div class="lg:col-span-4 space-y-8">

                <!-- Donation Card -->
                <div class="glass-card rounded-[2rem] p-8 shadow-xl border border-white sticky top-28">
                    <div class="mb-8">
                        <div class="flex justify-between items-end mb-3">
                            <span class="text-3xl font-extrabold text-on-surface">৳{{ number_format($totalDonated) }}</span>
                            <span class="text-sm font-bold text-emerald-600">{{ round($progressPercent) }}% reached</span>
                        </div>
                        <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 transition-all duration-1000" style="width: {{ $progressPercent }}%"></div>
                        </div>
                        <p class="text-sm text-secondary mt-3">Target: ৳{{ number_format($campaign->goal_amount) }}</p>
                    </div>

                    <div class="space-y-4">
                        <button class="w-full py-4 bg-emerald-600 text-white rounded-xl font-bold text-lg shadow-lg shadow-emerald-200 hover:bg-emerald-700 active:scale-95 transition-all">
                            Donate Now
                        </button>

                        @if($campaign->is_volunteer_need)
                        <a href="{{ route('volunteer.apply', $campaign->id) }}" class="w-full py-4 border-2 border-emerald-600 text-emerald-600 rounded-xl font-bold text-center block hover:bg-emerald-50 transition-all">
                            Apply as Volunteer
                        </a>
                        @endif
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-100 space-y-4">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($campaign->creator->full_name) }}" class="w-12 h-12 rounded-full border-2 border-emerald-100">
                            <div>
                                <p class="text-xs text-secondary font-bold uppercase tracking-wider">Campaign Organizer</p>
                                <p class="font-bold text-on-surface">{{ $campaign->creator->full_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Map Card -->
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="font-bold mb-4 flex items-center gap-2 text-on-surface">
                        <span class="material-symbols-outlined text-emerald-600">location_on</span>
                        Distribution Point
                    </h3>
                    <p class="text-sm text-secondary mb-4">{{ $campaign->address }}</p>
                    <!-- Mock Map Placeholder -->
                    <div class="w-full h-48 bg-slate-200 rounded-xl overflow-hidden relative">
                         @if($campaign->location_map)
                            <iframe class="w-full h-full" src="{{ $campaign->location_map }}" frameborder="0"></iframe>
                         @else
                            <div class="flex items-center justify-center h-full text-slate-400">Map not available</div>
                         @endif
                    </div>
                </div>

                <!-- Trust Score / Fact Checker -->
                <div class="bg-amber-50 rounded-2xl p-6 border border-amber-100">
                    <div class="flex items-center gap-3 text-amber-800 font-bold mb-2">
                        <span class="material-symbols-outlined">gpp_good</span>
                        Trust Verification
                    </div>
                    {{-- <p class="text-sm text-amber-700">Verified by {{ $campaign->factChecks->count() }} community members. 100% Transparency score.</p> --}}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
