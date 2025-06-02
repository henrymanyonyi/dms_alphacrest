<?php

namespace Database\Seeders;

use App\Models\DataSegment;
use App\Models\Sector;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run()
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123456789'
        ]);

        $sectors = [
            'Security' => [
                'Crime statistics (violent and non-violent)',
                'Police force distribution and resources',
                'Emergency response data',
                'Community policing programs',
                'Cybersecurity incidents',
                'No. of law enforcement/police stations by county',
            ],
            'Economic Statistics (Macroeconomic Analysis)' => [
                'GDP by sector (agriculture, industry, services)',
                'Regional GDP contributions',
                'Inflation (consumer price indices)',
                'Employment and labor force participation',
                'Investment trends (FDI, local investment)',
            ],
            'Education (TVET, High Schools, Universities, Primary Schools)' => [
                'Enrollment rates by education level',
                'Graduation rates and dropout rates',
                'Facilities and infrastructure data',
                'TVET program distribution and outcomes',
            ],
            'Transport Sector (Road, Rail, Air & Water)' => [
                'Road network and conditions',
                'Railway coverage and usage',
                'Air traffic statistics (passenger and cargo)',
                'Water transport routes and safety records',
                'Public vs private transport utilization',
            ],
            'CDF Projects' => [
                'Project distribution by sector (health, education, etc.)',
                'Budget allocations and expenditures',
                'Project completion status',
                'Transparency and accountability metrics',
            ],
            'Agriculture and Livestock' => [
                'Crop production volumes and types',
                'Livestock population and health data',
                'Agricultural subsidies and support',
                'Market access and distribution chains',
            ],
            'Water Sector' => [
                'Water source mapping and access levels',
                'Water quality and treatment infrastructure',
                'Urban vs rural water supply',
                'Sanitation services data',
                'Water conservation initiatives',
            ],
            'Tourism and Hospitality Sector' => [
                'Tourist arrivals and origin countries',
                'Hotel and accommodation statistics',
                'Revenue generated from tourism (time series data)',
                'Protected areas and national parks data',
                'Employment in tourism sector',
            ],
            'Sports and Entertainment' => [
                'Participation in sports by age/gender',
                'Infrastructure (stadiums, facilities)',
                'Revenue from entertainment and sports events',
                'Talent development programs',
            ],
        ];

        foreach ($sectors as $sectorName => $segments) {
            $sector = Sector::create([
                'name' => $sectorName,
                'description' => $sectorName . ' sector data',
                'created_by' =>  $user->id,
                'deleted_by' =>  $user->id,
            ]);
            foreach ($segments as $segment) {
                DataSegment::create([
                    'sector_id' => $sector->id,
                    'name' => $segment,
                    'description' => $segment,
                    'created_by' =>  $user->id,
                    'deleted_by' =>  $user->id,
                ]);
            }
        }
    }
}
