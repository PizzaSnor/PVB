<?php

namespace App\Http\Controllers;

use App\Models\Occasion;
use App\Models\OccasionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SiteInfo;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\RequestException;
use App\Http\Requests\OccasionStoreRequest;
use App\Models\Car;
use Carbon\Carbon;

class OccasionController extends Controller
{
    public function index(Request $request)
    {
        $occasions = Occasion::where(function ($query) {
            $query->where('sold', false)
                ->orWhere(function ($query) {
                    $query->where('sold', true)
                        ->where('show_when_sold', true);
                });
        });

        $query = $request->input('query');

        if ($query) {
            $occasions->where('model', 'like', "%$query%")
                ->orWhere('brand', 'like', "%$query%");
        }

        $occasions = $occasions->orderBy('created_at', 'desc')
            ->paginate(6)
            ->withQueryString();

        return view('occasions.index', compact('occasions', 'query'));
    }


    public function view($id)
    {
        $imageId = request()->input('imageId');
        $siteInfo = SiteInfo::firstOrCreate([]);
        $occasion = Occasion::findOrFail($id);

        return view('occasions.view', compact('occasion', 'imageId', 'siteInfo'));
    }

    public function create()
    {
        $occasions = Occasion::get();
        return view('occasions.create', compact('occasions'));
    }

    public function store(OccasionStoreRequest $request)
    {
        $licencePlateStripped = str_replace('-', '', $request->input('licence_plate'));
        $licencePlate = $request->input('licence_plate');
        $transmission = $request->input('transmission');
        $power = $request->input('power');
        $title = $request->input('title');
        $description = $request->input('description');
        $price = $request->input('price');
        $sold = 0;
        $showWhenSold = 0;
        $client = new Client();

        try {
            $response = $client->get("https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=$licencePlateStripped");
            $rdwData = json_decode($response->getBody(), true);

            if (!empty($rdwData)) {
                $year = substr($rdwData[0]['datum_eerste_toelating'], 0, 4);

                $carDetails = [
                    'licence_plate' => $licencePlate,
                    'brand' => $rdwData[0]['merk'] ?? 'N/A',
                    'model' => $rdwData[0]['handelsbenaming'] ?? 'N/A',
                    'color' => $rdwData[0]['eerste_kleur'] ?? 'N/A',
                    'year' => $year,
                    'body' => $rdwData[0]['inrichting'] ?? 'N/A',
                    'power' => $power,
                    'transmission' => $transmission,
                    'doors' => $rdwData[0]['aantal_deuren'] ?? 'N/A',
                    'seats' => $rdwData[0]['aantal_zitplaatsen'] ?? 'N/A',
                    'apk_end_date' => $rdwData[0]['vervaldatum_apk_dt'] ?? 'N/A',
                    'cc' => $rdwData[0]['cilinderinhoud'] ?? "N/A",
                    'weight' => $rdwData[0]['massa_ledig_voertuig'] ?? 'N/A',
                    'tax' => $rdwData[0]['bruto_bpm'] ?? "N/A",
                    'title' => $title,
                    'description' => $description,
                    'price' => $price,
                    'sold' => $sold,
                    'show_when_sold' => $showWhenSold,
                ];
                $carDetails['odometer'] = $request->input('odometer');

                $response = $client->get("https://opendata.rdw.nl/resource/8ys7-d773.json?kenteken=$licencePlateStripped");
                $fuelData = json_decode($response->getBody(), true);

                if (!empty($fuelData)) {
                    $carDetails['fuel_efficiency'] = $fuelData[0]['brandstofverbruik_gecombineerd'] ?? "N/A";
                    $carDetails['fuel_type'] = $fuelData[0]['brandstof_omschrijving'] ?? 'N/A';
                }

                $occasion = new Occasion();
                $occasion->fill($carDetails);
                $occasion->save();

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $imageName = $occasion->id . '_' . $image->getClientOriginalName();
                        $image->storeAs('occasions/' . $occasion->id, $imageName);

                        $occasion->images()->create([
                            'image' => $imageName,
                            'path' => 'occasions/' . $occasion->id . '/' . $imageName,
                        ]);
                    }
                }

                return redirect()->route('dashboard.occasions.index')->with('success', 'Je hebt een nieuwe auto toegevoegd.');
            } else {
                return back()->with(['error' => 'Auto gegevens niet gevonden'])->withInput();
            }
        } catch (RequestException $e) {
            return back()->with(['error' => 'Kan auto gegevens niet ophalen van de RDW API.'])->withInput();
        }
    }

    public function overview(Request $request)
    {
        $query = $request->input('query');
    
        $occasions = Occasion::query();
        $now = Carbon::now();
    
        if ($query) {
            $occasions->where('licence_plate', 'like', "%$query%")
                ->orWhere('brand', 'like', "%$query%")
                ->orWhere('model', 'like', "%$query%");
        }
    
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
    
        if ($sortBy === 'brand' || $sortBy === 'price') {
            $occasions->orderBy($sortBy, $sortDirection);
        } else {
            $occasions->orderBy('created_at', 'desc');
        }

        $soldLastWeek = Occasion::where('sold', true)
        ->where('sold_date', '>=', $now->copy()->subWeek())
            ->count();

        $soldLastMonth = Occasion::where('sold', true)
        ->where('sold_date', '>=', $now->copy()->subMonth())
            ->count();

        $revenueLastWeek = Occasion::where('sold', true)
        ->where('sold_date', '>=', $now->copy()->subWeek())
            ->sum('price');

        $revenueLastMonth = Occasion::where('sold', true)
        ->where('sold_date', '>=', $now->copy()->subMonth())
            ->sum('price');

        $totalRevenue = Occasion::where('sold', true)->sum('price');

        $carsInStock = Occasion::where('sold', false)->count();
    
        $occasions = $occasions->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view("occasions.overview", compact('occasions', 'query', 'sortBy', 'sortDirection', 'soldLastWeek', 'soldLastMonth', 'revenueLastWeek', 'revenueLastMonth', 'totalRevenue', 'carsInStock'));
    }
    
    public function destroy(Occasion $occasion)
    {
        $occasion->images()->delete();
        $occasion->delete();
        return redirect(route("dashboard.occasions.index"))->with('success', 'Occasion verwijderd');
    }

    public function sell(Occasion $occasion)
    {
        $occasion->update([
            'sold' => 1,
            'sold_date' => Carbon::now(),
        ]);

        return redirect(route("dashboard.occasions.index"))->with('success', 'Occasion als verkocht gemarkeerd');
    }

    public function edit(Occasion $occasion)
    {
        return view("occasions.edit", compact('occasion'));
    }

    public function update(Occasion $occasion, OccasionStoreRequest $request)
    {
        $licencePlateStripped = str_replace('-', '', $request->input('licence_plate'));
        $licencePlate = $request->input('licence_plate');
        $transmission = $request->input('transmission');
        $power = $request->input('power');
        $title = $request->input('title');
        $description = $request->input('description');
        $price = $request->input('price');
        $sold = $occasion->sold;
        $showWhenSold = $request->has('show_when_sold') ? 1 : 0;
        $client = new Client();

        try {

            $response = $client->get("https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=$licencePlateStripped");
            $rdwData = json_decode($response->getBody(), true);

            if (!empty($rdwData)) {
                $year = substr($rdwData[0]['datum_eerste_toelating'], 0, 4);

                $carDetails = [
                    'licence_plate' => $licencePlate,
                    'brand' => $rdwData[0]['merk']?? 'N/A',
                    'model' => $rdwData[0]['handelsbenaming']?? 'N/A',
                    'color' => $rdwData[0]['eerste_kleur']?? 'N/A',
                    'year' => $year,
                    'body' => $rdwData[0]['inrichting']?? 'N/A',
                    'power' => $power,
                    'transmission' => $transmission,
                    'doors' => $rdwData[0]['aantal_deuren']?? 'N/A',
                    'seats' => $rdwData[0]['aantal_zitplaatsen']?? 'N/A',
                    'apk_end_date' => $rdwData[0]['vervaldatum_apk_dt']?? 'N/A',
                    'cc' => $rdwData[0]['cilinderinhoud'] ?? "N/A",
                    'weight' => $rdwData[0]['massa_ledig_voertuig']?? 'N/A',
                    'tax' => $rdwData[0]['bruto_bpm'] ?? "N/A",
                    'title' => $title,
                    'description' => $description,
                    'price' => $price,
                    'sold' => $sold,
                    'show_when_sold' => $showWhenSold,
                ];
                $carDetails['odometer'] = $request->input('odometer');

                $response = $client->get("https://opendata.rdw.nl/resource/8ys7-d773.json?kenteken=$licencePlateStripped");
                $fuelData = json_decode($response->getBody(), true);

                if (!empty($fuelData)) {
                    $carDetails['fuel_efficiency'] = $fuelData[0]['brandstofverbruik_gecombineerd'] ?? "N/A";
                    $carDetails['fuel_type'] = $fuelData[0]['brandstof_omschrijving']?? 'N/A';
                }

                $occasion->update($carDetails);
                $occasion->save();
                // foto's verwijderen
                if ($request->has('remove_images')) {
                    $removedImages = $request->remove_images;

                    if (!empty($removedImages)) {
                        foreach ($removedImages as $imageId) {
                            $occasionImage = OccasionImage::find($imageId);

                            if ($occasionImage) {
                                $imagePath = $occasionImage->path;
                                Storage::delete($imagePath);

                                $occasionImage->delete();
                            }
                        }
                    }
                }
                // foto's toevoegen
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $imageName = $occasion->id . '_' . $image->getClientOriginalName();
                        $image->storeAs('occasions/' . $occasion->id, $imageName);

                        $occasion->images()->create([
                            'image' => $imageName,
                            'path' => 'occasions/' . $occasion->id . '/' . $imageName,
                        ]);
                    }
                }

                return redirect()->route('dashboard.occasions.index')->with('success', 'Je hebt een nieuwe auto toegevoegd.');
            } else {
                return back()->with(['error' => 'Auto gegevens niet gevonden'])->withInput();
            }
        } catch (RequestException $e) {
            return back()->with(['error' => 'Kan auto gegevens niet ophalen van de RDW API.'])->withInput();
        }
    }
}
