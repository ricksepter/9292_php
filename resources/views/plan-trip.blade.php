@extends('layouts.layout')

@section('content')
    <a href="{{ url('/' . $trips[0]['legs'][0]['origin']['uicCode']) }}">
        <h3>Terug naar details van station {{ $trips[0]['legs'][0]['origin']['name'] }}</h3>
    </a>
    <h1>Gevonden ritten</h1>
    @foreach ($trips as $trip)

        <div id="trips-card">
            <h2>{{ $trip['legs'][0]['origin']['name'] }} ⟶ {{ $trip['legs'][count($trip['legs']) - 1]['destination']['name'] }}</h2>
            @foreach($trip['legs'] as $leg)
                <div id="leg-card">
                    <h3>{{ $leg['origin']['name'] }} ⟶ {{ $leg['destination']['name'] }}</h3>
                    <p>
                        Vertrekt van spoor:
                        @if (isset($leg['origin']['actualTrack']))
                            {{ $leg['origin']['actualTrack'] }}
                        @elseif (isset($leg['origin']['plannedTrack']))
                            {{ $leg['origin']['plannedTrack'] }}
                        @else
                            onbekend
                        @endif
                    </p>

                    <p>
                        Arriveert op spoor:
                        @if (isset($leg['destination']['actualTrack']))
                            {{ $leg['destination']['actualTrack'] }}
                        @elseif (isset($leg['destination']['plannedTrack']))
                            {{ $leg['destination']['plannedTrack'] }}
                        @else
                            onbekend
                        @endif
                    </p>

                    <p>
                        Vertrektijd:
                        @if (isset($leg['origin']['actualDateTime']))
                            {{ date('H:i', strtotime($leg['origin']['actualDateTime'])) }}
                        @elseif (isset($leg['origin']['plannedDateTime']))
                            {{ date('H:i', strtotime($leg['origin']['plannedDateTime'])) }}
                        @else
                            onbekend
                        @endif
                    </p>

                    <p>
                        Aankomsttijd:
                        @if (isset($leg['destination']['actualDateTime']))
                            {{ date('H:i', strtotime($leg['destination']['actualDateTime'])) }}
                        @elseif (isset($leg['destination']['plannedDateTime']))
                            {{ date('H:i', strtotime($leg['destination']['plannedDateTime'])) }}
                        @else
                            onbekend
                        @endif
                    </p>
                </div>
            @endforeach

            <p>
                Tijdsduur rit:
                @if (isset($trip['actualDurationInMinutes']))
                    {{ date('H:i', mktime(0,$trip['actualDurationInMinutes'])) }}
                @elseif (isset($trip['plannedDurationInMinutes']))
                    {{ date('H:i', mktime(0,$trip['plannedDurationInMinutes'])) }}
                @else
                    onbekend
                @endif
            </p>

            <p>
                Prijs enkele reis 1e klas:
                @if (isset($trip['fares'][0]['priceInCents']))
                    €{{number_format($trip['fares'][0]['priceInCents']/100, 2, ',', ' ')}}
                @else
                    onbekend
                @endif
            </p>

            <p>
                Prijs enkele reis 2e klas:
                @if (isset($trip['fares'][1]['priceInCents']))
                    €{{number_format($trip['fares'][1]['priceInCents']/100, 2, ',', ' ')}}
                @else
                    onbekend
                @endif
            </p>


        </div>
    @endforeach
@endsection
