<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Desain Interior Rumah',
                'description' => 'Solusi desain interior rumah yang nyaman, elegan, dan sesuai kebutuhan penghuni.',
                'image' => null,
                'status' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Desain Interior Kantor',
                'description' => 'Perancangan interior kantor modern yang nyaman dan mendukung produktivitas.',
                'image' => null,
                'status' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Desain Interior Komersial',
                'description' => 'Solusi interior untuk toko, restoran, cafe, dan berbagai ruang komersial lainnya.',
                'image' => null,
                'status' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['slug' => Str::slug($service['title'])],
                $service
            );
        }
    }
}
