<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected function redirectTo()
    {
        // Always redirect to home page for clients
        return route('home');  // Redirect to home page after registration for clients
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        // Liste des noms des images disponibles
        $avatars = [
            'images/avatar-1.png',
            'images/avatar-2.png',
            'images/avatar-3.png',
            'images/avatar-4.png',
            'images/avatar-5.jpg',
            'images/avatar-6.jpg',
            'images/avatar-7.jpg',
            'images/avatar-8.jpg',
            'images/avatar-9.jpg',
            'images/avatar-10.jpg',
        ];
    
        // Sélectionnez une image aléatoire
        $randomAvatar = $avatars[array_rand($avatars)];
    
        // Créez l'utilisateur avec une image aléatoire
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'avatar' => $randomAvatar, // Image aléatoire
        ]);
    
        // Assignez le rôle 'client' par défaut
        $user->assignRole('client');
    
        return $user;
    }
}
