@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Mechanics list</div>

                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($mechanics as $mechanic)
                                <li class="list-group-item">
                                    <div class="row-item">
                                        <div class="row-item__basic">
                                            <span>{{ $mechanic->name }} {{ $mechanic->surname }}</span>
                                            @if ($mechanic->getTrucks->count())
                                                <small>Works on {{ $mechanic->getTrucks->count() }} trucks.</small>
                                            @else
                                                <small>Currently has no trucks.</small>
                                            @endif
                                        </div>
                                        <div class="row-item__btns">
                                            <a href="{{ route('mechanic.edit', $mechanic) }}" class="btn btn-info">Edit</a>
                                            <form method="POST" action="{{ route('mechanic.destroy', $mechanic) }}">
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
    Mechanics list
@endsection
