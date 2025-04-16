<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelpers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersManagerController extends Controller
{
    /**
     * Mostra la llista d'usuaris.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtenim tots els usuaris per mostrar a la vista
        $users = User::all();

        // Retornem la vista amb la llista d'usuaris
        return view('users.manage.index', compact('users'));
    }

    /**
     * Mostra el formulari per crear un nou usuari.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.manage.create', compact('roles'));
    }

    /**
     * Emmagatzema un nou usuari.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validem les dades del formulari
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        // Creem un nou usuari
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        UserHelpers::add_personal_team($user);

        $user->assignRole($validated['role']);

        // Redirigim a la llista d'usuaris
        return redirect()->route('users.index')->with('success', 'Usuari creat amb èxit!');
    }

    /**
     * Mostra el formulari per editar un usuari.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Busquem l'usuari per la seva ID
        $user = User::findOrFail($id);

        $roles = Role::all();
        $userRole = $user->roles->first()?->name;

        // Retornem la vista per editar l'usuari
        return view('users.manage.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Actualitza les dades d'un usuari.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validem les dades del formulari
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        // Busquem l'usuari per la seva ID
        $user = User::findOrFail($id);

        // Actualitzem les dades de l'usuari
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->syncRoles([$validated['role']]);

        // Si s'ha introduït una nova contrasenya, s'actualitza
        if (!empty($validated['password'])) {
            $user->update(['password' => bcrypt($validated['password'])]);
        }

        // Redirigim a la llista d'usuaris amb missatge de confirmació
        return redirect()->route('users.index')->with('success', 'Usuari actualitzat amb èxit!');
    }

    /**
     * Mostra el formulari de confirmació per eliminar un usuari.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function delete($id)
    {
        // Busquem l'usuari per la seva ID
        $user = User::findOrFail($id);

        // Retornem la vista de confirmació d'eliminació
        return view('users.manage.delete', compact('user'));
    }

    /**
     * Elimina un usuari.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Busquem l'usuari per la seva ID
        $user = User::findOrFail($id);

        // Eliminem l'usuari de la base de dades
        $user->delete();

        // Redirigim a la llista d'usuaris amb missatge de confirmació
        return redirect()->route('users.index')->with('success', 'Usuari eliminat amb èxit!');
    }

    /**
     * Funció per a tests.
     *
     * @return string
     */
    public function testedBy()
    {
        return 'Tested by UsersManageController';
    }
}

