<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\RequestException;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;

use App\Models\Car;
use App\Models\SiteInfo;
use App\Models\PlannedService;
use GuzzleHttp\Client;

class ServiceController extends Controller
{
    /**
     * Simply redirects you to the form to apply a car for service
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function createForm()
    {
        return view('service.form');
    }

    /**
     * Stores the data from a service form in the DB
     *
     * Gets additional info from the RDW API, returns an error if something is not right
     *
     * @param ServiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(ServiceRequest $request)
    {
        $licencePlateStripped = str_replace('-', '', $request->input('licence_plate'));
        $licencePlate = $request->input('licence_plate');
        $maxCarsPerDay = SiteInfo::first()->max_cars_per_day;
        $client = new Client();

        try {

            $response = $client->get("https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=$licencePlateStripped");
            $rdwData = json_decode($response->getBody(), true);

            if (!empty($rdwData)) {
                $year = substr($rdwData[0]['datum_eerste_toelating'], 0, 4) ?? 'N/A';

                $carDetails = [
                    'user_id' => auth()->id(),
                    'licence_plate' => $licencePlate,
                    'brand' => $rdwData[0]['merk'] ?? 'N/A',
                    'model' => $rdwData[0]['handelsbenaming'] ?? 'N/A',
                    'color' => $rdwData[0]['eerste_kleur'] ?? 'N/A',
                    'year' => $year,
                    'body' => $rdwData[0]['inrichting'] ?? 'N/A',
                    'power' => $rdwData[0]['vermogen_motor_pk'] ?? "N/A",
                    'doors' => $rdwData[0]['aantal_deuren'] ?? 'N/A',
                    'seats' => $rdwData[0]['aantal_zitplaatsen'] ?? 'N/A',
                    'apk_end_date' => $rdwData[0]['vervaldatum_apk_dt'] ?? '2025-04-11 00:00:00',
                    'cc' => $rdwData[0]['cilinderinhoud'] ?? "N/A",
                    'weight' => $rdwData[0]['massa_ledig_voertuig'] ?? 'N/A',
                    'tax' => $rdwData[0]['bruto_bpm'] ?? "N/A",
                ];
                $carDetails['odometer'] = $request->input('odometer');


                $response = $client->get("https://opendata.rdw.nl/resource/8ys7-d773.json?kenteken=$licencePlateStripped");
                $fuelData = json_decode($response->getBody(), true);

                if (!empty($fuelData)) {
                    $carDetails['fuel_efficiency'] = $fuelData[0]['brandstofverbruik_gecombineerd'] ?? "N/A";
                    $carDetails['fuel_type'] = $fuelData[0]['brandstof_omschrijving'] ?? 'N/A';
                }


                $serviceDate = $request->input('service_date');

                if (strtotime($serviceDate) < strtotime(date('Y-m-d'))) {
                    return back()->with(['error' => 'Je kunt geen afspraak in het verleden maken.'])->withInput();
                }
                $plannedAppointmentsCount = PlannedService::whereDate('service_date', $serviceDate)->count();

                if ($plannedAppointmentsCount >= $maxCarsPerDay) {
                    return back()->with(['error' => 'Maximaal aantal auto\'s per dag bereikt voor deze datum.'])->withInput();
                }

                $car = new Car();
                $car->fill($carDetails);
                $car->save();

                $plannedService = new PlannedService();
                $plannedService->car_id = $car->id;
                $plannedService->service_date = $serviceDate;
                $plannedService->save();

                return redirect()->route('home')->with('success', 'Je hebt een afspraak gemaakt voor de auto.');
            } else {
                return back()->with(['error' => 'Auto gegevens niet gevonden'])->withInput();
            }
        } catch (RequestException $e) {
            return back()->with(['error' => 'Kan auto gegevens niet ophalen van de RDW API.'])->withInput();
        }
    }

    /**
     * Returns the view of the cars table overview
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $cars = Car::with('plannedService')->orderBy('created_at', 'desc');

        if ($query) {
            $cars->where('licence_plate', 'like', "%$query%");
        }

        $cars = $cars->paginate(10)->withQueryString();

        return view("service.index", compact('cars', 'query'));
    }

    /**
     * Returns the view of the car complete page
     *
     * @param Car $car
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */

    public function markAsComplete(Car $car)
    {
        return view('service.complete', compact('car'));
    }

    /**
     * Completes a cars planned service with a description
     *
     * @param Request $request
     * @param Car $car
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finish(Request $request, Car $car)
    {
        $messages = [
            'description.required' => 'Beschrijving is verplicht.',
            'description.string' => 'Beschrijving moet een tekst zijn.',
        ];

        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $plannedService = $car->plannedService()->latest()->first();
        $plannedService->completed = true;
        $plannedService->description = $request->description;
        $plannedService->save();

        return redirect()->route('dashboard.service.index')->with('success', 'Servicebeurt succesvol afgerond.');
    }

    /**
     * Removes car from the DB including tasks and logs
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Car $car)
    {
        $car->plannedService()->delete();
        $car->delete();
        return redirect(route("dashboard.service.index"))->with('success', 'Auto verwijderd');
    }
}
