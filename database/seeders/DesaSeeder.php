<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DesaSeeder extends Seeder
{
    public function run(): void
    {
        $kecamatan = Kecamatan::first();

        $desaList = [
            [
                'nama' => 'Hainan',
                'sambutan' => 'Selamat datang di Desa Hainan. Kami siap melayani warga dengan sepenuh hati.',
                'sejarah' => 'Desa Hainan berdiri sejak tahun 1950-an dan dikenal sebagai desa agraris yang subur.',
                'letak_geografis' => 'Terletak di sebelah utara Kecamatan Borea, berbatasan dengan sungai dan area perkebunan.',
                'telepon' => '0812-1111-1111',
                'alamat_balai' => 'Jl. Raya Hainan No. 1, Kecamatan Borea',
                'jam_layanan' => 'Senin - Jumat, 08.00 - 15.00 WIB',
            ],
            [
                'nama' => 'Joreu',
                'sambutan' => 'Salam hangat dari Desa Joreu, desa yang kaya akan budaya dan kerajinan.',
                'sejarah' => 'Desa Joreu memiliki tradisi tenun yang diwariskan turun-temurun.',
                'letak_geografis' => 'Terletak di tengah Kecamatan Borea, dikelilingi perbukitan hijau.',
                'telepon' => '0812-2222-2222',
                'alamat_balai' => 'Jl. Raya Joreu No. 2, Kecamatan Borea',
                'jam_layanan' => 'Senin - Jumat, 08.00 - 15.00 WIB',
            ],
            [
                'nama' => 'Kartula',
                'sambutan' => 'Selamat datang di Desa Kartula, desa kreatif dengan kerajinan payung tradisional.',
                'sejarah' => 'Desa Kartula dikenal sejak lama sebagai sentra kerajinan payung tradisional.',
                'letak_geografis' => 'Terletak di selatan Kecamatan Borea, dekat dengan kawasan wisata alam.',
                'telepon' => '0812-3333-3333',
                'alamat_balai' => 'Jl. Raya Kartula No. 3, Kecamatan Borea',
                'jam_layanan' => 'Senin - Jumat, 08.00 - 15.00 WIB',
            ],
        ];

        foreach ($desaList as $data) {
            Desa::create(array_merge($data, [
                'kecamatan_id' => $kecamatan->id,
                'slug' => Str::slug($data['nama']),
            ]));
        }
    }
}