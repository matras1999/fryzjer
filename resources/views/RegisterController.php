<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\SmsController;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
{
    // Dodajemy +48 do numeru telefonu, jeśli jeszcze nie ma tego prefiksu
     $phone_number = '+48' . $data['phone'];
    
    // Utwórz użytkownika z dodanym prefiksem do numeru telefonu
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'phone' => $phone_number,
    ]);

    // Następnie wysyłamy SMS
    $sms_body = "Witaj w salonie fryzjerskim Matras Hair. Zapraszamy do skorzystania z naszych usług. Więcej na www.matrashair.pl";

    // Zauważ, że nie musimy tworzyć nowego Request, możemy po prostu przekazać dane bezpośrednio do metody
    $smsController = new SmsController();
    $smsController->sendSms(new Request(['phone' => $phone_number, 'body' => $sms_body]));


    // Na końcu zwracamy utworzonego użytkownika
    return $user;
}

}
