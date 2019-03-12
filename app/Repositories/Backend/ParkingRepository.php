<?php

namespace App\Repositories\Backend;

use App\Models\Auth\User;
use App\Models\Parking;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use App\Events\Backend\Auth\User\UserCreated;
use App\Events\Backend\Auth\User\UserUpdated;
use App\Events\Backend\Auth\User\UserRestored;
use App\Events\Backend\Auth\User\UserConfirmed;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Events\Backend\Auth\User\UserDeactivated;
use App\Events\Backend\Auth\User\UserReactivated;
use App\Events\Backend\Auth\User\UserUnconfirmed;
use App\Events\Backend\Auth\User\UserPasswordChanged;
use App\Notifications\Backend\Auth\UserAccountActive;
use App\Events\Backend\Auth\User\UserPermanentlyDeleted;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;

/**
 * Class ParkingRepository.
 */
class ParkingRepository extends BaseRepository
{
	/**
	 * @return string
	 */
	public function model()
	{
		return Parking::class;
	}

	/**
	 * @param int    $paged
	 * @param string $orderBy
	 * @param string $sort
	 *
	 * @return mixed
	 */
	public function getPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
	{
		return $this->model
			->orderBy($orderBy, $sort)
			->paginate($paged);
	}

	/**
	 * @param array $data
	 *
	 * @return User
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function create(array $data) : Parking
	{
		return DB::transaction(function () use ($data) {
			$parking = parent::create([
				'name' => $data['name'],
				'status' => $data['status'],
				'capacity' => $data['capacity'],
				'price' => $data['price'],
				'latitude' => $data['latitude'],
				'longitude' => $data['longitude'],
			]);

			return $parking;
		});
	}

	/**
	 * @param Parking $parking
	 * @param array $data
	 *
	 * @return Parking
	 * @throws \Throwable
	 */
	public function update(Parking $parking, array $data) : Parking
	{

		return DB::transaction(function () use ($parking, $data) {
			if ($parking->update([
				'name' => $data['name'],
				'status' => isset($data['status']) ? true : false,
				'capacity' => $data['capacity'],
				'price' => $data['price'],
				'latitude' => $data['latitude'],
				'longitude' => $data['longitude'],
			])) {

				return $parking;
			}
		});
	}
}
