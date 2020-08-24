<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\{User, Province, Address};
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
    protected $redirectTo = RouteServiceProvider::INDEX;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $province;
    public $address;
    public function __construct(Province $province, Address $address)
    {
        $this->middleware('guest');
        $this->province = $province;
        $this->address = $address;

        $provinces = $this->province->allProvince();
        view()->share(compact('provinces'));
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
            'username' => ['required', 'string', 'max:15', 'min:3', 'unique:users', 'regex:/^\S*$/u'],
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'numeric', 'digits:10'],
            'province' => ['required'],
            'district' => ['required'],
            'ward' => ['required'],
            'street' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $result = User::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);
        $credentials = [];
        $credentials['province_id'] = $data['province'];
        $credentials['district_id'] = $data['district'];
        $credentials['ward_id'] = $data['ward'];
        $credentials['street'] = $data['street'];
        $credentials['user_id'] = $result['id'];
        $credentials['default'] = 1;
        $this->address->create($credentials);
        return $result;
    }                       
}
