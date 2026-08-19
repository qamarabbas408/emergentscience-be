<?php

namespace Database\Seeders;

use App\Models\Journal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Journal::firstOrCreate(
            ['slug' => 'emergentsci'],
            [
                'title' => 'Emerging Science',
                'abbreviation' => 'Emerg. Sci.',
                'doi_prefix' => '10.3390',
                'discipline' => 'Open Science',
                'license' => 'CC-BY 4.0',
                'scope' => 'A platform for open, reproducible science across disciplines.',
                'is_active' => true,
                'apc_amount' => 1500.00,
                'apc_currency' => 'USD',
            ],
        );

        if (app()->environment('local')) {
            Journal::factory()->count(2)->create();
        }
    }
}
