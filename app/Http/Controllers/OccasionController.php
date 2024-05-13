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

    public function overview(Request $request)
    {
        $query = $request->input('query');

        $occasions = Occasion::paginate(10);

        if ($query) {
            $occasions->where('licence_plate', 'like', "%$query%")
                ->orWhere('brand', 'like', "%$query%");
        }

//        $occasions = $occasions->paginate(10)->withQueryString();

        return view("occasions.overview", compact('occasions', 'query'));
    }

    public function destroy(Occasion $occasion)
    {
        $occasion->images()->delete();
        $occasion->delete();
        return redirect(route("dashboard.occasions.index"))->with('success', 'Occasion verwijderd');

    }

}
