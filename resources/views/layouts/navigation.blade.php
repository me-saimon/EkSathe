<nav x-data="{ mobileMenu: false, userDropdown: false }" class="fixed top-0 w-full z-[60] border-b border-white/40 bg-white/80 backdrop-blur-xl shadow-sm font-manrope">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">

        <!-- Left Side: Logo & Main Navigation -->
        <div class="flex items-center gap-12">
            <!-- Logo -->
            <a href="/" class="text-xl font-extrabold tracking-tighter text-emerald-600 flex items-center gap-2">
                {{-- <span class="material-symbols-outlined text-2xl">volunteer_activism</span> --}}
                EkSathe
            </a>

            <!-- Desktop Public Links -->
            <div class="hidden md:flex gap-8 items-center">
                <a href="{{ route('campaigns.index') }}"
                   class="text-sm font-bold tracking-tight transition-colors {{ request()->routeIs('campaigns.index') ? 'text-emerald-600 border-b-2 border-emerald-600 pb-1' : 'text-slate-600 hover:text-emerald-500' }}">
                   Explore
                </a>
                <a href="{{ route('help.request.create') }}"
                   class="text-sm font-bold tracking-tight transition-colors {{ request()->routeIs('help.request.create') ? 'text-emerald-600 border-b-2 border-emerald-600 pb-1' : 'text-slate-600 hover:text-emerald-500' }}">
                   Request Help
                </a>
                <a href="#" class="text-sm font-bold tracking-tight text-slate-600 hover:text-emerald-500 transition-colors">How it Works</a>
            </div>
        </div>

        <!-- Right Side: User Actions -->
        <div class="flex items-center gap-4">

            @guest
                <div class="hidden md:flex items-center gap-2">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 px-4 py-2 hover:text-emerald-600">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-slate-100 text-slate-900 px-6 py-2.5 rounded-full text-sm font-bold hover:bg-slate-200 transition-all">Join</a>
                </div>
            @endguest

            @auth
                <!-- User Profile Dropdown -->
                <div class="relative">
                    <button @click="userDropdown = !userDropdown" @click.away="userDropdown = false" class="flex items-center gap-2 p-1.5 pr-4 bg-slate-50 hover:bg-white border border-slate-100 rounded-full transition-all shadow-sm">
                        <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-emerald-500 shadow-inner">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->full_name) }}&background=059669&color=fff" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-[10px] font-bold text-slate-400 uppercase leading-none">Account</p>
                            <p class="text-xs font-black text-slate-700 leading-tight">{{ explode(' ', Auth::user()->full_name)[0] }}</p>
                        </div>
                        <span class="material-symbols-outlined text-slate-400 text-sm">expand_more</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="userDropdown"
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-slate-100 py-3 z-[70] overflow-hidden">

                        <!-- Admin Access Link -->
                        @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-bold text-purple-600 bg-purple-50 hover:bg-purple-100 transition-colors mx-2 rounded-xl mb-2">
                            <span class="material-symbols-outlined">admin_panel_settings</span>
                            Admin Dashboard
                        </a>
                        @endif

                        <div class="px-5 py-2">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Personal Hub</p>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-bold text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                            <span class="material-symbols-outlined text-lg">person_edit</span>
                            Profile Settings
                        </a>

                        <a href="{{ route('profile.donations') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-bold text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                            <span class="material-symbols-outlined text-lg">payments</span>
                            Donation History
                        </a>

                        <a href="{{ route('volunteer.history') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-bold text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                            <span class="material-symbols-outlined text-lg">volunteer_activism</span>
                            Volunteer History
                        </a>

                        <div class="px-5 py-2 mt-2">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Creator Hub</p>
                        </div>

                        <a href="{{ route('campaigns.mine') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-bold text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                            <span class="material-symbols-outlined text-lg">campaign</span>
                            My Campaigns
                        </a>

                        <!-- Logout -->
                        <div class="border-t border-slate-50 mt-3 pt-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-sm font-bold text-red-500 hover:bg-red-50 transition-colors text-left">
                                    <span class="material-symbols-outlined text-lg">logout</span>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Global Action Button -->
            <a href="{{ route('campaigns.create') }}" class="hidden sm:flex items-center gap-2 bg-emerald-600 text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-emerald-100 hover:bg-emerald-700 active:scale-95 transition-all">
                <span class="material-symbols-outlined text-lg">add_circle</span>
                Start Campaign
            </a>

            <!-- Mobile Menu Toggle -->
            <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-slate-600 bg-slate-100 rounded-lg">
                <span class="material-symbols-outlined" x-text="mobileMenu ? 'close' : 'menu'">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div x-show="mobileMenu"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden bg-white border-t border-slate-100 p-6 space-y-4 shadow-xl font-bold">

        <a href="{{ route('campaigns.index') }}" class="block text-slate-700 px-4 py-2 rounded-xl hover:bg-slate-50">Explore Campaigns</a>
        <a href="{{ route('help.request.create') }}" class="block text-slate-700 px-4 py-2 rounded-xl hover:bg-slate-50">Request Help</a>

        @guest
            <hr class="border-slate-100">
            <a href="{{ route('login') }}" class="block text-emerald-600 px-4 py-2">Sign In</a>
            <a href="{{ route('register') }}" class="block bg-emerald-600 text-white text-center py-3 rounded-xl">Join ImpactFlow</a>
        @endguest

        @auth
            <hr class="border-slate-100">
            <a href="{{ route('profile.edit') }}" class="block text-slate-700 px-4 py-2">Profile</a>
            <a href="{{ route('campaigns.mine') }}" class="block text-slate-700 px-4 py-2">My Campaigns</a>
            <a href="{{ route('volunteer.history') }}" class="block text-slate-700 px-4 py-2">Volunteer Impact</a>
        @endauth
    </div>
</nav>
