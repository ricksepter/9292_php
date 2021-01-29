@extends('layouts.layout')

@section('content')

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <h3 class="navbar-brand">9292 PHP</h3>
    </nav>
    <div>
        <form action="{{ url('/') }}" method="get">
            <div class="input-group rounded p-4">


            <input type="search" class="form-control rounded" name="station" placeholder="Voer hier het gewenste station in..." value="{{ $_GET['station'] ?? '' }}">
            <button class="btn btn-outline-primary" type="submit">
                Zoeken
            </button>
            </div>
        </form>

        <table class="table table-hover">
            <tr>
                <th>Naam station</th>
                <th>Land</th>
                <th></th>
            </tr>
            @foreach($allStations as $currentStation)
                <tr>
                    <td>{{ $currentStation['namen']['lang'] }}</td>
                    <td>{{ $currentStation['land'] }}</td>
                    <td><a href="{{ url('/'. $currentStation['UICCode']) }}">Details</a></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
