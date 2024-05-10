<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\RequestException;

use Illuminate\Http\Request;
use App\Models\Car;
use GuzzleHttp\Client;

class ServiceController extends Controller
{

    public function createForm()
    {
        return view('service.form');
    }

    public function store(Request $request)
    {
        //omzetten naar requestValidation
        $messages = [
            'licence_plate.required' => 'Het kenteken is verplicht.',
            'licence_plate.max' => 'Het kenteken mag niet langer zijn dan :max tekens.',
            'odometer.required' => 'De kilometerstand is verplicht.',
            'odometer.numeric' => 'De kilometerstand moet numeriek zijn.',
        ];
    
        $validatedData = $request->validate([
            'licence_plate' => 'required|string|max:50',
            'odometer' => 'required|numeric',
        ], $messages);

        $licencePlate = str_replace('-', '', $request->input('licence_plate'));  
        $client = new Client();

        try {
            $response = $client->get("https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=$licencePlate");
            $rdwData = json_decode($response->getBody(), true);

            $year = substr($rdwData[0]['datum_eerste_toelating'], 0, 4);
    
            if (!empty($rdwData)) {
                $carDetails = [
                    'user_id' => auth()->id(),
                    'licence_plate' => $licencePlate,
                    'brand' => $rdwData[0]['merk'],
                    'model' => $rdwData[0]['handelsbenaming'],
                    'color' => $rdwData[0]['eerste_kleur'],
                    'year' => $year,
                    'body' => $rdwData[0]['inrichting'],
                    'power' => $rdwData[0]['vermogen_motor_pk'] ?? "N/A",
                    'doors' => $rdwData[0]['aantal_deuren'],
                    'seats' => $rdwData[0]['aantal_zitplaatsen'],
                    'apk_end_date' => $rdwData[0]['vervaldatum_apk_dt'],
                    'cc' => $rdwData[0]['cilinderinhoud'] ?? "N/A",
                    'weight' => $rdwData[0]['massa_ledig_voertuig'],
                    'tax' => $rdwData[0]['bruto_bpm'] ?? "N/A",
                ];

                $response = $client->get("https://opendata.rdw.nl/resource/8ys7-d773.json?kenteken=$licencePlate");
                $fuelData = json_decode($response->getBody(), true);
    
                if (!empty($fuelData)) {
                    $carDetails['fuel_efficiency'] = $fuelData[0]['brandstofverbruik_gecombineerd'] ?? "N/A";
                    $carDetails['fuel_type'] = $fuelData[0]['brandstof_omschrijving'];
                } 
    
                $carDetails['odometer'] = $validatedData['odometer'];
    
                $car = new Car();
                $car->fill($carDetails);
                $car->save();

                return redirect()->route('dashboard')->with('success', 'Je hebt een afspraak gemaakt voor de auto.');
            } else {
                return back()->withErrors(['error' => 'Auto gegevens niet gevonden'])->withInput();
            }
        } catch (RequestException $e) {
            return back()->withErrors(['error' => 'Kan auto gegevens niet ophalen van de RDW API.'])->withInput();
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
            $cars->where('license_plate', 'like', "%$query%");
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