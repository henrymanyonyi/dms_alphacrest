<?php

namespace Database\Seeders;

use App\Models\DataParameter;
use App\Models\DataSector;
use App\Models\DataSegment;
use App\Models\Sector;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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

        // $sectors = [
        //     'Security' => [
        //         'Crime statistics (violent & non-violent)',
        //         'Police force distribution & resources',
        //         'Emergency response data',
        //         'Community policing programs',
        //         'Cybersecurity incidents',
        //         'No. of law enforcement/police stations by county',
        //     ],
        //     'Economic Statistics (Macroeconomic Analysis)' => [
        //         'GDP by sector (agriculture, industry, services)',
        //         'Regional GDP contributions',
        //         'Inflation (consumer price indices)',
        //         'Employment & labor force participation',
        //         'Investment trends (FDI, local investment)',
        //     ],
        //     'Education (TVET, High Schools, Universities, Primary Schools)' => [
        //         'Enrollment rates by education level',
        //         'Graduation rates & dropout rates',
        //         'Facilities & infrastructure data',
        //         'TVET program distribution & outcomes',
        //     ],
        //     'Transport Sector (Road, Rail, Air & Water)' => [
        //         'Road network & conditions',
        //         'Railway coverage & usage',
        //         'Air traffic statistics (passenger & cargo)',
        //         'Water transport routes & safety records',
        //         'Public vs private transport utilization',
        //     ],
        //     'CDF Projects' => [
        //         'Project distribution by sector (health, education, etc.)',
        //         'Budget allocations & expenditures',
        //         'Project completion status',
        //         'Transparency & accountability metrics',
        //     ],
        //     'Agriculture & Livestock' => [
        //         'Crop production volumes & types',
        //         'Livestock population & health data',
        //         'Agricultural subsidies & support',
        //         'Market access & distribution chains',
        //     ],
        //     'Water Sector' => [
        //         'Water source mapping & access levels',
        //         'Water quality & treatment infrastructure',
        //         'Urban vs rural water supply',
        //         'Sanitation services data',
        //         'Water conservation initiatives',
        //     ],
        //     'Tourism & Hospitality Sector' => [
        //         'Tourist arrivals & origin countries',
        //         'Hotel & accommodation statistics',
        //         'Revenue generated from tourism (time series data)',
        //         'Protected areas & national parks data',
        //         'Employment in tourism sector',
        //     ],
        //     'Sports & Entertainment' => [
        //         'Participation in sports by age/gender',
        //         'Infrastructure (stadiums, facilities)',
        //         'Revenue from entertainment & sports events',
        //         'Talent development programs',
        //     ],
        // ];

        // foreach ($sectors as $sectorName => $segments) {
        //     $sector = Sector::create([
        //         'name' => $sectorName,
        //         'description' => $sectorName . ' sector data',
        //         'created_by' =>  $user->id,
        //         'deleted_by' =>  $user->id,
        //     ]);
        //     foreach ($segments as $segment) {
        //         DataSegment::create([
        //             'sector_id' => $sector->id,
        //             'name' => $segment,
        //             'description' => $segment,
        //             'created_by' =>  $user->id,
        //             'deleted_by' =>  $user->id,
        //         ]);
        //     }
        // }

        $dataSectors = [
            'Security' => [
                'Crime Data',
                'Police Infrustructure',
                'Response Efficiency',
                'Community policing',
                'Border & Immigration',
                'Disaster response',
            ],
            'Economic Statistics' => [
                'GDP by sector',
                'Employement',
                'Inflation & cost of living',
                'Trade Data',
                'Financial Inclusion',
            ],
            'Education' => [
                'Enrollment',
                'Education Infrustructure',
                'Performance',
                'TVET Data',
                'Universities',
            ],
            'Transport Sector (Road, Rail, Air & Water)' => [
                'Road network',
                'Road conditions',
                'Road safety',
                'Rail network',
                'Rail performace',
                'Rail safety',
                'Port Data',
                'Port safety',
            ],
            'CDF Projects' => [
                'Project portfolio',
                'Budget performance',
                'Completion Rate',
                'Impact',
            ],
            'Agriculture & Livestock' => [
                'Crop Data',
                'Livestock Data',
                'Market Prices',
                'Inputs',
                'Animal Health'
            ],
            'Water Sector' => [
                'Access',
                'Quality',
                'Water Infrustructure',
                'Non Revenue Water',
            ],
            'Tourism & Hospitality' => [
                'Arrivals',
                'Accommodation',
                'Revenue',
                'Conservation',
            ],
            'Sports & Entertainment' => [
                'Sports Facilities',
                'Participation',
                'Funding',
                'Creative Industry',
                'Events Data'
            ],
            'Political Economy' => [
                'Political Parties',
                'Membership',
                'Elected Representatives',
                'Manifestos',
                'Party Financing',
                'Legislative Perfomance',
                'Public Engagement'
            ],
        ];

        foreach ($dataSectors as $sectorName => $segments) {

            $sector = DataSector::create([
                'name' => $sectorName,
                'slug' => Str::slug($sectorName),
                'description' => null,
                'created_by' => $user->id,
            ]);

            foreach ($segments as $segment) {
                DataParameter::create([
                    'name' => $segment,
                    'slug' => Str::slug($segment),
                    'description' => null,
                    'data_sector_id' => $sector->id,
                    'created_by' => $user->id,
                ]);
            }
        }
    }
}
