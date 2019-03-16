<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Appointment\ManageAppointmentRequest;
use App\Http\Requests\Backend\Appointment\StoreAppointmentRequest;
use App\Http\Requests\Backend\Appointment\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Parking;
use App\Repositories\Backend\AppointmentRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\ParkingRepository;
use Auth;
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
     * @param StoreAppointmentRequest $request
     *
     * @return mixed
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $data = [
            'car_number' => $request->get('car_number'),
            'parking_id' => $request->get('parking_id'),
            'data' => $request->get('data'),
            'time' => $request->get('time'),
            'user_id' => Auth::id()
        ];

        // Validation
        $appointments = $this->appointmentRepository
            ->where('data', $request->get('data'), '=')
            ->where('time', $request->get('time'), '=')
            ->where('parking_id', $request->get('parking_id'), '=')
            ->count();

        if ($appointments > 0) {
            return redirect()->route('admin.appointment.create')
                ->withFlashDanger('There is another reservation in this date.');
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
     * @param StoreAppointmentRequest $request
     * @param Parking $parking
     * @return mixed
     * @throws \Throwable
     */
    public function update(Request $request, Appointment $appointment)
    {
        $data = [
            'car_number' => $request->get('car_number'),
            'parking_id' => $request->get('parking_id'),
            'data' => $request->get('data'),
            'time' => $request->get('time'),
            'user_id' => Auth::id()
        ];

        // Validation
        $appointments = $this->appointmentRepository
            ->where('data', $request->get('data'), '=')
            ->where('time', $request->get('time'), '=')
            ->where('id', $appointment->id, '!=')
            ->where('parking_id', $request->get('time'), '=')
            ->count();

        if ($appointments > 0) {
            return redirect()->route('admin.appointment.create')
                ->withFlashDanger('There is another reservation in this date.');
        }

        $this->appointmentRepository->update($appointments, $data);

        return redirect()->route('admin.appointment.index')->withFlashSuccess('Appointment was successfully updated.');
    }

    /**
     * @param ManageAppointmentRequest $request
     * @param Parking $parking
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Request $request, Appointment $appointment)
    {
        $this->appointmentRepository->deleteById($appointment->id);

        return redirect()->route('admin.appointment.index')->withFlashSuccess('Appointment was successfully deleted.');
    }
}
