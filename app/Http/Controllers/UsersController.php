<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Mostra la llista d'usuaris.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Comprovar si s'ha enviat un terme de cerca
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        })->paginate(10); // Paginació de 10 usuaris per pàgina

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
