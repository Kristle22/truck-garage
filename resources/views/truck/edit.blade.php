@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Truck edit</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('truck.update', $truck) }}" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Maker</label>
                                <input type="text" class="form-control" name="truck_maker"
                                    value="{{ old('truck_maker', $truck->maker) }}">
                                <small class="form-text text-muted">Enter truck Maker.</small>
                            </div>
                            <div class="form-group">
                                <label>Plate</label>
                                <input type="text" class="form-control" name="truck_plate"
                                    value="{{ old('truck_plate', $truck->plate) }}">
                                <small class="form-text text-muted">Enter truck Plate.</small>
                            </div>
                            <div class="form-group">
                                <label>Make Year</label>
                                <input type="text" class="form-control" name="truck_make_year"
                                    value="{{ old('truck_make_year', $truck->make_year) }}">
                                <small class="form-text text-muted">Enter truck Make Year.</small>
                            </div>
                            <div class="form-group">
                                <label>Mechanic notices</label>
                                <textarea class="form-control" name="truck_mechanic_notices">{{ old('truck_mechanic_notices', $truck->mechanic_notices) }}</textarea>
                                <small class="form-text text-muted">Mechanic notices about truck.</small>
                            </div>
                            <div class="form-group">
                                <label>Photo</label>
                                <div class="img mb-2">
                                    @if ($truck->photo)
                                        <img src="{{ $truck->photo }}" alt="{{ $truck->maker }}">
                                    @else
                                        <img src="{{ asset('img/no-img.png') }}" alt="{{ $truck->maker }}">
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" class="form-check-input me-1" name="truck_photo_deleted"
                                        id="df">
                                    <label for="df">Delete photo</label>
                                </div>
                                <input type="file" class="form-control" name="truck_photo">
                                <small class="form-text text-muted">Truck image.</small>
                            </div>
                            <div class="form-group">
                                <label>Mechanic</label>
                                <select class="form-control" name="mechanic_id">
                                    @foreach ($mechanics as $mechanic)
                                        <option value="{{ $mechanic->id }}"
                                            @if (old('mechanic_id', $truck->mechanic_id) == $mechanic->id) selected @endif>
                                            {{ $mechanic->name }}
                                            {{ $mechanic->surname }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Select the mechanic from the list.</small>
                            </div>
                            @csrf
                            <button type="submit" class="btn btn-primary">Update truck info</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    Truck edit
@endsection
