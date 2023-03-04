@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Trucks list</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($trucks as $truck)
                                <li class="list-group-item">
                                    <div class="row-item">
                                        <div class="row-item__basic">
                                            <span><b>Maker:</b> {{ $truck->maker }} <b>Plate:</b> {{ $truck->plate }}
                                                <b>Make
                                                    year:</b>
                                                {{ $truck->make_year }}
                                            </span>
                                            <small>
                                                <b>Mechanic:</b> {{ $truck->getMechanic->name }}
                                                {{ $truck->getMechanic->surname }}
                                            </small>
                                            <div>
                                                <b>Mechanic notices: </b>
                                                {!! $truck->mechanic_notices !!}
                                            </div>
                                        </div>
                                        <div class="row-item__btns">
                                            <a href="{{ route('truck.edit', $truck) }}" class="btn btn-info">Edit</a>
                                            <form method="POST" action="{{ route('truck.destroy', $truck) }}">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    Trucks list
@endsection
