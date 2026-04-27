<x-app-layout>
    <main class="pt-32 pb-24 px-8 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto">

            <!-- Header Section -->
            <div class="text-center mb-12">
                <span class="inline-flex items-center gap-2 px-3 py-1 bg-amber-100 text-amber-700 font-bold text-[10px] rounded-full mb-4">
                    <span class="material-symbols-outlined text-[16px]">support_agent</span>
                    HUMANITARIAN SUPPORT
                </span>
                <h1 class="font-manrope text-4xl font-extrabold text-slate-900 mb-4">Request Assistance</h1>
                <p class="text-slate-500 max-w-lg mx-auto">Are you or someone you know in need of food, clothing, or financial help? Fill out this form and our admin team will review it.</p>
            </div>

            <!-- Form Card -->
            <div class="glass-card rounded-[2rem] p-12 shadow-xl border border-white">
                <form action="{{ route('help.request.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Subject -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Subject / Need Category</label>
                        <div class="relative">
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400">label</span>
                            <input name="subject" type="text" value="{{ old('subject') }}" placeholder="e.g. Urgent Food Support for 5 Families"
                                   class="w-full bg-transparent border-none border-b-2 border-slate-200 focus:border-emerald-600 focus:ring-0 transition-all font-bold text-slate-900 py-3 pl-8 rounded-none" required>
                        </div>
                        @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Location -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Location of Need</label>
                            <div class="relative">
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400">location_on</span>
                                <input name="location" type="text" value="{{ old('location') }}" placeholder="Area, City"
                                       class="w-full bg-transparent border-none border-b-2 border-slate-200 focus:border-emerald-600 focus:ring-0 transition-all font-bold text-slate-900 py-3 pl-8 rounded-none" required>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Contact Phone/Email</label>
                            <div class="relative">
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400">call</span>
                                <input name="contact_info" type="text" value="{{ old('contact_info', Auth::user()->phone) }}" placeholder="How can we reach you?"
                                       class="w-full bg-transparent border-none border-b-2 border-slate-200 focus:border-emerald-600 focus:ring-0 transition-all font-bold text-slate-900 py-3 pl-8 rounded-none" required>
                            </div>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Describe the Situation</label>
                        <textarea name="message" rows="6" placeholder="Please provide details about who needs help and what specifically is required..."
                                  class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-6 focus:border-emerald-600 focus:ring-0 transition-all text-slate-700" required>{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                  <script src="https://cdn.tailwindcss.com"></script>

<div class="pt-6">
    <button type="submit"
        class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold text-lg shadow-xl hover:bg-emerald-800 transition-all active:scale-95 flex items-center justify-center gap-3">

        <span class="material-symbols-outlined">send</span>
        Submit Request to Admin
    </button>

    <p class="text-center text-xs text-slate-400 mt-4 italic">
        Note: All requests are kept confidential and reviewed within 24-48 hours.
    </p>
</div>
                </form>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
                <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-100 flex gap-4">
                    <span class="material-symbols-outlined text-emerald-600">verified</span>
                    <div>
                        <h4 class="font-bold text-emerald-900">Direct Review</h4>
                        <p class="text-xs text-emerald-700">Your request goes directly to our core admin team to prevent data misuse.</p>
                    </div>
                </div>
                <div class="bg-amber-50 p-6 rounded-2xl border border-amber-100 flex gap-4">
                    <span class="material-symbols-outlined text-amber-600">emergency</span>
                    <div>
                        <h4 class="font-bold text-amber-900">Urgent Response</h4>
                        <p class="text-xs text-amber-700">For life-threatening emergencies, please contact local emergency services.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
