@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.appointment.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Appointment
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.appointment.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Parking</th>
                            <th>Car number</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Recurrence</th>
                            <th>User</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->parking->name }}</td>
                                <td>{{ $appointment->car_number }}</td>
                                <td>{{ $appointment->data }}</td>
                                <td>{{ $appointment->time }}</td>
                                <td>{{ $appointment->recurrence }}</td>
                                <td>{{ $appointment->user->full_name }}</td>

                                <td>
                                    <a href="{{ route('admin.appointment.delete-permanently', $appointment) }} " name="confirm_item" class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" ></i></a>
                                    <a href="{{ route('admin.appointment.edit', $appointment) }}" data-toggle="tooltip" data-placement="top" title="" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $appointments->total() !!}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $appointments->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
