<?php

namespace Tests\Domain;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        Config::set('app.allow_user_registration', true);
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
//
//
//namespace App\Http\Controllers\Auth;
//
//use App\Http\Controllers\Controller;
//use App\Models\User;
//use Illuminate\Auth\Events\Registered;
//use Illuminate\Http\RedirectResponse;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Validation\Rules;
//use Inertia\Inertia;
//use Inertia\Response;
//
//class RegisteredUserController extends Controller
//{
//    /**
//     * Display the registration view.
//     */
//    public function create(): Response
//    {
//        return Inertia::render('Auth/Register');
//    }
//
//    /**
//     * Handle an incoming registration request.
//     *
//     * @throws \Illuminate\Validation\ValidationException
//     */
//    public function store(Request $request): RedirectResponse
//    {
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
//            'password' => ['required', 'confirmed', Rules\Password::defaults()],
//        ]);
//
//        $isUsersAllowedToRegister = config('app.allow_user_registration');
//        $allowedEmailList = config('app.user_registration_exclusion_list', []);
//        $abort = !$isUsersAllowedToRegister && !in_array($request->email, $allowedEmailList, true);
//
//        if($abort) {
//            return redirect(route('login', absolute: false))->withErrors([
//                'email' => 'Registration is disabled'
//            ]);
//        }
//
//        $user = User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//        ]);
//
//        event(new Registered($user));
//
//        Auth::login($user);
//
//        return redirect(route('dashboard', absolute: false));
//    }
//}