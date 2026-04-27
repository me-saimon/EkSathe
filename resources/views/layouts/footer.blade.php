<footer class="w-full border-t border-slate-200 bg-white font-manrope">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="flex flex-col lg:flex-row justify-between items-start gap-12 mb-16">
            <!-- Brand Section -->
            <div class="flex flex-col items-start max-w-sm">
                <span class="text-2xl font-extrabold tracking-tighter text-emerald-600 mb-4">EkSathe</span>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Access high-impact crowdfunding projects backed by rigorous verification. Join a global community of investors and volunteers driving sustainable growth.
                </p>
                <div class="flex gap-4 mt-6">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-emerald-600 cursor-pointer transition-colors border border-slate-100">
                        <span class="material-symbols-outlined text-lg">public</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-emerald-600 cursor-pointer transition-colors border border-slate-100">
                        <span class="material-symbols-outlined text-lg">verified</span>
                    </div>
                </div>
            </div>

            <!-- Links Sections -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-12 lg:gap-24">
                <div class="flex flex-col gap-4">
                    <span class="font-bold text-xs uppercase tracking-widest text-slate-400">Platform</span>
                    <a href="{{ route('campaigns.index') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Explore Projects</a>
                    <a href="{{ route('campaigns.create') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Start Campaign</a>
                    <a href="#" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Volunteer Hub</a>
                </div>
                <div class="flex flex-col gap-4">
                    <span class="font-bold text-xs uppercase tracking-widest text-slate-400">Community</span>
                    <a href="{{ route('help.request.create') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Request Help</a>
                    <a href="#" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Trust & Safety</a>
                    <a href="#" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Impact Reports</a>
                </div>
                <div class="flex flex-col gap-4">
                    <span class="font-bold text-xs uppercase tracking-widest text-slate-400">Account</span>
                    <a href="{{ route('profile.edit') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">My Profile</a>
                    <a href="{{ route('campaigns.mine') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Manage Campaigns</a>
                    <a href="#" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Support Center</a>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-xs font-bold text-slate-400">© {{ date('Y') }} EkSathe Humanitarian Platform. Secure Institutional Crowdfunding.</p>
            <div class="flex gap-8">
                <a href="#" class="text-xs font-bold text-slate-400 hover:text-emerald-600 transition-colors">Privacy Policy</a>
                <a href="#" class="text-xs font-bold text-slate-400 hover:text-emerald-600 transition-colors">Terms of Service</a>
                <a href="#" class="text-xs font-bold text-slate-400 hover:text-emerald-600 transition-colors">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>
