<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
	public function run(): void
	{
		$items = [
			['name' => 'RS Harapan Bunda', 'address' => 'Jl. Merdeka No. 1', 'email' => 'hbn@example.com', 'phone' => '021-123456'],
			['name' => 'RS Sehat Sentosa', 'address' => 'Jl. Kesehatan No. 2', 'email' => 'sss@example.com', 'phone' => '021-789012'],
			['name' => 'RS Kasih Ibu', 'address' => 'Jl. Mawar No. 3', 'email' => 'rki@example.com', 'phone' => '021-345678'],
		];

		foreach ($items as $data) {
			Hospital::query()->updateOrCreate(
				['name' => $data['name']],
				$data
			);
		}
	}
}
