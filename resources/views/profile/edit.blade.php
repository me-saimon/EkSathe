<x-app-layout>
    <div class="flex pt-16 min-h-screen font-manrope">
        <!-- Sidebar Navigation -->
        <aside class="h-screen w-64 fixed left-0 top-16 border-r border-slate-100 bg-white shadow-none z-40">
            <div class="flex flex-col p-6 h-full justify-between">
                <div class="space-y-6">
                    <div class="pb-6 border-b border-slate-100">
                        <h4 class="text-emerald-800 font-bold text-lg">{{ Auth::user()->full_name }}</h4>
                        <p class="text-slate-500 text-xs uppercase tracking-widest">{{ Auth::user()->is_volunteer ? 'Verified Volunteer' : 'Global Benefactor' }}</p>
                    </div>
                    <nav class="space-y-2">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-emerald-700 bg-emerald-50/50 rounded-lg transition-all font-bold">
                            <span class="material-symbols-outlined">person</span>
                            <span>General Profile</span>
                        </a>
                        <a href="{{ route('profile.donations') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-lg transition-all">
                            <span class="material-symbols-outlined">history</span>
                            <span>Donation History</span>
                        </a>
                    </nav>
                </div>
                <div class="space-y-2 pb-20">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-lg transition-all">
                            <span class="material-symbols-outlined">logout</span>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-12 bg-slate-50 min-h-screen">
            <div class="max-w-4xl mx-auto space-y-8">

                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <!-- Profile Header Card -->
                    <section class="bg-white rounded-xl shadow-sm overflow-hidden p-12 border border-slate-100">
                        <div class="flex flex-col md:flex-row items-center gap-12 mb-12">
                            <!-- Avatar Section -->
                            <div class="relative group cursor-pointer">
                                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-xl">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->full_name) }}&background=006c49&color=fff" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <label for="avatar-upload" class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                    <span class="material-symbols-outlined text-white text-3xl">camera_alt</span>
                                </label>
                                <input type="file" id="avatar-upload" name="avatar" class="hidden" onchange="this.form.submit()">
                            </div>

                            <!-- Title & Badge -->
                            <div class="flex-1 text-center md:text-left space-y-2">
                                <div class="flex flex-col md:flex-row md:items-center gap-3">
                                    <h1 class="text-3xl font-extrabold text-slate-900">{{ Auth::user()->full_name }}</h1>
                                    @if(Auth::user()->is_volunteer)
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold border border-emerald-200">
                                        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                                        Verified Volunteer
                                    </span>
                                    @endif
                                </div>
                                <p class="text-slate-500">Manage your humanitarian identity and contribution preferences.</p>
                            </div>
                        </div>

                        <!-- Information Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-slate-50">
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Full Name</label>
                                <input name="full_name" type="text" value="{{ old('full_name', Auth::user()->full_name) }}" class="w-full px-4 py-3 bg-slate-50 border-none border-b-2 border-slate-200 focus:border-emerald-600 focus:ring-0 transition-all font-bold text-slate-900 rounded-t-lg">
                                @error('full_name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Email Address (Locked)</label>
                                <div class="relative">
                                    <input type="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-3 bg-slate-100 border-none border-b-2 border-slate-100 cursor-not-allowed text-slate-400 rounded-t-lg" readonly>
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-300">lock</span>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Phone Number</label>
                                <input name="phone" type="tel" value="{{ old('phone', Auth::user()->phone) }}" placeholder="+880 1XXX-XXXXXX" class="w-full px-4 py-3 bg-slate-50 border-none border-b-2 border-slate-200 focus:border-emerald-600 focus:ring-0 transition-all font-bold text-slate-900 rounded-t-lg">
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Account Verified Status</label>
                                <div class="px-4 py-3 bg-slate-100 rounded-t-lg text-slate-500 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-emerald-600">verified_user</span>
                                    {{ Auth::user()->verified_at ? 'Email Verified' : 'Pending Verification' }}
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Volunteer Toggle Card -->
                    <section class="mt-8 bg-white rounded-xl shadow-sm border border-slate-100 p-8 group hover:border-emerald-200 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                    <span class="material-symbols-outlined text-2xl">volunteer_activism</span>
                                </div>
                                <div class="space-y-1">
                                    <h3 class="text-xl font-bold text-slate-900">Available for Volunteering</h3>
                                    <p class="text-slate-500 max-w-lg">You will be eligible to apply for donation campaigns and field operations worldwide.</p>
                                </div>
                            </div>
                            <!-- Switch -->
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input name="is_volunteer" value="1" type="checkbox" class="sr-only peer" {{ Auth::user()->is_volunteer ? 'checked' : '' }}>
                                <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-600"></div>
                            </label>
                        </div>
                    </section>

                    <!-- Action Footer -->
                    <footer class="flex items-center justify-end gap-6 mt-8">
                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-600 font-bold">Saved successfully.</p>
                        @endif
                        <button type="submit" class="px-10 py-3 bg-emerald-800 text-white rounded-lg font-bold shadow-lg shadow-emerald-200 hover:scale-105 transition-all">
                            Save Account Settings
                        </button>
                    </footer>
                </form>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-12">
                    <div class="glass-card p-8 rounded-xl flex flex-col gap-2 border border-white">
                        <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">Total Donated</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-extrabold text-emerald-900">৳{{ number_format(Auth::user()->donations->sum('amount')) }}</span>
                        </div>
                    </div>
                    <div class="glass-card p-8 rounded-xl flex flex-col gap-2 border border-white">
                        <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">Campaigns Joined</span>
                        <span class="text-3xl font-extrabold text-emerald-900">{{ Auth::user()->applications->where('status', 'approved')->count() }}</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
