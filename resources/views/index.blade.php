@extends('layouts.layout')

@section('content')
    <div>
        <form action="{{ url('/') }}" method="get">
            <input type="search" name="station" placeholder="Zoeken" value="{{ $_GET['station'] ?? '' }}">
            <button type="submit">
                Zoeken
            </button>
        </form>

        <table id="stationTable">
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
