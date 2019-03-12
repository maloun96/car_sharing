@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.parking.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Parking
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.auth.user.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Fast charging</th>
                            <th>Capacity</th>
                            <th>Price</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($parkings as $parking)
                            <tr>
                                <td>{{ $parking->name }}</td>
                                <td>
                                    @if($parking->status)
                                        <span class="badge badge-pill badge-success">Open</span>
                                    @else
                                        <span class="badge badge-pill badge-danger">Closed</span>
                                    @endif
                                </td>
                                <td>
                                    @if($parking->fast_charging)
                                        <span class="badge badge-pill badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-pill badge-danger">No</span>
                                    @endif
                                </td>
                                <td>{{ $parking->capacity }}</td>
                                <td>{{ $parking->price }}</td>
                                <td>{{ $parking->latitude }}</td>
                                <td>{{ $parking->longitude }}</td>

                                <td>
                                    <a href="{{ route('admin.parking.delete-permanently', $parking) }} " name="confirm_item" class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" ></i></a>
                                    <a href="{{ route('admin.parking.edit', $parking) }}" data-toggle="tooltip" data-placement="top" title="" class="btn btn-primary"><i class="fas fa-edit"></i></a>
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
                    {!! $parkings->total() !!}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $parkings->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
<example-component></example-component>
<div id="map" class="map"></div>
@endsection

@push('after-scripts')
    <script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>
    <script type="text/javascript">
			var map = new ol.Map({
				target: 'map',
				layers: [
					new ol.layer.Tile({
						source: new ol.source.OSM()
					})
				],
				view: new ol.View({
					center: ol.proj.fromLonLat([37.41, 8.82]),
					zoom: 4
				})
			});
    </script>
@endpush
