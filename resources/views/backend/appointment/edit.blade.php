@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.create'))

@section('breadcrumb-links')
    @include('backend.appointment.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->modelForm($appointment, 'PATCH', route('admin.appointment.update', $appointment->id))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Appointment management
                        <small class="text-muted">Creata appointment</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('Car number')->class('col-md-2 form-control-label')->for('car_number') }}

                        <div class="col-md-10">
                            {{ html()->text('car_number')
                                ->class('form-control')
                                ->placeholder('Car number')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Parking')->class('col-md-2 form-control-label')->for('parking_id') }}

                        <div class="col-md-10">
                            <select class='form-control' name="parking_id">
                                @foreach($parkings as $parking)
                                    <option {{$parking->id === $appointment->parking->id ? 'selected="true"' : ''}} value="{{ $parking->id }}">{{$parking->name}} {{$parking->fast_charging ? '(Fast charging)' : ''}} </option>
                                @endforeach
                            </select>
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Date')->class('col-md-2 form-control-label')->for('data') }}

                        <div class="col-md-10">
                            {{ html()->text('data')
                                ->class('form-control')
                                ->id('date')
                                ->placeholder('Date')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Time')->class('col-md-2 form-control-label')->for('time') }}

                        <div class="col-md-10">
                            {{ html()->text('time')
                                ->class('form-control')
                                ->id('time')
                                ->placeholder('Time')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Frequency')->class('col-md-2 form-control-label')->for('frequency') }}

                        <div class="col-md-10">
                            <select class='form-control' name="recurrence" >
                                <option {{$appointment->recurrence === '' ? 'selected="true"' : ''}} value="">None</option>
                                <option {{$appointment->recurrence === 'weekly' ? 'selected="true"' : ''}} value="weekly">Weekly</option>
                                <option {{$appointment->recurrence === 'monthly' ? 'selected="true"' : ''}} value="monthly">Monthly</option>
                            </select>
                        </div><!--col-->
                    </div><!--form-group-->

                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer clearfix">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.appointment.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.create')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->form()->close() }}
@endsection


@push('after-scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr("#date", {});
        flatpickr("#time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });
    </script>
@endpush

