<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;

/**
 * SocialLinkSeeder
 *
 * Dedicated seeder for populating social links data.
 * Creates sample social media profiles and external links.
 *
 * Note: This seeder assumes GeneralInfo records already exist.
 * Use in conjunction with GeneralInfoSeeder or after manual GeneralInfo creation.
 *
 * Run: php artisan db:seed --class=SocialLinkSeeder
 */
class SocialLinkSeeder extends Seeder
{
    /**
     * Populate the social_links table with sample data.
     */
    public function run(): void
    {
        // Create 5 social links
        // Note: general_info_id should be set when calling this seeder
        SocialLink::factory(5)->create();
    }
}
