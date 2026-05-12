<aside class="h-screen w-64 fixed left-0 top-16 border-r border-slate-100 bg-white shadow-none z-40 font-manrope">
    <div class="flex flex-col p-6 h-full justify-between">
        <div class="space-y-6">

            <!-- User Identity Card -->
            <div class="pb-6 border-b border-slate-100">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-emerald-500 shadow-sm">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->full_name) }}&background=059669&color=fff" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="text-slate-900 font-black text-sm truncate">{{ Auth::user()->full_name }}</h4>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            {{ Auth::user()->role === 'admin' ? 'Platform Admin' : 'Impact Member' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation Groups -->
            <nav class="space-y-6 overflow-y-auto max-h-[calc(100vh-300px)]">

                <!-- Personal Hub (Donor/Volunteer) -->
                <div class="space-y-2">
                    <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Personal Hub</p>

                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('profile.edit') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('profile.edit') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-500' }}">person</span>
                        <span class="text-sm">Profile Settings</span>
                    </a>

                    <a href="{{ route('profile.donations') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('profile.donations') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('profile.donations') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-500' }}">payments</span>
                        <span class="text-sm">Donation History</span>
                    </a>

                    <a href="{{ route('volunteer.history') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('volunteer.history') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('volunteer.history') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-500' }}">volunteer_activism</span>
                        <span class="text-sm">Volunteer History</span>
                    </a>
                </div>

                <!-- Creator Hub (My Campaigns) -->
                <div class="space-y-2">
                    <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Creator Hub</p>

                    <a href="{{ route('campaigns.mine') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('campaigns.mine') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('campaigns.mine') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-500' }}">campaign</span>
                        <span class="text-sm">My Campaigns</span>
                    </a>
                </div>

                <!-- Admin Suite (Only for Admins) -->
                @if(Auth::user()->role === 'admin')
                <div class="space-y-2 pt-4 border-t border-slate-50">
                    <p class="px-4 text-[10px] font-bold text-purple-500 uppercase tracking-widest">Admin Suite</p>

                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-purple-50 text-purple-700 font-bold' : 'text-slate-500 hover:bg-purple-50 hover:text-purple-600' }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'text-purple-600' : 'text-slate-400 group-hover:text-purple-500' }}">dashboard</span>
                        <span class="text-sm">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.help.requests') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.help.requests') ? 'bg-purple-50 text-purple-700 font-bold' : 'text-slate-500 hover:bg-purple-50 hover:text-purple-600' }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.help.requests') ? 'text-purple-600' : 'text-slate-400 group-hover:text-purple-500' }}">emergency</span>
                        <span class="text-sm">Help Requests</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.users.index') ? 'bg-purple-50 text-purple-700 font-bold' : 'text-slate-500 hover:bg-purple-50 hover:text-purple-600' }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.users.index') ? 'text-purple-600' : 'text-slate-400 group-hover:text-purple-500' }}">group</span>
                        <span class="text-sm">User Directory</span>
                    </a>

                    <a href="{{ route('admin.campaigns') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.campaigns') ? 'bg-purple-50 text-purple-700 font-bold' : 'text-slate-500 hover:bg-purple-50 hover:text-purple-600' }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.campaigns') ? 'text-purple-600' : 'text-slate-400 group-hover:text-purple-500' }}">gpp_maybe</span>
                        <span class="text-sm">Audit Logic</span>
                    </a>

                     <a href="{{ route('admin.donations.index') }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.donations.index') ? 'bg-purple-50 text-purple-700 font-bold' : 'text-slate-500 hover:bg-purple-50 hover:text-purple-600' }}">
                        <span class="material-symbols-outlined text-lg">account_balance_wallet</span>
                        <span class="text-sm">Financial Ledger</span>
                    </a>
                </div>
                @endif
            </nav>
        </div>

        <!-- Footer Actions -->
        <div class="space-y-4 pb-20">
            <a href="{{ route('campaigns.create') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-emerald-600 text-white rounded-xl text-xs font-bold shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all">
                <span class="material-symbols-outlined text-sm">add_circle</span>
                New Campaign
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all text-sm font-bold">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </div>
</aside>
