<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUpdateRequest;
use App\Http\Requests\MainInfoUpdateRequest;
use App\Http\Requests\UpdateTimeRequest;
use Illuminate\Http\Request;
use App\Models\SiteInfo;
use App\Models\Occasion;
use App\Models\Day;

class HomeController extends Controller
{
    public function index()
    {
        $occasions = Occasion::latest()->take(3)->get();

        return view('index', compact('occasions'));
    }

    public function general()
    {
        $landingPageContent = SiteInfo::firstOrCreate([]);
        return view('home.general', compact('landingPageContent'));
    }

    public function update(MainInfoUpdateRequest $request)
    {
        $landingPageContent = SiteInfo::firstOrCreate([]);
        $landingPageContent->update($request->all());

        return redirect()->route('dashboard.users.index')->with('success', 'Landingspagina informatie succesvol aangepast');
    }

    public function contact()
    {
        $contactInfo = SiteInfo::firstOrCreate([]);
        return view('home.contact', compact('contactInfo'));
    }

    public function updateContact(ContactUpdateRequest $request)
    {

        $contactInfo = SiteInfo::firstOrCreate([]);
        $contactInfo->update([
            'contact_email' => $request->input('contact_email'),
            'contact_number' => $request->input('contact_number'),
        ]);

        return redirect()->route('dashboard.users.index')->with('success', 'Contact informatie succesvol aangepast');
    }

    public function time()
{
    $days = Day::all();

    $weekdayNames = [
        'Maandag',
        'Dinsdag',
        'Woensdag',
        'Donderdag',
        'Vrijdag',
        'Zaterdag',
        'Zondag',
    ];

    return view('home.time', compact('days', 'weekdayNames'));
}

    public function updateTime(UpdateTimeRequest $request)
    {
        foreach ($request->days as $id => $day) {
            if (isset($day['closed']) && $day['closed'] == 1) {
                $openingTime = null;
                $closingTime = null;
            } else {
            $openingTime = date('Y-m-d H:i:s', strtotime('today ' . $day['opening_time']));
            $closingTime = date('Y-m-d H:i:s', strtotime('today ' . $day['closing_time']));
            }

            Day::where('id', $id)->update([
                'opening_time' => $openingTime,
                'closing_time' => $closingTime,
                'closed' => isset($day['closed']) && $day['closed'] == 1 ? 1 : 0,
            ]);
        }

        return redirect()->route('dashboard.users.index')->with('success', 'Openingstijden zijn bijgewerkt.');
    }
    
}
