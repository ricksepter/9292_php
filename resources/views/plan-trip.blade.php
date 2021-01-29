@extends('layouts.layout')

@section('content')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <h3 class="navbar-brand">9292 PHP</h3>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/' . $trips[0]['legs'][0]['origin']['uicCode']) }}">
                    Details station {{ $trips[0]['legs'][0]['origin']['name'] }}
                </a>
            </li>
        </ul>
    </nav>

    <h1>Gevonden ritten</h1>
    @foreach ($trips as $trip)

        <div class="card mt-5 mb-5">
            <div class="card-header">
                <h2 class="card-title">{{ $trip['legs'][0]['origin']['name'] }} ⟶ {{ $trip['legs'][count($trip['legs']) - 1]['destination']['name'] }}</h2>
                <p class="card-text">
                    Tijdsduur rit:
                    @if (isset($trip['actualDurationInMinutes']))
                        {{ date('H:i', mktime(0,$trip['actualDurationInMinutes'])) }}
                    @elseif (isset($trip['plannedDurationInMinutes']))
                        {{ date('H:i', mktime(0,$trip['plannedDurationInMinutes'])) }}
                    @else
                        onbekend
                    @endif
                </p>

                <p class="card-text">
                    Prijs enkele reis 1e klas:
                    @if (isset($trip['fares']) && count($trip['fares']) > 0)
                        @foreach ($trip['fares'] as $fare)
                            @if ($fare['product'] === 'OVCHIPKAART_ENKELE_REIS' && $fare['travelClass'] === 'FIRST_CLASS' && $fare['discountType'] === 'NO_DISCOUNT')
                                @if (isset($trip['fares'][0]['priceInCents']))
                                    €{{number_format($fare['priceInCents']/100, 2, ',', ' ')}}
                                @else
                                    onbekend
                                @endif
                            @endif
                        @endforeach
                    @endif


                </p>

                <p class="card-text">
                    Prijs enkele reis 2e klas:
                    @if (isset($trip['fares']) && count($trip['fares']) > 0)
                        @foreach ($trip['fares'] as $fare)
                            @if ($fare['product'] === 'OVCHIPKAART_ENKELE_REIS' && $fare['travelClass'] === 'SECOND_CLASS' && $fare['discountType'] === 'NO_DISCOUNT')
                                @if (isset($trip['fares'][0]['priceInCents']))
                                    €{{number_format($fare['priceInCents']/100, 2, ',', ' ')}}
                                @else
                                    onbekend
                                @endif
                            @endif
                        @endforeach
                    @endif
                </p>

            </div>

            <ul class="list-group list-group-flush">
                @foreach($trip['legs'] as $leg)
                    <li class="list-group-item">
                        <h4>{{ $leg['origin']['name'] }} ⟶ {{ $leg['destination']['name'] }}</h4>
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
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
@endsection
