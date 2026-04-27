<x-app-layout>
    <style>
        .pulse-indicator { animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes pulse-ring { 0%, 100% { opacity: 1; } 50% { opacity: .5; } }
    </style>

    <main class="flex-grow pt-32 pb-24 px-8">
        <div class="max-w-7xl mx-auto">

            <!-- Hero Summary Section -->
            <section class="mb-12">
                <div class="glass-card rounded-xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 border-l-4 border-l-primary">
                    <div class="flex items-center gap-6">
                        <div class="relative w-24 h-24 rounded-lg overflow-hidden shrink-0">
                            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $campaign->banner_image) }}" alt="Campaign Image" />
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span class="bg-emerald-100 text-emerald-700 px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    {{ $campaign->category }}
                                </span>
                                <div class="flex items-center gap-1.5 bg-emerald-50 px-2 py-0.5 rounded-full">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full pulse-indicator"></span>
                                    <span class="text-emerald-600 font-bold text-[10px]">LIVE NOW</span>
                                </div>
                            </div>
                            <h1 class="text-3xl font-bold text-on-background mb-1">{{ $campaign->title }}</h1>
                            <div class="flex items-center gap-2 text-secondary text-sm">
                                <span class="material-symbols-outlined text-sm">location_on</span>
                                <span>{{ $campaign->address }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Layout: Form & Sidebar -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- Left: Application Form -->
                <div class="lg:col-span-8">
                    <div class="glass-card rounded-xl p-12 shadow-sm">
                        <div class="mb-12 border-b border-slate-100 pb-6">
                            <h2 class="text-2xl font-bold">Volunteer Application</h2>
                            <p class="text-secondary mt-2">Join our mission to provide critical aid. Please confirm your details below.</p>
                        </div>

                        <form action="{{ route('volunteer.store', $campaign) }}" method="POST" class="space-y-8">
                            @csrf

                            <!-- Verified Info Section (Pulls from Auth User) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-500 uppercase">Full Name</label>
                                    <div class="relative">
                                        <input class="w-full bg-slate-50 border-none border-b-2 border-slate-200 py-3 pr-10 focus:ring-0 cursor-not-allowed" readonly type="text" value="{{ Auth::user()->full_name }}" />
                                        <span class="material-symbols-outlined absolute right-0 top-1/2 -translate-y-1/2 text-primary" style="font-variation-settings: 'FILL' 1;">verified</span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-500 uppercase">Phone Number</label>
                                    <div class="relative">
                                        <input class="w-full bg-slate-50 border-none border-b-2 border-slate-200 py-3 pr-10 focus:ring-0 cursor-not-allowed" readonly type="text" value="{{ Auth::user()->phone ?? 'No phone added' }}" />
                                        <span class="material-symbols-outlined absolute right-0 top-1/2 -translate-y-1/2 text-primary" style="font-variation-settings: 'FILL' 1;">verified</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Motivation Text Area -->
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-500 uppercase">Why do you want to join this mission?</label>
                                <textarea name="application_notes" class="w-full bg-transparent border-none border-b-2 border-slate-200 focus:ring-0 focus:border-primary py-3 px-0 resize-none transition-all placeholder:text-slate-300" placeholder="Tell us about your motivation and skills..." rows="6" required>{{ old('application_notes') }}</textarea>
                                @error('application_notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="w-full md:w-auto px-12 py-4 bg-primary text-white rounded-xl font-bold text-lg hover:shadow-lg hover:shadow-emerald-200 transition-all active:scale-95">
                                    Submit Application
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right: Sidebar -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Impact Box -->
                    <div class="glass-card rounded-xl p-8 bg-emerald-50/50 border border-emerald-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-bold text-primary uppercase tracking-widest">Community Impact</h3>
                            <span class="material-symbols-outlined text-primary">groups</span>
                        </div>
                        <p class="text-2xl font-bold mb-4">{{ $campaign->volunteerApplications->count() }} Volunteers Joined</p>
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://ui-avatars.com/api/?name=User+1">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://ui-avatars.com/api/?name=User+2">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://ui-avatars.com/api/?name=User+3">
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-emerald-500 text-white flex items-center justify-center text-xs font-bold">+</div>
                        </div>
                    </div>

                    <!-- Responsibilities Card -->
                    <div class="glass-card rounded-xl p-8 shadow-sm">
                        <h3 class="text-xl font-bold mb-6">Your Responsibilities</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-primary text-xl">inventory_2</span>
                                </div>
                                <div>
                                    <p class="font-bold text-sm">Distribution Support</p>
                                    <p class="text-xs text-secondary">Organize and hand out supplies to families.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-primary text-xl">edit_note</span>
                                </div>
                                <div>
                                    <p class="font-bold text-sm">Documentation</p>
                                    <p class="text-xs text-secondary">Capture stories and manage records.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
