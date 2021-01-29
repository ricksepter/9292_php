@extends('layouts.layout')

@section('content')

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <h3 class="navbar-brand">9292 PHP</h3>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">
                    Terug naar overzicht
                </a>
            </li>
        </ul>
    </nav>


    <h2 class="p-5 text-center">Station {{$currentStation['namen']['lang']}}</h2>

    <h3>Plan uw rit</h3>
    <form method="get">
        <div class="input-group rounded p-4">
            <input type="search" class="form-control rounded" name="destination" placeholder="Voer uw gewenste bestemming in..." value="{{ $_GET['destination'] ?? '' }}">

            <button type="submit" class="btn btn-outline-primary">Zoeken</button>

        </div>
        @if (isset($destinations) && count($destinations) > 0)
            @foreach ($destinations as $destination)
                <div class="card m-2" style="width: 18rem;">
                    <a class="card-body" type="submit" href="{{ url('/'.$currentStation['UICCode'].'/'.$destination['UICCode']) }}">
                        <p>{{ $destination['namen']['lang'] }}</p>
                    </a>
                </div>
            @endforeach
        @endif
    </form>

    <div>
        <h3>Details aankomende treinen</h3>
        <table class="table table-striped">
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

        <h3>Details vertrekkende treinen</h3>
        <table class="table table-striped">
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
@endsection
