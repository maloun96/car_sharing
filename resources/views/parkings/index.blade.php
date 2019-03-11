@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Parking Name</td>
          <td>Parking Status</td>
          <td>Parking Type</td>
          <td>Parking Capacity</td>
          <td>Parking Price</td>
          <td>Parking Latitude</td>
          <td>Parking Longitude</td>
          <td colspan="2">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($parkings as $parking)
        <tr>
            <td>{{$parking->id}}</td>
            <td>{{$parking->parking_name}}</td>
            <td>{{$parking->parking_status}}</td>
            <td>{{$parking->parking_type}}</td>
            <td>{{$parking->parking_capacity}}</td>
            <td>{{$parking->parking_price}}</td>
            <td>{{$parking->parking_latitude}}</td>
            <td>{{$parking->parking_longitude}}</td>
            <td><a href="{{ route('parkings.edit',$parking->id)}}" class="btn btn-primary">Edit</a></td>
            <td>
                <form action="{{ route('parkings.destroy', $parking->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
@endsection
