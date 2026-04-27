<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaign;
use App\Models\User;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        // Get users (must exist from UserSeeder)
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Run UserSeeder first.');
            return;
        }

        $campaigns = [
            [
                'category' => 'Food',
                'title' => 'Feed the Homeless',
                'description' => 'Providing meals for homeless people in the city.',
                'goal_amount' => 50000,
                'address' => 'Dhaka City',
                'banner_image' => 'campaigns/food.jpg',
                'is_volunteer_need' => 1,
                'status' => 'active',
            ],
            [
                'category' => 'Clothes',
                'title' => 'Winter Clothes Distribution',
                'description' => 'Collecting and distributing warm clothes.',
                'goal_amount' => 30000,
                'address' => 'Rangpur',
                'banner_image' => 'campaigns/winter.jpg',
                'is_volunteer_need' => 1,
                'status' => 'active',
            ],
            [
                'category' => 'Medical',
                'title' => 'Medical Aid for Flood Victims',
                'description' => 'Helping flood-affected families with medicine.',
                'goal_amount' => 100000,
                'address' => 'Sylhet',
                'banner_image' => 'campaigns/medical.jpg',
                'is_volunteer_need' => 0,
                'status' => 'active',
            ],
        ];

        foreach ($campaigns as $data) {
            Campaign::create([
                'creator_by' => $users->random()->id,
                'category' => $data['category'],
                'title' => $data['title'],
                'description' => $data['description'],
                'campaign_date' => now()->addDays(rand(1, 10)),
                'goal_amount' => $data['goal_amount'],
                'live_video_url' => null,
                'address' => $data['address'],
                'location_map' => null,
                'rank' => rand(1, 5),
                'banner_image' => $data['banner_image'],
                'is_volunteer_need' => $data['is_volunteer_need'],
                'status' => $data['status'],
            ]);
        }
    }
}
