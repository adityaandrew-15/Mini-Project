<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dokter;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|regex:/^[0-9]{10,15}$/|max:15', // Phone is nullable
            'spesialis' => 'nullable|string|max:255', // spesialis is nullable
        ],[
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka dan memiliki panjang antara 10 hingga 15 digit.',
        ]);
    }

protected function create(array $data)
{
    if($data['role'] == 1){
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make(($data['password']))
        ]);

        $user->assignRole('user');
    }else{
        $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'spesialis' => $data['spesialis'], // Store the spesialis in the users table
    ]);

        // If no spesialis is provided, assign the 'user' role
        if (empty($data['spesialis'])) {
            $user->assignRole('user'); // Assign the 'user' role
        } else {
            $user->assignRole('dokter'); // Assign the 'dokter' role if spesialis is provided
        }

        // If the user is a 'dokter', create the corresponding 'dokter' record
        if (!empty($data['spesialis'])) {
            $dokter = new Dokter([
                'nama' => $data['name'],
                'spesialis' => $data['spesialis'],
                'no_hp' => $data['phone'] ?? null, // If no phone, set it as null
            ]);

    $user->dokter()->save($dokter);
    }
    // Create the user


    return $user;
}

        return $user;
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fill all fields correctly and ensure passwords match.');
        }

        $user = $this->create($request->all());

        $this->guard()->login($user);

        // Redirect to the appropriate page based on the role
        if ($user->hasRole('dokter')) {
            return redirect('/home-dokter')->with('success', 'Registration successful!');
        } else {
            return redirect('/home')->with('success', 'Registration successful!');
        }
    }
}
