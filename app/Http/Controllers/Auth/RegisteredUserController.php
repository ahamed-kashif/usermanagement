<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the user registration form.
     */
    public function create(): Response
    {
        return Inertia::render('User/Register');
    }

    /**
     * Handle an incoming user registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect(route('users.index'))->with('success', 'User created successfully!');
    }

    /**
     * Display a paginated list of users.
     */
    public function index(Request $request): Response
    {
        // Retrieve the search query
        $search = $request->input('search');

        // Fetch users, filtering based on search query
        $users = User::where('role', '!=', 'admin')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })

//            ->withCount('uri as responses_count')
            ->paginate(10);
        // Return the results to the Inertia view
        return Inertia::render('User/Index', [
            'users' => $users,
        ]);
    }


    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        try{
            $user = User::findOrFail($id);
            return Inertia::render('User/Register', [
                'user' => $user,
            ]);
        }catch (ModelNotFoundException $exception){
            return to_route('users.index')->with('error', 'User not found!');
        }
    }

    /**
     * Update the specified user in the database.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);
        try{
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);
        }catch (ModelNotFoundException $exception){
            return to_route('users.index')->with('error', 'User not found!');
        }


        return redirect(route('users.index'))->with('success', 'User updated successfully!');
    }

    /**
     * Delete the specified user from the database.
     */
    public function destroy($id): RedirectResponse
    {
        try{
            $user = User::findOrFail($id);
            $user->delete();
        }catch (ModelNotFoundException $exception){
            return to_route('users.index')->with('error', 'User not found!');
        }


        return redirect(route('users.index'))->with('success', 'User deleted successfully!');
    }
}
