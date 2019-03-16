<?php

use App\Models\Parking;
use Illuminate\Database\Seeder;

/**
 * Class ParkingTableSeeder.
 */
class ParkingTableSeeder extends Seeder
{
	use DisableForeignKeys;

	/**
	 * Run the database seed.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->disableForeignKeys();

		Parking::create([
			'name' => 'Parking nr.1',
			'status' => 1,
			'fast_charging' => 1,
			'capacity' => 20,
			'price' => 20,
			'latitude' => 20.2,
			'longitude' => 12.2
		]);

		Parking::create([
			'name' => 'Parking nr.2',
			'status' => 0,
			'fast_charging' => 1,
			'capacity' => 10,
			'price' => 20,
			'latitude' => 21.2,
			'longitude' => 22.2
		]);

		Parking::create([
			'name' => 'Parking nr.3',
			'status' => 1,
			'fast_charging' => 0,
			'capacity' => 15,
			'price' => 40,
			'latitude' => 76.2,
			'longitude' => 99.0
		]);


		$this->enableForeignKeys();
	}
}
