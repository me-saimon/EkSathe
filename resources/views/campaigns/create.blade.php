<x-app-layout>
    <main class="pt-32 pb-24 px-8 max-w-[1280px] mx-auto">
        <div class="mb-12">
            <h1 class="font-manrope text-5xl font-bold text-on-surface mb-2">Launch Your Impact</h1>
            <p class="text-lg text-secondary max-w-2xl">Create an institutional-grade campaign and connect with a global community of purpose-driven investors.</p>
        </div>

        <form action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            @csrf

            <!-- Left Column (Main Content) -->
            <div class="lg:col-span-8 space-y-6">
                <div class="glass-card rounded-xl p-8 shadow-sm">

                    <!-- Banner Upload -->
                    <div class="mb-8">
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Campaign Banner</label>
                        <div class="relative w-full h-64 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 transition-colors group overflow-hidden">
                            <input type="file" name="banner_image" class="absolute inset-0 opacity-0 cursor-pointer z-20" required>
                            <span class="material-symbols-outlined text-4xl text-slate-400 mb-2">cloud_upload</span>
                            <span class="font-bold text-on-surface">Click to upload banner image</span>
                            <span class="text-xs text-slate-500">Optimal size 1200 x 480px (Max 5MB)</span>
                        </div>
                        @error('banner_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Campaign Title</label>
                            <input name="title" value="{{ old('title') }}" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 text-2xl font-bold transition-colors placeholder:text-slate-300" placeholder="e.g. Winter Clothes for Northern Village" type="text" required />
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Primary Category</label>
                                <select name="category" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 transition-colors">
                                    <option value="Winter">Winter Relief</option>
                                    <option value="Food">Food Security</option>
                                    <option value="Disaster">Disaster Response</option>
                                    <option value="Education">Education</option>
                                    <option value="Healthcare">Healthcare</option>
                                </select>
                            </div>

                            <!-- Live Stream URL -->
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Live Stream URL (Optional)</label>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-0 text-slate-400">videocam</span>
                                    <input name="live_video_url" value="{{ old('live_video_url') }}" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 pl-8 transition-colors" placeholder="https://youtube.com/..." type="url" />
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Detailed Description</label>
                            <textarea name="description" rows="10" class="w-full rounded-xl border border-slate-200 bg-white p-4 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Explain your mission, how the money will be used, and the impact it will create..." required>{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (Sidebar) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="glass-card rounded-xl p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-on-surface mb-6">Campaign Parameters</h3>

                    <div class="space-y-6">
                        <!-- Goal Amount -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Goal Amount (৳)</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-0 text-slate-400">payments</span>
                                <input name="goal_amount" value="{{ old('goal_amount') }}" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 pl-8 text-2xl font-bold text-emerald-600" placeholder="50000" type="number" required />
                            </div>
                        </div>

                        <!-- End Date -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Event Date</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-0 text-slate-400">calendar_today</span>
                                <input name="campaign_date" value="{{ old('campaign_date') }}" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 pl-8" type="datetime-local" required />
                            </div>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Distribution Address</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-0 text-slate-400">location_on</span>
                                <input name="address" value="{{ old('address') }}" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 pl-8" placeholder="City, Area" type="text" required />
                            </div>
                        </div>

                        <!-- Location Map Embed -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Map Embed URL (Optional)</label>
                            <input name="location_map" value="{{ old('location_map') }}" class="w-full bg-transparent border-b-2 border-slate-200 focus:border-emerald-500 outline-none py-2 text-sm" placeholder="Paste Google Maps iframe src..." type="text" />
                        </div>

                        <!-- Volunteer Toggle -->
                        <div class="flex items-center justify-between py-4 border-t border-slate-100">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-on-surface">Volunteer Needed?</span>
                                <span class="text-xs text-slate-500">Enable community sign-ups</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input name="is_volunteer_need" value="1" type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <button type="submit" class="w-full bg-emerald-600 text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-emerald-200 active:scale-95 transition-transform">
                        Launch Campaign
                    </button>
                </div>
            </div>
        </form>
    </main>
</x-app-layout>
