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
			'latitude' => 46.77231989968773,
			'longitude' => 23.59519958496094
		]);

		Parking::create([
			'name' => 'Parking nr.2',
			'status' => 0,
			'fast_charging' => 1,
			'capacity' => 10,
			'price' => 20,
			'latitude' => 46.75259379688626,
			'longitude' => 23.52709293365479
		]);

		Parking::create([
			'name' => 'Parking nr.3',
			'status' => 1,
			'fast_charging' => 0,
			'capacity' => 15,
			'price' => 40,
			'latitude' => 46.76467725943422,
			'longitude' => 23.607816696166992
		]);


		$this->enableForeignKeys();
	}
}
