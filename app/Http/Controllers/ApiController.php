<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    private $client;

    public function __construct()
    {

        // Initialize client used to send requests to the NS API
        $this->client = new Client([
            'base_uri' => 'https://gateway.apiportal.ns.nl',
            'headers' => [
                'Accept'    => 'application/json',
                'Ocp-Apim-Subscription-Key' => env('API_KEY_NS')
            ]
        ]);
    }

    public function getAllStations() {
        // Retrieve list of all stations from API
        $res = $this->client->get('reisinformatie-api/api/v2/stations');
        $allStations = json_decode($res->getBody()->getContents(), true)['payload'];

        // If the search field is used, filter so the list of station matches what is searched for
        if (isset($_GET['station']) && !empty($_GET['station'])) {
            $currentStation = $_GET['station'];

            $allStations = array_filter($allStations, function($var) use ($currentStation) {
                return (stripos($var['namen']['lang'], $currentStation) !== false);
            });
        }

        return view('index', [
            'allStations' => $allStations
        ]);
    }

    public function getStationDetails(Request $req) {
        // TODO implement datepicker for planning trip
        $currentTimeAndDate = now('Europe/Amsterdam')->format(\DateTime::RFC3339);

        // Retrieve list of all stations from API
        $res = $this->client->get('reisinformatie-api/api/v2/stations');
        $allStations = json_decode($res->getBody()->getContents(), true)['payload'];

        // Retrieve list of all arrivals on specific station from API
        $res = $this->client->get('reisinformatie-api/api/v2/arrivals?uicCode='.$req->uicCode .
            '&dateTime=' . $currentTimeAndDate .
            '&lang=nl');
        $arrivals = json_decode($res->getBody()->getContents(), true)['payload']['arrivals'];

        // Retrieve list of all departures from specific station from API
        $res = $this->client->get('reisinformatie-api/api/v2/departures?uicCode='.$req->uicCode .
            '&dateTime=' . $currentTimeAndDate .
            '&lang=nl');
        $departures = json_decode($res->getBody()->getContents(), true)['payload']['departures'];

        // Get details of current station from list of all stations
        $filteredStations = array_filter($allStations, function($var) use ($req) {
            return ($var['UICCode'] === $req->uicCode);
        });
        $index = array_keys($filteredStations)[0]; // index of filtered station(s)
        $currentStation = $filteredStations[$index];

        // If the search field for destination is set, look for possible destinations to plan a trip to
        $destinations = null;
        if (isset($_GET['destination']) && !empty($_GET['destination'])) {
            $destination = $_GET['destination'];

            $destinations = array_filter($allStations, function($var) use ($destination, $req) {
                return (stripos($var['namen']['lang'], $destination) !== false) && $var['UICCode'] !== $req->uicCode;
            });
        }

        return view('station-details', [
            'currentStation' => $currentStation,
            'arrivals' => $arrivals,
            'departures' => $departures,
            'destinations' => $destinations
        ]);
    }

    public function getTripDetails(Request $req) {
        // TODO implement datepicker for planning trip
        $currentTimeAndDate = now('Europe/Amsterdam')->format(\DateTime::RFC3339);

        // Get trip response based on the departure and arrival
        $res = $this->client->get('reisinformatie-api/api/v3/trips?originUicCode='.$req->departure.
            '&destinationUicCode='.$req->arrival.
            '&dateTime='.$currentTimeAndDate);
        $trips = json_decode($res->getBody()->getContents(), true)['trips'];

        return view('plan-trip', [
            'trips' => $trips
        ]);
    }
}
