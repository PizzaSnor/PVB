<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Returns the view of the user table overview
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $loggedInUserId = Auth::id();

        $users = User::where('id', '!=', $loggedInUserId)
            ->orderBy('created_at', 'desc');
    
        if ($query) {
            $users->where('name', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%");
        }
    
        $users = $users->paginate(10)->withQueryString();
    
        return view("users.index", compact('users', 'query'));
    }

    /**
     * sends the user to the user edit page
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(User $user)
    {
        $user = User::find($user->id);
        $users = User::all();
        $roles = Role::all();
        return view("users.edit", compact('users', 'user', 'roles'));
    }

    /**
     * Updates an validates user data.
     *
     * reditects to dashboard after
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if ($user->id === auth()->user()->id && $request->role_id < auth()->user()->role_id) {
            return redirect()->route("dashboard.users.index")->with('error', 'Je kunt jezelf niet degraderen naar een rol met minder rechten.');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route("dashboard.users.index")->with('success', 'Gebruiker aangepast');
    }

    /**
     * Removes user from the DB including tasks and logs
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route("dashboard.users.index"))->with('success', 'Gebruiker verwijderd');
    }
}
