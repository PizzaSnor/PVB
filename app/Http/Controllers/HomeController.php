<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteInfo;
use App\Models\Occasion;

class HomeController extends Controller
{
    public function index()
    {
        $occasions = Occasion::latest()->take(3)->get();

        return view('index', compact('occasions'));
    }

    // public function general()
    // {
    //     $landingPageContent = LandingPageContent::firstOrCreate([]);
    //     return view('home.general', compact('landingPageContent'));
    // }

    // public function update(Request $request)
    // {
    //     $landingPageContent = LandingPageContent::firstOrCreate([]);
    //     $landingPageContent->update($request->all());

    //     return redirect()->route('dashboard.tasks.index')->with('success', 'Landing page informatie succesvol aangepast');
    // }

    public function contact()
    {
        $landingPageContent = SiteInfo::firstOrCreate([]);
        return view('home.contact', compact('landingPageContent'));
    }

    public function updateContact(Request $request)
    {
        $landingPageContent = SiteInfo::firstOrCreate([]);
        $landingPageContent->update([
            'contact_email' => $request->input('contact_email'),
            'contact_number' => $request->input('contact_number'),
        ]);

        return redirect()->route('dashboard.tasks.index')->with('success', 'Contact informatie succesvol aangepast');
    }
}
