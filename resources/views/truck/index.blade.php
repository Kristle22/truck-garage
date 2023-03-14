@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Trucks list</h3>
                        <form action="{{ route('truck.index') }}" method="get">
                            <fieldset>
                                <legend>Sort</legend>
                                <div class="block">
                                    <button type="submit" class="btn btn-info" name="sort" value="maker">Maker</button>
                                    <button type="submit" class="btn btn-info" name="sort" value="plate">Plate</button>
                                    <button type="submit" class="btn btn-info" name="sort" value="make_year">Make
                                        Year</button>
                                </div>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sort_dir" id="_1"
                                            value="asc" @if ('desc' != $sortDirection) checked @endif><label
                                            class="form-check-label" for="_1">
                                            ASC
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sort_dir" id="_2"
                                            value="desc" @if ('desc' == $sortDirection) checked @endif><label
                                            class="form-check-label" for="_2">
                                            DESC
                                        </label>
                                    </div>
                                </div>
                                <div class="block">
                                    <a href="{{ route('truck.index') }}" class="btn btn-warning">Reset</a>
                                </div>
                            </fieldset>
                        </form>
                        <form action="{{ route('truck.index') }}" method="get">
                            <fieldset>
                                <legend>Filter</legend>
                                <div class="form-group">
                                    <select class="form-control" name="mechanic_id">
                                        <option value="0" disabled selected>Select Mechanic</option>
                                        @foreach ($mechanics as $mechanic)
                                            <option value="{{ $mechanic->id }}"
                                                @if ($mechanicId == $mechanic->id) selected @endif>{{ $mechanic->name }}
                                                {{ $mechanic->surname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Select the mechanic from the list.</small>
                                </div>
                                <div class="block">
                                    <button type="submit" class="btn btn-info" name="filter"
                                        value="mechanic">Filter</button>
                                    <a href="{{ route('truck.index') }}" class="btn btn-warning">Reset</a>
                                </div>
                            </fieldset>
                        </form>
                        <form action="{{ route('truck.index') }}" method="get">
                            <fieldset>
                                <legend>Search</legend>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="s" value="{{ $s }}"
                                        placeholder="Search">
                                    <small class="form-text text-muted">Search in our LorryVell.</small>
                                </div>
                                <div class="block">
                                    <button type="submit" class="btn btn-info" name="search"
                                        value="all">Search</button>
                                    <a href="{{ route('truck.index') }}" class="btn btn-warning">Reset</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="m-3">
                            {{ $trucks->links() }}
                        </div>
                        <ul class="list-group">
                            @foreach ($trucks as $truck)
                                <li class="list-group-item">
                                    <div class="row-item">
                                        <div class="row-item__basic">
                                            <span>
                                                <h4>{{ $truck->maker }}</h4> Plate: <b>{{ $truck->plate }}</b>
                                                Make
                                                year:
                                                <b>{{ $truck->make_year }}</b>
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
                                            <a href="{{ route('truck.show', $truck) }}" class="btn btn-warning">Show</a>
                                            <form method="POST" action="{{ route('truck.destroy', $truck) }}">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="m-3">
                            {{ $trucks->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    Trucks list
@endsection
