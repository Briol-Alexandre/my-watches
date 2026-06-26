<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $response = Http::get('https://api.thewatchapi.com/v1/brand/list', [
            'api_token' => env('WATCH_API_TOKEN'),
        ]);

        $brands = $response->json('data');

        $rows = collect($brands)->map(fn ($name) => [
            'name' => $name,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        DB::table('brands')->insert($rows);
    }
}
