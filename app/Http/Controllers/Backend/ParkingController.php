<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\User\StoreUserRequest;
use App\Http\Requests\Backend\Parking\ManageParkingRequest;
use App\Http\Requests\Backend\Parking\StoreParkingRequest;
use App\Http\Requests\Backend\Parking\UpdateParkingRequest;
use App\Models\Parking;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\ParkingRepository;

/**
 * Class ParkingController.
 */
class ParkingController extends Controller
{
	/**
	 * @var ParkingRepository
	 */
	protected $parkingRepository;

	/**
	 * UserController constructor.
	 *
	 * @param ParkingRepository $parkingRepository
	 */
	public function __construct(ParkingRepository $parkingRepository)
	{
		$this->parkingRepository = $parkingRepository;
	}

	/**
	 * @param ManageParkingRequest $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(ManageParkingRequest $request)
	{
		return view('backend.parking.index')
			->withParkings($this->parkingRepository->getPaginated(25, 'id', 'asc'));
	}

	/**
	 * @param ManageParkingRequest    $request
	 * @param RoleRepository       $roleRepository
	 * @param PermissionRepository $permissionRepository
	 *
	 * @return mixed
	 */
	public function create(ManageParkingRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository)
	{
		return view('backend.parking.create');
	}

	/**
	 * @param StoreParkingRequest $request
	 *
	 * @return mixed
	 * @throws \Throwable
	 */
	public function store(StoreParkingRequest $request)
	{
		$this->parkingRepository->create($request->only(
			'name',
			'status',
			'capacity',
			'price',
			'latitude',
			'longitude'
		));

		return redirect()->route('admin.parking.index')->withFlashSuccess('Parking was successfully created.');
	}


	/**
	 * @param ManageParkingRequest    $request
	 * @param RoleRepository       $roleRepository
	 * @param PermissionRepository $permissionRepository
	 * @param Parking                 $parking
	 *
	 * @return mixed
	 */
	public function edit(ManageParkingRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository, Parking $parking)
	{
		return view('backend.parking.edit')->withParking($parking);
	}

	/**
	 * @param StoreParkingRequest $request
	 * @param Parking $parking
	 * @return mixed
	 * @throws \Throwable
	 */
	public function update(UpdateParkingRequest $request, Parking $parking)
	{
		$this->parkingRepository->update($parking, $request->only(
			'name',
			'status',
			'capacity',
			'price',
			'latitude',
			'longitude'
		));

		return redirect()->route('admin.parking.index')->withFlashSuccess('Parking was successfully updated.');
	}

	/**
	 * @param ManageParkingRequest $request
	 * @param Parking $parking
	 * @return mixed
	 * @throws \Exception
	 */
	public function destroy(ManageParkingRequest $request, Parking $parking)
	{
		$this->parkingRepository->deleteById($parking->id);

		return redirect()->route('admin.parking.index')->withFlashSuccess('Parking was successfully deleted.');
	}
}
