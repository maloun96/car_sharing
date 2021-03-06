@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.create'))

@section('breadcrumb-links')
    @include('backend.appointment.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->form('POST', route('admin.appointment.store'))->class('form-horizontal')->open() }}
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

                        <br />
                        <div id="mapid" style="height: 400px;"></div>
                        <br />

                        <div class="form-group row">
                            {{ html()->label('Parking')->class('col-md-2 form-control-label')->for('parking_id') }}

                            <div class="col-md-10">
                               <select id="parking-select" readonly="true" class='form-control' name="parking_id">
                                   @foreach($parkings as $parking)
                                        <option value="{{ $parking->id }}">{{$parking->name}} {{$parking->fast_charging ? '(Fast charging)' : ''}} </option>
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
                                <select class='form-control' name="recurrence">
                                   <option value="">None</option>
                                   <option value="weekly">Weekly</option>
                                   <option value="monthly">Monthly</option>
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

        var parkings = JSON.parse('{!!$parkings!!}');

        var map = L.map('mapid',{
            zoom: 12,
            minZoom: 12,
            center: L.latLng(46.77, 23.62)
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        parkings.map((park) => {
            L.marker([park.latitude, park.longitude]).addTo(map).on('click', (e) => {
                const f = parkings.find((p) => p.latitude == e.latlng.lat && p.longitude == e.latlng.lng);

                if(f) {
                    $('#parking-select').val(f.id);
                }
            })
            .bindPopup(park.name)
            .openPopup();
        })

    </script>
@endpush

