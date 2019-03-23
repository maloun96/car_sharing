<?php

namespace App\Repositories\Backend;

use App\Models\Appointment;
use App\Repositories\BaseRepository;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class AppointmentRepository.
 */
class AppointmentRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Appointment::class;
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
            ->with('parking', 'user')
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param array $data
     *
     * @return Appointment
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data) : Appointment
    {
        return DB::transaction(function () use ($data) {
            $parking = parent::create([
                'car_number' => $data['car_number'],
                'data' => $data['data'],
                'recurrence' => $data['recurrence'],
                'time' => $data['time'],
                'parking_id' => $data['parking_id'],
                'user_id' => $data['user_id'],
            ]);

            return $parking;
        });
    }

    /**
     * @param Appointment $appointment
     * @param array $data
     * @return Appointment
     * @internal param Parking $parking
     */
    public function update(Appointment $appointment, array $data) : Appointment
    {
        return DB::transaction(function () use ($appointment, $data) {
            if ($appointment->update([
                'car_number' => $data['car_number'],
                'data' => $data['data'],
                'recurrence' => $data['recurrence'],
                'time' => $data['time'],
                'parking_id' => $data['parking_id'],
                'user_id' => $data['user_id'],
            ])) {

                return $appointment;
            }
        });
    }
}
