<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Donation Campaign') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Campaign Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required />
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category" :value="__('Category (e.g. Winter, Food, Flood)')" />
                            <x-text-input id="category" class="block mt-1 w-full" type="text" name="category" required />
                        </div>

                        <!-- Banner Image -->
                        <div>
                            <x-input-label for="banner_image" :value="__('Banner Image')" />
                            <input type="file" name="banner_image" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <!-- Goal Amount -->
                        <div>
                            <x-input-label for="goal_amount" :value="__('Goal Amount (Optional)')" />
                            <x-text-input id="goal_amount" class="block mt-1 w-full" type="number" name="goal_amount" />
                        </div>

                        <!-- Campaign Date -->
                        <div>
                            <x-input-label for="campaign_date" :value="__('Campaign Event Date')" />
                            <x-text-input id="campaign_date" class="block mt-1 w-full" type="datetime-local" name="campaign_date" required />
                        </div>

                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Distribution Address')" />
                            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" required />
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                    </div>

                    <!-- Extra Links -->
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="live_video_url" :value="__('Live Video URL (YouTube/FB)')" />
                            <x-text-input id="live_video_url" class="block mt-1 w-full" type="url" name="live_video_url" placeholder="https://..." />
                        </div>
                        <div>
                            <x-input-label for="location_map" :value="__('Google Maps Link')" />
                            <x-text-input id="location_map" class="block mt-1 w-full" type="url" name="location_map" placeholder="https://goo.gl/maps/..." />
                        </div>
                    </div>

                    <!-- Volunteer Toggle -->
                    <div class="mt-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_volunteer_need" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                            <span class="ml-2 text-sm text-gray-600">{{ __('I need volunteers for this campaign') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Create Campaign') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
