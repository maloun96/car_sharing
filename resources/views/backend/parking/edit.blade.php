@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.create'))

@section('breadcrumb-links')
    @include('backend.parking.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->modelForm($parking, 'PATCH', route('admin.parking.update', $parking->id))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Parking management
                        <small class="text-muted">Edit parking</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('Name')->class('col-md-2 form-control-label')->for('name') }}

                        <div class="col-md-10">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder('Name')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Opened')->class('col-md-2 form-control-label')->for('status') }}

                        <div class="col-md-10">
                            <label class="switch switch-label switch-lg switch-pill switch-primary">
                                {{ html()->checkbox('status', true, '1')->class('switch-input') }}
                                <span class="switch-slider" data-checked="Yes" data-unchecked="No"></span>
                            </label>
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Fast charging')->class('col-md-2 form-control-label')->for('fast_charging') }}

                        <div class="col-md-10">
                            <label class="switch switch-label switch-lg switch-pill switch-primary">
                                {{ html()->checkbox('fast_charging', true, '1')->class('switch-input') }}
                                <span class="switch-slider" data-checked="Yes" data-unchecked="No"></span>
                            </label>
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Capacity')->class('col-md-2 form-control-label')->for('capacity') }}

                        <div class="col-md-10">
                            {{ html()->text('capacity')
                                ->class('form-control')
                                ->placeholder('Capacity')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Price')->class('col-md-2 form-control-label')->for('price') }}

                        <div class="col-md-10">
                            {{ html()->text('price')
                                ->class('form-control')
                                ->placeholder('Price')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <br />
                    <div id="mapid" style="height: 400px;"></div>
                    <br />
                    <div class="form-group row">
                        {{ html()->label('Latitude')->class('col-md-2 form-control-label')->for('latitude') }}

                        <div class="col-md-10">
                            {{ html()->text('latitude')
                                ->class('form-control')
                                ->placeholder('Latitude')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Longitude')->class('col-md-2 form-control-label')->for('longitude') }}

                        <div class="col-md-10">
                            {{ html()->text('longitude')
                                ->class('form-control')
                                ->placeholder('Longitude')
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer clearfix">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.parking.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')
    <script>
        var map = L.map('mapid',{
            zoom: 12,
            minZoom: 12,
            center: L.latLng(46.77, 23.62)
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var parking = JSON.parse('{!!$parking!!}');

        var marker = L.marker([parking.latitude, parking.longitude]).addTo(map)
            .bindPopup(parking.name)
            .openPopup();;

        map.on('click', (e) => {
            const {lat, lng} = e.latlng;

            if(marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng]).addTo(map)
                .bindPopup($('#name').val())
                .openPopup();

            $('#longitude').val(lng);
            $('#latitude').val(lat);
        });
    </script>
@endpush
