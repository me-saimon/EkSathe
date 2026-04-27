<x-app-layout>
    <!-- Hero Section -->
    <header class="relative pt-32 pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
            <div class="z-10">

                <h1 class="font-manrope text-5xl font-extrabold text-on-surface mb-6 leading-tight">
                    Empower Change, One Story at a Time
                </h1>
                <p class="text-lg text-secondary mb-10 max-w-lg">
                    Access high-impact crowdfunding projects backed by rigorous verification. Join a global community of donors driving sustainable growth.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('campaigns.index') }}" class="px-8 py-4 bg-primary-container text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                        Explore Campaigns <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>
            <div class="relative">
                <img class="w-full h-[500px] object-cover rounded-3xl shadow-2xl relative z-10" src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1000&q=80" />
            </div>
        </div>
    </header>

    <!-- Statistics Section -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="glass-card p-8 rounded-xl text-center">
                    <span class="text-4xl font-bold text-primary mb-2 block">BDT 0</span>
                    <span class="text-sm font-medium text-secondary uppercase tracking-widest">Total Funds Raised</span>
                </div>
                <div class="glass-card p-8 rounded-xl text-center">
                    <span class="text-4xl font-bold text-primary mb-2 block">0</span>
                    <span class="text-sm font-medium text-secondary uppercase tracking-widest">Verified Projects</span>
                </div>
                <div class="glass-card p-8 rounded-xl text-center">
                    <span class="text-4xl font-bold text-primary mb-2 block">0</span>
                    <span class="text-sm font-medium text-secondary uppercase tracking-widest">Global Backers</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust/Transparency Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center mb-16">
            <h2 class="text-3xl font-bold mb-4">Transparency Built Into Every Transaction</h2>
            <p class="text-secondary max-w-2xl mx-auto">EkSathe bridges the gap between compassion and reliability with tools designed for total accountability.</p>
        </div>
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12">
            <div class="flex flex-col items-center text-center group">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                    <span class="material-symbols-outlined text-primary group-hover:text-white text-3xl">videocam</span>
                </div>
                <h4 class="text-xl font-bold mb-2">Live Video Updates</h4>
                <p class="text-secondary">Real-time visual confirmation of project milestones being met on the ground.</p>
            </div>
            <div class="flex flex-col items-center text-center group">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                    <span class="material-symbols-outlined text-primary group-hover:text-white text-3xl">badge</span>
                </div>
                <h4 class="text-xl font-bold mb-2">Verified Creators</h4>
                <p class="text-secondary">Multi-step identity and history verification for every campaign manager.</p>
            </div>
            <div class="flex flex-col items-center text-center group">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                    <span class="material-symbols-outlined text-primary group-hover:text-white text-3xl">radar</span>
                </div>
                <h4 class="text-xl font-bold mb-2">Impact Tracking</h4>
                <p class="text-secondary">Transparent data feeds that map every dollar directly to its final outcome.</p>
            </div>
        </div>
    </section>
</x-app-layout>
