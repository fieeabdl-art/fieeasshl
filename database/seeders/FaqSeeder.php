<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Berapa lama proses pengerjaan interior?',
                'answer' => 'Waktu pengerjaan tergantung dari jenis proyek dan tingkat kompleksitas desain. Biasanya berkisar antara 4-12 minggu setelah desain dan RAB disetujui.',
            ],
            [
                'question' => 'Apakah bisa custom desain sesuai keinginan?',
                'answer' => 'Tentu bisa. Tim desainer kami akan berdiskusi langsung dengan Anda untuk menyesuaikan gaya, fungsi, dan budget sesuai kebutuhan.',
            ],
            [
                'question' => 'Apakah tersedia layanan survei lokasi?',
                'answer' => 'Ya, kami menyediakan layanan survei lokasi untuk memastikan pengukuran dan kondisi lapangan sesuai dengan rencana desain.',
            ],
            [
                'question' => 'Bagaimana dengan garansi produk dan jasa?',
                'answer' => 'Setiap pekerjaan yang kami selesaikan dilengkapi dengan garansi sesuai ketentuan yang berlaku, mencakup material dan pengerjaan.',
            ],
            [
                'question' => 'Apakah Bumiyuji Living melayani seluruh Indonesia?',
                'answer' => 'Saat ini kami berfokus melayani wilayah Sukabumi dan sekitarnya, namun proyek di luar area tersebut dapat didiskusikan lebih lanjut.',
            ],
        ];

        foreach ($faqs as $index => $faq) {
            Faq::query()->updateOrCreate(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'sort_order' => $index,
                    'is_published' => true,
                ]
            );
        }
    }
}
