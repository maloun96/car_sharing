@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Edit Parking
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('parkings.update', $parking->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
          <label for="parking_name">Parking Name:</label>
          <input type="text" class="form-control" name="parking_name" value={{ $parking->parking_name }} />
        </div>
        <div class="form-group">
            <label for="parking_status">Parking Status:</label>
            <input type="text" class="form-control" name="parking_status" value={{ $parking->parking_status }}/>
        </div>
        <div class="form-group">
            <label for="parking_type">Parking Type:</label>
            <input type="text" class="form-control" name="parking_type" value={{ $parking->parking_type }}/>
        </div>
        <div class="form-group">
            <label for="parking_capacity">Parking Capacity:</label>
            <input type="text" class="form-control" name="parking_capacity" value={{ $parking->parking_capacity }}/>
        </div>
        <div class="form-group">
            <label for="parking_price">Parking Price:</label>
            <input type="text" class="form-control" name="parking_price" value={{ $parking->parking_price }} />
        </div>
        <div class="form-group">
            <label for="parking_latitude">Parking Latitude:</label>
            <input type="text" class="form-control" name="parking_latitude" value={{ $parking->parking_latitude }}/>
        </div>
        <div class="form-group">
            <label for="parking_longitude">Parking Longitude:</label>
            <input type="text" class="form-control" name="parking_longitude" value={{ $parking->parking_longitude }}/>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
@endsection
