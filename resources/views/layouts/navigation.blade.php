<nav x-data="{ open: false, userDropdown: false }" class="fixed top-0 w-full z-[60] border-b border-white/40 bg-white/70 backdrop-blur-xl shadow-sm font-manrope">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <!-- Logo & Main Links -->
        <div class="flex items-center gap-12">
            <a href="/" class="text-xl font-extrabold tracking-tighter text-emerald-600">EkSathe</a>

            <div class="hidden md:flex gap-8 items-center">
                <a href="{{ route('campaigns.index') }}" class="text-sm font-semibold tracking-tight {{ request()->routeIs('campaigns.index') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-500' }} transition-colors">Explore</a>
                <a href="{{ route('help.request.create') }}" class="text-sm font-semibold tracking-tight {{ request()->routeIs('help.request.create') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-500' }} transition-colors">Request Help</a>
                <a href="#" class="text-sm font-semibold tracking-tight text-slate-600 hover:text-emerald-500 transition-colors">Impact Hub</a>
            </div>
        </div>

        <!-- Auth Actions -->
        <div class="flex items-center gap-4">
            @guest
                <a href="{{ route('login') }}" class="hidden lg:block text-sm font-bold text-slate-600 px-4 py-2 hover:text-emerald-600">Sign In</a>
                <a href="{{ route('register') }}" class="hidden lg:block text-sm font-bold text-slate-600 px-4 py-2 border border-slate-200 rounded-full hover:bg-slate-50">Join Community</a>
            @endguest

            @auth
                <!-- User Profile Dropdown -->
                <div class="relative">
                    <button @click="userDropdown = !userDropdown" @click.away="userDropdown = false" class="flex items-center gap-2 p-1 pr-3 hover:bg-slate-100 rounded-full transition-all">
                        <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-emerald-500">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->full_name) }}&background=059669&color=fff" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <span class="text-xs font-bold text-slate-700 hidden sm:block">{{ explode(' ', Auth::user()->full_name)[0] }}</span>
                        <span class="material-symbols-outlined text-sm text-slate-400">expand_more</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="userDropdown" x-transition class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                        <div class="px-4 py-2 border-b border-slate-50 mb-2">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Account</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                            <span class="material-symbols-outlined text-lg">person_edit</span>
                            Profile Settings
                        </a>
                        <a href="{{ route('campaigns.mine') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                            <span class="material-symbols-outlined text-lg">campaign</span>
                            My Campaigns
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                            <span class="material-symbols-outlined text-lg">volunteer_activism</span>
                            Volunteer History
                        </a>
                        <div class="border-t border-slate-50 mt-2 pt-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors">
                                    <span class="material-symbols-outlined text-lg">logout</span>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            <a href="{{ route('campaigns.create') }}" class="bg-emerald-600 text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-emerald-100 hover:opacity-90 active:scale-95 transition-all">
                Start a Campaign
            </a>

            <!-- Mobile Menu Toggle -->
            <button @click="open = !open" class="md:hidden p-2 text-slate-600">
                <span class="material-symbols-outlined" x-text="open ? 'close' : 'menu'">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="md:hidden bg-white border-t border-slate-100 p-6 space-y-4 shadow-xl">
        <a href="{{ route('campaigns.index') }}" class="block text-lg font-bold text-slate-700">Explore</a>
        <a href="{{ route('help.request.create') }}" class="block text-lg font-bold text-slate-700">Request Help</a>
        <hr>
        @guest
            <a href="{{ route('login') }}" class="block text-lg font-bold text-emerald-600">Sign In</a>
        @endguest
    </div>
</nav>
