<x-app-layout>
    <div class="flex pt-16 min-h-screen bg-slate-50 font-manrope">
        <!-- Admin Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-12">
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900">Community Directory</h1>
                    <p class="text-slate-500">Manage user roles, volunteers, and account statuses.</p>
                </div>

                <!-- Search Bar -->
                <form action="{{ route('admin.users.index') }}" method="GET" class="relative w-full md:w-96">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email..."
                           class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all">
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">User Profile</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Role</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Volunteer Status</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Joined Date</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->full_name) }}&background=EBF4FF&color=7F9CF5" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">{{ $user->full_name }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $user->is_volunteer ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                                    <span class="text-xs font-bold {{ $user->is_volunteer ? 'text-emerald-700' : 'text-slate-400' }}">
                                        {{ $user->is_volunteer ? 'Verified' : 'Standard' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-xs text-slate-400">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex gap-2" x-data="{ openOptions: false }">
                                    <!-- Toggle Role Action -->
                                    <form action="{{ route('admin.users.toggle-role', $user) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="p-2 bg-slate-50 text-slate-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all" title="Toggle Admin Role">
                                            <span class="material-symbols-outlined text-lg">admin_panel_settings</span>
                                        </button>
                                    </form>

                                    <!-- Verify Volunteer Action -->
                                    <form action="{{ route('admin.users.verify-volunteer', $user) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="p-2 bg-slate-50 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Toggle Volunteer Status">
                                            <span class="material-symbols-outlined text-lg">verified</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </main>
    </div>
</x-app-layout>
