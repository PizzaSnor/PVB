<?php

namespace App\Http\Controllers;

use App\Models\Occasion;
use Illuminate\Http\Request;

class OccasionController extends Controller
{
    public function home()
    {
        $occasions = Occasion::latest()->take(3)->get();

        return view('index', compact('occasions'));
    }

    public function index()
    {
        $occasions = Occasion::paginate(6);

        return view('occasions.index', compact('occasions'));
    }

    public function view($id)
    {
        $occasion = Occasion::findOrFail($id);

        return view('occasions.view', compact('occasion'));
    }
}
