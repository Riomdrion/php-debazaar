<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'in:klant,particulier,bedrijf'],
        ];

        if ($data['user_type'] === 'bedrijf') {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['slug'] = ['required', 'string', 'max:255', 'unique:bedrijfs,slug'];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Map the user_type to the corresponding role in your database
        $roleMapping = [
            'klant' => 'gebruiker',        // Klant maps to gebruiker
            'particulier' => 'particulier', // Particulier maps to particulier
            'bedrijf' => 'zakelijk',       // Bedrijf maps to zakelijk
        ];

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $roleMapping[$data['user_type']], // Map user_type to role
        ]);

        if ($data['user_type'] === 'bedrijf') {
            $user->bedrijf()->create([
                'naam' => $data['company_name'],
                'slug' => $data['slug'],
            ]);
        }

        return $user;
    }
}
