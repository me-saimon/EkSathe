<x-app-layout>
    <!-- Hero Banner Section -->
    <div class="relative h-[400px] w-full overflow-hidden pt-20">
        <img src="{{ asset('storage/' . $campaign->banner_image) }}" class="w-full h-full object-cover"
            alt="{{ $campaign->title }}">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-full py-12">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex items-center gap-3 mb-4">
                    <span
                        class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold uppercase rounded-full tracking-widest">
                        {{ $campaign->category }}
                    </span>
                    @if ($campaign->status == 'active')
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
                <!-- Add Video.js CSS to your <head> via app.blade.php or here -->
<link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />

<!-- Inside campaigns/show.blade.php -->
@if($campaign->is_live)
<div class="glass-card rounded-3xl p-8 border-l-4 border-l-red-500 bg-red-50/30">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-red-600 text-3xl animate-pulse">sensors</span>
            </div>
            <div>
                <h3 class="text-xl font-bold text-red-900 uppercase tracking-tight">Direct Transparency Stream</h3>
                <p class="text-xs font-bold text-red-500">LIVE FROM THE FIELD</p>
            </div>
        </div>
        <div class="px-4 py-1 bg-red-600 text-white text-[10px] font-black rounded-full animate-bounce">
            LIVE
        </div>
    </div>

    <!-- The Internal Player -->
    <div class="aspect-video rounded-2xl overflow-hidden bg-black shadow-2xl border-4 border-white">
        <video id="internal-stream" class="video-js vjs-default-skin vjs-big-play-centered w-full h-full" controls preload="auto">
            <!-- The source points to your media server or HLS path -->
            <source src="https://your-media-server.com/hls/{{ $campaign->stream_key }}.m3u8" type="application/x-mpegURL">
            <p class="vjs-no-js">To view this video please enable JavaScript.</p>
        </video>
    </div>
</div>
@endif

<!-- Video.js JS -->
<script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
<script>
    if(document.getElementById('internal-stream')) {
        var player = videojs('internal-stream');
    }
</script>



                <!-- Live Video Section -->
                @if ($campaign->live_video_url)
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
                            <iframe class="w-full h-full" src="{{ $embedUrl }}" frameborder="0"
                                allowfullscreen></iframe>
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
                                <span
                                    class="absolute -left-[41px] top-0 w-5 h-5 bg-emerald-500 border-4 border-white rounded-full shadow-sm"></span>
                                <div class="glass-card p-6 rounded-2xl shadow-sm">
                                    <span
                                        class="text-xs font-bold text-emerald-600 uppercase">{{ $update->created_at->format('M d, Y') }}</span>
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

                <!-- Inside the Sidebar Donation Card -->
                <div class="glass-card rounded-[2rem] p-8 shadow-xl border border-white sticky top-28">
                    <div class="mb-8">
                        <div class="flex justify-between items-end mb-3">
                            <span
                                class="text-3xl font-extrabold text-on-surface">৳{{ number_format($totalDonated) }}</span>
                            <span class="text-sm font-bold text-emerald-600">{{ round($progressPercent) }}%
                                reached</span>
                        </div>
                        <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 transition-all duration-1000"
                                style="width: {{ $progressPercent }}%"></div>
                        </div>
                    </div>

                    <!-- Donation Form -->
                    <form action="{{ route('donate.initiate', $campaign) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Enter
                                Amount (BDT)</label>
                            <div class="relative mt-1">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">৳</span>
                                <input type="number" name="amount" min="10" placeholder="500"
                                    class="w-full pl-8 py-4 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 font-bold text-lg"
                                    required>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-4 bg-emerald-600 text-white rounded-xl font-bold text-lg shadow-lg shadow-emerald-100 hover:bg-emerald-700 active:scale-95 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">volunteer_activism</span>
                            Donate with SSLCommerz
                        </button>
                    </form>

                    @if ($campaign->is_volunteer_need)
                        <a href="{{ route('volunteer.apply', $campaign) }}"
                            class="w-full py-4 mt-4 border-2 border-emerald-600 text-emerald-600 rounded-xl font-bold text-center block hover:bg-emerald-50 transition-all">
                            Apply as Volunteer
                        </a>
                    @endif
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
                        @if ($campaign->location_map)
                            <iframe class="w-full h-full" src="{{ $campaign->location_map }}" frameborder="0"></iframe>
                        @else
                            <div class="flex items-center justify-center h-full text-slate-400">Map not available</div>
                        @endif
                    </div>
                </div>

                <!-- Community Trust & Fact Checker Section -->
                <div class="glass-card rounded-2xl p-6 border border-slate-100 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-emerald-600">verified_user</span>
                            Community Trust
                        </h3>
                        @php
                            $trustCount = $campaign->factChecks->where('vote', 1)->count();
                            $flagCount = $campaign->factChecks->where('vote', -1)->count();
                            $totalVotes = $trustCount + $flagCount;
                            $trustPercentage = $totalVotes > 0 ? round(($trustCount / $totalVotes) * 100) : 0;
                        @endphp
                        <span
                            class="text-xs font-bold {{ $trustPercentage >= 70 ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $trustPercentage }}% Trust Score
                        </span>
                    </div>

                    <!-- Trust Bar -->
                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden flex">
                        <div class="bg-emerald-500 h-full" style="width: {{ $trustPercentage }}%"></div>
                        <div class="bg-red-400 h-full" style="width: {{ 100 - $trustPercentage }}%"></div>
                    </div>

                    <p class="text-[10px] text-secondary leading-relaxed">
                        This score is based on {{ $totalVotes }} community verifications. Always do your own research
                        before donating.
                    </p>

                    <!-- Voting Actions -->
                    @auth
                        @if ($campaign->creator_by !== Auth::id())
                            <div class="flex gap-2 pt-2">
                                <form action="{{ route('campaigns.vote', $campaign) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button name="vote" value="1"
                                        class="w-full py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all {{ $campaign->factChecks->where('user_id', Auth::id())->where('vote', 1)->count() ? 'bg-emerald-600 text-white shadow-md' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                        Trust It
                                    </button>
                                </form>

                                <form action="{{ route('campaigns.vote', $campaign) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button name="vote" value="-1"
                                        class="w-full py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all {{ $campaign->factChecks->where('user_id', Auth::id())->where('vote', -1)->count()? 'bg-red-600 text-white shadow-md': 'bg-red-50 text-red-700 hover:bg-red-100' }}">
                                        Flag It
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="text-[10px] italic text-slate-400 text-center">You cannot vote on your own campaign.
                            </p>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="block text-center text-[10px] font-bold text-emerald-600 underline">Sign in to verify
                            this campaign</a>
                    @endauth
                </div>





            </div>
        </div>
    </div>
</x-app-layout>
