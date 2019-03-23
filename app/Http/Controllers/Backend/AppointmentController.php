<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Appointment\ManageAppointmentRequest;
use App\Http\Requests\Backend\Appointment\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Repositories\Backend\AppointmentRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\ParkingRepository;
use Auth;
use DateTime;
use Illuminate\Http\Request;

/**
 * Class AppointmentController.
 */
class AppointmentController extends Controller
{
    /**
     * @var AppointmentRepository
     */
    protected $appointmentRepository;

    /**
     * @var ParkingRepository
     */
    protected $parkingRepository;

    /**
     * UserController constructor.
     *
     * @param AppointmentRepository $appointmentRepository
     * @param ParkingRepository $parkingRepository
     */
    public function __construct(AppointmentRepository $appointmentRepository, ParkingRepository $parkingRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
        $this->parkingRepository = $parkingRepository;
    }

    /**
     * @param ManageAppointmentRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageAppointmentRequest $request)
    {
        return view('backend.appointment.index')
            ->withAppointments($this->appointmentRepository->getPaginated(25, 'id', 'asc'));
    }

    /**
     * @param ManageAppointmentRequest    $request
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     *
     * @return mixed
     */
    public function create(ManageAppointmentRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $data = $this->parkingRepository->all();
        return view('backend.appointment.create', ['parkings' => $data]);
    }

    /**
     * @param StoreAppointmentRequest|Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $data = [
            'car_number' => $request->get('car_number'),
            'parking_id' => $request->get('parking_id'),
            'data' => $request->get('data'),
            'time' => $request->get('time'),
            'recurrence' => $request->get('recurrence'),
            'user_id' => Auth::id()
        ];

        $appointments = $this->appointmentRepository->where('parking_id', $data['parking_id'], '=')->with('parking')->get();

        foreach($appointments as $appointment) {

            if($this->checkRecurrence($appointment, $data)) {
                return redirect()->route('admin.appointment.create')
                    ->withFlashDanger('There is another reservation in this date.');
            }
        }

        $this->appointmentRepository->create($data);

        return redirect()->route('admin.appointment.index')->withFlashSuccess('Appointment was successfully created.');
    }


    /**
     * @param ManageAppointmentRequest $request
     * @param RoleRepository $roleRepository
     * @param PermissionRepository $permissionRepository
     * @param Appointment $appointment
     * @return mixed
     * @internal param Parking $parking
     *
     */
    public function edit(ManageAppointmentRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository, Appointment $appointment)
    {
        $data = $this->parkingRepository->all();
        return view('backend.appointment.edit')->withAppointment($appointment)->withParkings($data);
    }

    /**
     * @param StoreAppointmentRequest|Request $request
     * @param Appointment $appointment
     * @return mixed
     * @internal param Parking $parking
     */
    public function update(Request $request, Appointment $appointment)
    {
        $data = [
            'car_number' => $request->get('car_number'),
            'parking_id' => $request->get('parking_id'),
            'recurrence' => $request->get('recurrence'),
            'data' => $request->get('data'),
            'time' => $request->get('time'),
            'user_id' => Auth::id()
        ];

        $appointments = $this->appointmentRepository
            ->where('id', $appointment->id, '!=')
            ->where('parking_id', $data['parking_id'], '=')
            ->with('parking')
            ->get();

        foreach($appointments as $a) {
            if($this->checkRecurrence($a, $data)) {
                return redirect()->route('admin.appointment.create')
                    ->withFlashDanger('There is another reservation in this date.');
            }
        }

        $this->appointmentRepository->update($appointment, $data);

        return redirect()->route('admin.appointment.index')->withFlashSuccess('Appointment was successfully updated.');
    }

    /**
     * @param ManageAppointmentRequest|Request $request
     * @param Appointment $appointment
     * @return mixed
     * @internal param Parking $parking
     */
    public function destroy(Request $request, Appointment $appointment)
    {
        $this->appointmentRepository->deleteById($appointment->id);

        return redirect()->route('admin.appointment.index')->withFlashSuccess('Appointment was successfully deleted.');
    }


    private function checkRecurrence($appointment, $data)
    {
        $hours = $appointment->parking->fast_charging ? 2 : 1;

        $appointmentTimeStart = strtotime($appointment->time);
        $appointmentTimeEnd = strtotime($appointment->time . ' + ' . $hours.' hours');
        $dataTimeStart = strtotime($data['time']);
        $dataTimeEnd = strtotime($data['time'] . ' + ' . $hours.' hours');



        if($appointment->recurrence !== '') {

            $date1 = new DateTime($appointment->data);
            $date2 = new DateTime($data['data']);
            $interval = $date1->diff($date2);

            if($appointment->recurrence == 'monthly' && $interval->d === 0 && $interval->m > 0) {
                return true;
            }

            if($appointment->recurrence == 'weekly' && $interval->d % 7 === 0) {
                return true;
            }

            // if is in range our date and overlap with another appointment time
            if($appointmentTimeStart <= $dataTimeEnd && $appointmentTimeEnd >= $dataTimeStart) {
                return true;
            }

            echo $interval->y." ".$interval->m." ".$interval->d;
        }

        if($appointmentTimeStart <= $dataTimeEnd && $appointmentTimeEnd >= $dataTimeStart && $appointment->data === $data['data']) {
            return true;
        }
        return false;
    }
}
