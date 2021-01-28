@extends('layouts.layout')

@section('content')

<a href="{{ url('/') }}">
    <h3>Terug naar overzicht</h3>
</a>

<h2>Station {{$currentStation['namen']['lang']}}</h2>


<h3>Plan uw rit</h3>
<form method="get">
    <div id="destinationSearch">
        <input type="search" name="destination" placeholder="Gewenste bestemming..." value="{{ $_GET['destination'] ?? '' }}">

        <button type="submit">
            Zoeken
        </button>
    </div>

    <div id="destinationResult">
        @if (isset($destinations) && count($destinations) > 0)
            @foreach ($destinations as $destination)
                <button type="submit" formaction="{{ url('/'.$currentStation['UICCode'].'/'.$destination['UICCode']) }}">
                    <p>{{ $destination['namen']['lang'] }}</p>
                </button>
            @endforeach
        @endif
    </div>

</form>


<div id="stationDetails">
    <div id="arrivalTable">
        <h3>Details aankomende treinen</h3>
        <table>
            <tr>
                <th>Afkomstig van</th>
                <th>Geplande aankomsttijd</th>
                <th>Spoor</th>
            </tr>
            @foreach($arrivals as $arrival)
                <tr>
                    <td>{{ $arrival['origin'] }}</td>
                    <td>{{ date('H:i:s', strtotime($arrival['plannedDateTime'])) }}</td>
                    <td>
                        @if (isset($arrival['actualTrack']))
                            {{ $arrival['actualTrack'] }}
                        @elseif (isset($arrival['plannedTrack']))
                            {{ $arrival['plannedTrack'] }}
                        @else
                            Onbekend
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div id="departureTable">
        <h3>Details vertrekkende treinen</h3>
        <table id="stationTable">
            <tr>
                <th>Bestemming</th>
                <th>Geplande vertrektijd</th>
                <th>Spoor</th>
            </tr>
            @foreach($departures as $departure)
                <tr>
                    <td>{{ $departure['direction'] }}</td>
                    <td>{{ date('H:i:s', strtotime($departure['plannedDateTime'])) }}</td>
                    <td>
                        @if (isset($departure['actualTrack']))
                            {{ $departure['actualTrack'] }}
                        @elseif (isset($departure['plannedTrack']))
                            {{ $departure['plannedTrack'] }}
                        @else
                            Onbekend
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
