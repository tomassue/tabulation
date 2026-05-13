<?php

namespace Database\Seeders;

use App\Models\TechnicalCategory;
use App\Models\TechnicalSubCriteria;
use Illuminate\Database\Seeder;

/**
 * Seeds the cheerleading/cheer competition criteria exactly as specified
 * in the official "Criteria for Judging" sheet.
 *
 * Usage: php artisan db:seed --class=TechnicalCriteriaSeeder
 *
 * Pass a competition_category slug (default: 'cheer') via env or edit below.
 */
class TechnicalCriteriaSeeder extends Seeder
{
    public function run(): void
    {
        // Change this to match your competition category slug in the categories table.
        $competitionCategory = 'cheer';

        $categories = [
            [
                'name'      => 'I. Basic Elements / Motions & Dance',
                'slug'      => 'dance',
                'max_score' => 100,
                'order'     => 1,
                'criteria'  => [
                    // sub_group => null means no sub-grouping
                    [null, 'Difficulty',                    20, 1],
                    [null, 'Technique',                     20, 2],
                    [null, 'Choreography',                  20, 3],
                    [null, 'Timing, Spacing, and Execution',10, 4],
                    [null, 'Props',                         20, 5],
                    [null, 'Overall Effect',                10, 6],
                ],
            ],
            [
                'name'      => 'II. Tumbling',
                'slug'      => 'tumbling',
                'max_score' => 100,
                'order'     => 2,
                'criteria'  => [
                    ['Standing Tumbling', 'Difficulty',  10, 1],
                    ['Standing Tumbling', 'Technique',   10, 2],
                    ['Running Tumbling',  'Difficulty',  10, 3],
                    ['Running Tumbling',  'Technique',   10, 4],
                    ['Running Tumbling',  'Creativity',  10, 5],
                    ['Jumps',             'Difficulty',  15, 6],
                    ['Jumps',             'Execution',   15, 7],
                    ['Jumps',             'Spacing and Synchronization', 10, 8],
                    ['Jumps',             'Overall Effect', 10, 9],
                ],
            ],
            [
                'name'      => 'III. Stunts',
                'slug'      => 'stunts',
                'max_score' => 100,
                'order'     => 3,
                'criteria'  => [
                    [null, 'Difficulty',                  25, 1],
                    [null, 'Technique',                   20, 2],
                    [null, 'Creativity',                  25, 3],
                    [null, 'Quantity',                    10, 4],
                    [null, 'Spacing and Synchronization', 10, 5],
                    [null, 'Overall Effect',              10, 6],
                ],
            ],
            [
                'name'      => 'IV. Pyramids',
                'slug'      => 'pyramids',
                'max_score' => 100,
                'order'     => 4,
                'criteria'  => [
                    [null, 'Difficulty',                  25, 1],
                    [null, 'Technique',                   20, 2],
                    [null, 'Creativity',                  25, 3],
                    [null, 'Quantity',                    10, 4],
                    [null, 'Spacing and Synchronization', 10, 5],
                    [null, 'Overall Effect',              10, 6],
                ],
            ],
            [
                'name'      => 'V. Cheer (Single Judge)',
                'slug'      => 'cheer',
                'max_score' => 50,
                'order'     => 5,
                'criteria'  => [
                    [null, 'Audibility',    20, 1],
                    [null, 'Content',       10, 2],
                    [null, 'Props',         10, 3],
                    [null, 'Overall Effect',10, 4],
                ],
            ],
        ];

        foreach ($categories as $catData) {
            $tc = TechnicalCategory::firstOrCreate(
                [
                    'competition_category' => $competitionCategory,
                    'slug'                 => $catData['slug'],
                ],
                [
                    'name'          => $catData['name'],
                    'max_score'     => $catData['max_score'],
                    'display_order' => $catData['order'],
                ]
            );

            foreach ($catData['criteria'] as [$subGroup, $name, $maxScore, $order]) {
                TechnicalSubCriteria::firstOrCreate(
                    [
                        'technical_category_id' => $tc->id,
                        'sub_group'             => $subGroup,
                        'name'                  => $name,
                    ],
                    [
                        'max_score'     => $maxScore,
                        'display_order' => $order,
                    ]
                );
            }
        }

        $this->command->info("Seeded cheerleading criteria for competition category: {$competitionCategory}");
        $this->command->info('Total max score: 450 pts (4 × 100 + 50)');
    }
}
