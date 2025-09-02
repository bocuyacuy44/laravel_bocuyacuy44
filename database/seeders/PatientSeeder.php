<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
	public function run(): void
	{
		$items = [
			['name' => 'Andi Setiawan', 'address' => 'Jl. Kenanga No. 5', 'phone' => '0812-1111-2222', 'hospital' => 'RS Harapan Bunda'],
			['name' => 'Budi Santoso', 'address' => 'Jl. Melati No. 7', 'phone' => '0813-3333-4444', 'hospital' => 'RS Sehat Sentosa'],
			['name' => 'Citra Lestari', 'address' => 'Jl. Flamboyan No. 9', 'phone' => '0812-5555-6666', 'hospital' => 'RS Kasih Ibu'],
		];

		foreach ($items as $data) {
			$hospitalId = Hospital::query()->where('name', $data['hospital'])->value('id');
			if (!$hospitalId) {
				$first = Hospital::query()->first();
				if (!$first) {
					$first = Hospital::query()->create([
						'name' => 'Rumah Sakit Umum',
						'address' => 'Alamat RS Umum',
						'email' => null,
						'phone' => null,
					]);
				}
				$hospitalId = $first->id;
			}
			Patient::query()->updateOrCreate(
				['name' => $data['name']],
				[
					'name' => $data['name'],
					'address' => $data['address'],
					'phone' => $data['phone'],
					'hospital_id' => $hospitalId,
				]
			);
		}
	}
}
