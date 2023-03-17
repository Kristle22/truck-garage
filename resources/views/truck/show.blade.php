@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <b>{{ $truck->maker }}</b> <small>Mechanic: {{ $truck->getMechanic->name }}
                            {{ $truck->getMechanic->surname }}</small>
                    </div>
                    <div class="card-body">
                        <div class="item-container">
                            <div class="item-container__img">
                                @if ($truck->photo)
                                    <img src="{{ $truck->photo }}" alt="{{ $truck->maker }}">
                                @else
                                    <img src="{{ asset('img/no-img.png') }}" alt="{{ $truck->maker }}">
                                @endif
                            </div>
                            <div class="item-container__basic">
                                <p>Plate: <b>{{ $truck->plate }}</b></p>
                                <p>Make Year: <b>{{ $truck->make_year }}</b></p>
                            </div>
                        </div>
                        <div class="item-container__about">
                            {!! $truck->mechanic_notices !!}
                        </div>
                        <a href="{{ route('truck.edit', $truck) }}" class="btn btn-info mt-2">Edit</a>
                        <a href="{{ route('truck.pdf', $truck) }}" class="btn btn-info mt-2">PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    {{ $truck->maker }}
@endsection
