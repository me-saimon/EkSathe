<x-app-layout>
    <main class="pt-32 pb-24 px-8 max-w-[1280px] mx-auto">
        <div class="mb-12 flex justify-between items-end">
            <div>
                <h1 class="font-manrope text-5xl font-bold text-on-surface mb-2">Edit Campaign</h1>
                <p class="text-lg text-secondary">Update your project details to maintain transparency and donor trust.</p>
            </div>
            <a href="{{ route('campaigns.mine') }}" class="text-slate-500 font-bold hover:text-emerald-600 flex items-center gap-2">
                <span class="material-symbols-outlined">arrow_back</span>
                Back to Dashboard
            </a>
        </div>

        <form action="{{ route('campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            @csrf
            @method('PATCH')

            <!-- Left Column -->
            <div class="lg:col-span-8 space-y-6">
                <div class="glass-card rounded-xl p-8 shadow-sm">

                    <!-- Banner Upload -->
                    <div class="mb-8">
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Campaign Banner</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Current Image -->
                            <div class="relative h-40 rounded-xl overflow-hidden border border-slate-200">
                                <img src="{{ asset('storage/' . $campaign->banner_image) }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-white text-xs font-bold">CURRENT BANNER</div>
                            </div>
                            <!-- Upload New -->
                            <div class="relative h-40 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 transition-colors group">
                                <input type="file" name="banner_image" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                                <span class="material-symbols-outlined text-2xl text-slate-400 mb-1">sync</span>
                                <span class="text-xs font-bold text-on-surface">Replace Image</span>
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-2 italic">Leave empty to keep the current banner.</p>
                    </div>

                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Campaign Title</label>
                            <input name="title" value="{{ old('title', $campaign->title) }}" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 text-2xl font-bold transition-colors" type="text" required />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Primary Category</label>
                                <select name="category" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 transition-colors font-bold text-slate-700">
                                    @foreach(['Winter', 'Food', 'Disaster', 'Education', 'Healthcare'] as $cat)
                                        <option value="{{ $cat }}" {{ $campaign->category == $cat ? 'selected' : '' }}>{{ $cat }} Relief</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Live Stream URL -->
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Live Stream URL</label>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-0 text-slate-400">videocam</span>
                                    <input name="live_video_url" value="{{ old('live_video_url', $campaign->live_video_url) }}" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 pl-8 transition-colors" type="url" />
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Detailed Description</label>
                            <textarea name="description" rows="10" class="w-full rounded-xl border border-slate-200 bg-white p-4 focus:ring-emerald-500 focus:border-emerald-500" required>{{ old('description', $campaign->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (Sidebar) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="glass-card rounded-xl p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-on-surface mb-6">Parameters</h3>

                    <div class="space-y-6">
                        <!-- Goal Amount -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Goal Amount (৳)</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-0 text-slate-400">payments</span>
                                <input name="goal_amount" value="{{ old('goal_amount', $campaign->goal_amount) }}" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 pl-8 text-2xl font-bold text-emerald-600" type="number" required />
                            </div>
                        </div>

                        <!-- End Date -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Event Date</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-0 text-slate-400">calendar_today</span>
                                <input name="campaign_date" value="{{ old('campaign_date', $campaign->campaign_date ? $campaign->campaign_date->format('Y-m-d\TH:i') : '') }}" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 pl-8" type="datetime-local" required />
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Distribution Address</label>
                            <input name="address" value="{{ old('address', $campaign->address) }}" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 transition-colors font-bold" type="text" required />
                        </div>

                        <!-- Volunteer Toggle -->
                        <div class="flex items-center justify-between py-4 border-t border-slate-100">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-on-surface">Volunteer Needed?</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input name="is_volunteer_need" value="1" type="checkbox" class="sr-only peer" {{ $campaign->is_volunteer_need ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold text-lg shadow-lg active:scale-95 transition-transform">
                        Update Campaign
                    </button>
                </div>
            </div>
        </form>
    </main>
</x-app-layout>
