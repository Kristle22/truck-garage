@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Truck create</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('truck.store') }}">
                            <div class="form-group">
                                <label>Maker</label>
                                <input type="text" class="form-control" name="truck_maker"
                                    value="{{ old('truck_maker') }}">
                                <small class="form-text text-muted">Enter truck Maker.</small>
                            </div>
                            <div class="form-group">
                                <label>Plate</label>
                                <input type="text" class="form-control" name="truck_plate"
                                    value="{{ old('truck_plate') }}">
                                <small class="form-text text-muted">Enter truck Plate.</small>
                            </div>
                            <div class="form-group">
                                <label>Make Year</label>
                                <input type="text" class="form-control" name="truck_make_year"
                                    value="{{ old('truck_make_year') }}">
                                <small class="form-text text-muted">Enter truck Make Year.</small>
                            </div>
                            <div class="form-group">
                                <label>Mechanic notices</label>
                                <textarea class="form-control" name="truck_mechanic_notices">{{ old('truck_mechanic_notices') }}</textarea>
                                <small class="form-text text-muted">Mechanic notices about truck.</small>
                            </div>
                            <div class="form-group">
                                <label>Mechanic</label>
                                <select class="form-control" name="mechanic_id">
                                    @foreach ($mechanics as $mechanic)
                                        <option value="{{ $mechanic->id }}"
                                            @if (old('mechanic_id') == $mechanic->id) selected @endif>
                                            {{ $mechanic->name }}
                                            {{ $mechanic->surname }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Select the mechanic from the list.</small>
                            </div>
                            @csrf
                            <button type="submit" class="btn btn-primary">Create new</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    Truck create
@endsection
