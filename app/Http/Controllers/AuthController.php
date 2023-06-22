<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\NewPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Imports\UsersImport;
use App\Jobs\MailVerification;
use App\Mail\ForgotPassword;
use App\Mail\RegisterUser;
use App\Mail\RegisterUserMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        $register = null;
        return view('auth.register', compact('register'));
    }

    public function checkLogin(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                session()->put('user', $user);
                Auth::setUser($user);
//                dd(\auth()->user());
                if ($user->hasRole('admin')) {
                    return redirect()->route('view-user-admin')->with('success', 'Welcome Admin');
                } else if ($user->hasRole('super-admin')) {
                    return redirect()->route('view-user-admin')->with('success', 'Welcome Super-Admin.');
                } else {
                    return redirect()->route('home1')->with('success', 'Welcome User');
                }
            } else {
                return redirect()->route('login')->with('fail', 'Please enter valid password');
            }
        } else {
            return redirect()->route('login')->with('fail', 'Please enter valid email');
        }
    }

    public
    function store(RegisterRequest $request
    ) {
        $register = User::create(
            [
                'name' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'remember_token' => Str::random(20),
            ]
        );
        if ($register) {
            $mailData = [
                "token_key" => $register->remember_token,
                "id" => $register->id,
                "name" => $register->name,
                "email" => $register->email,
                "url" => route('email-verify', ['id' => $register->id, 'token_key' => $register->remember_token]),
            ];
            $emails = [];
            //dd($mailData);
//            dd(route('email-verify',['id'=>$mailData['id'],'token_key'=>$mailData['token_key']]));
            $this->dispatch(new MailVerification($mailData));
            return redirect(route('login'))->with('success', 'Registration successfully and verification link sent to your registered email.');
        } else {
            return back()->with('fail', 'Something went wrong');
        }
    }

    public
    function emailVerify($id, $tokenKey
    ) {
        //dd(config('constant.email_verification.status.not_verified'));
        $user = User::where('id', $id)
                    ->where('remember_token', $tokenKey)
                    ->where('email_verification', config('constant.email_verification.status.not_verified'))
                    ->first();
        if ($user) {
            return view('auth.setPassword', compact('user'));
        } else {
            return response()->json('User not found. Or link expired.');
        }
    }

    public
    function setNewPassword(NewPasswordRequest $request
    ) {
        $user = User::where(['id' => $request->id, 'remember_token' => $request->token_key, 'email_verification' => '0'])
                    ->where('remember_token', $request->token_key)
                    ->where('email_verification', config('constant.email_verification.status.not_verified'))
                    ->first();
        config("constant.store.status_code.inactive");
        if ($user) {
            $user->update(
                [
                    'password' => Hash::make($request->password),
                    'email_verification' => config('constant.email_verification.status.verified'),
                    'remember_token' => null,
                ]
            );
            if ($user) {
                return redirect(route('login'))->with('success', 'Password created successfully');
            } else {
                return back()->with('fail', 'Something went wrong');
            }
        } else {
            return response()->json('User not found.');
        }
    }

    public
    function forgotPassword()
    {
        return view('auth.forgotPassword');
    }

    public
    function emailCheck(UserRequest $request
    ) {
        $user = User::where('email', $request->email)
                    ->where('email_verification', config('constant.email_verification.status.verified'))
                    ->first();

        if ($user) {
            $user->update(
                [
                    'remember_token' => Str::random(20),
                ]
            );
            $mailData = [
                "id" => $user->id,
                "token_key" => $user->remember_token,
            ];
//            dd($mailData);
            Mail::to($user->email)->send(new ForgotPassword($mailData));
            return back()->with('success', 'Please check your mail and click the link to reset password');
        } else {
            return back()->with('fail', 'Please enter registered email or email is not verify');
        }
    }

    public
    function viewForgotPassword($id, $token_key
    ) {
        $user = User::find($id);
        $user->remember_token = $token_key;
        return view('auth.setForgotPassword', compact('user'));
    }

    public
    function setForgotPassword(NewPasswordRequest $request
    ) {
        if ($request->id)
            $register = User::where('id', $request->id)->update(
                [
                    'password' => Hash::make($request->password),
                    'remember_token' => null,
                ]
            );
        if ($register) {
            return redirect(route('login'))->with('success', 'Password updated successfully, Please login with new password');
        } else {
            return back()->with('fail', 'Something went wrong');
        }
    }


    public
    function implementCollection()
    {
//        $collection = collect([1, 2, 3]);
//        $collection = collect([1, 2, 3])->dd();
//        dd($collection->all());
//        dd($collection->avg());
//        dd($collection->chunk(2)->all());

        //--combine an array with another array
//        $collection = collect(['name','age']);
//        $combined = $collection->combine(['Jaypal',29]);
//        dd($combined->all());
//        $collection->contains(function ($value, $key) {
//            dd($key > 5);
//        });
        //dd($collection->contains('4'));

//        $collection = collect([
//           ['product' => 'puma','price'=>'500'],
//           ['product' => 'adidas','price'=>'700']
//        ]);
//        dump($collection->contains('product','adidas'));

//        $collection = collect(['alice@gmail.com', 'bob@yahoo.com', 'carlos@gmail.com']);
//
//        $counted = $collection->countBy(function ($email) {
//            return substr(strrchr($email, "@"), 1);
//        });
//
//        dd($counted->all());


//        $collection = collect([1, 2]);
//
//        $matrix = $collection->crossJoin(['a', 'b']);
//
//        dd($matrix->all());

//        $collection = collect([1, 2]);
//
//        $matrix = $collection->crossJoin(['a', 'b'], ['I', 'II']);
//
//        dd($matrix->all());

//        $collection = collect([1, 2, 3, 4, 5]);
//
//        $diff = $collection->diff([2, 4, 6, 8]);
//
//        dd($diff->all());

//        $collection = collect([
//            'color' => 'orange',
//            'type' => 'fruit',
//            'remain' => 6,
//        ]);
//
//        $diff = $collection->diffAssoc([
//            'color' => 'yellow',
//            'type' => 'fruit',
//            'remain' => 3,
//            'used' => 6,
//        ]);
//
//        dd($diff->all());

//        $collection = collect([
//            'one' => 10,
//            'two' => 20,
//            'three' => 30,
//            'four' => 40,
//            'five' => 50,
//        ]);
//
//        $diff = $collection->diffKeys([
//            'two' => 2,
//            'four' => 4,
//            'six' => 6,
//            'eight' => 8,
//        ]);
//        dd($diff->all());

//        $collection = collect([1, 2, 3, 4, 5]);
//
//        $collection->doesntContain(function ($value, $key) {
//            dd($value > 5);
//        });

//        $collection = collect(['name' => 'Desk', 'price' => 100]);
//
//        dump($collection->doesntContain(10));
//        dump($collection->doesntContain('desk'));

        //$collection->doesntContain('Desk');

//        $collection = collect([1, 2, 3]);
//
//        $collection->each(function ($item, $key) {
//            if ($key == 1) {
//                dump("hello");
//            }
//            dump("jay ho");
//        });

//        $collection = collect(['product_id' => 1, 'price' => 100, 'discount' => false]);
//
//        $filtered = $collection->except(['price']);
//
//        dd($filtered->all());

//        $collection = collect([1, 2, 3, 4]);
//
//        $filtered = $collection->filter(function ($value, $key) {
//            return $value > 2;
//        });
//
//        dd($filtered->all());

        //---------------------------

//        $collection = collect([
//            ['account_id' => 'account-x10', 'product' => 'Chair'],
//            ['account_id' => 'account-x10', 'product' => 'Bookcase'],
//            ['account_id' => 'account-x11', 'product' => 'Desk'],
//        ]);
//
//        $grouped = $collection->groupBy('account_id');
//
//        dd($grouped->all());
//-------------------------------------------------
//        $collection = collect([
//            ['account_id' => 1, 'product' => 'Desk'],
//            ['account_id' => 2, 'product' => 'Chair'],
//        ]);

//       $collection = collect([1, 2, 3, 4, 5])->implode('-');
//
//        dump($collection->implode( '-'));

        //----------------------------------------

//        collect([1, 2, 3, 4])->last(function ($value, $key) {
//            return $value < 3;
//        });
        //---------------------------------------------

//        $collection = collect(['product_id' => 1, 'price' => 100]);
//
//        $merged = $collection->merge(['price' => 200, 'discount' => false]);
//
//        dd($merged->all());

        //---------------------------------------

//        $collection = collect([
//            ['product_id' => 'prod-100', 'name' => 'Desk'],
//            ['product_id' => 'prod-200', 'name' => 'Chair'],
//        ]);
//
//        $plucked = $collection->pluck('name');
//
//        dd($plucked->all());

//        $collection = collect([
//            [
//                'name' => 'Laracon',
//                'speakers' => [
//                    'first_day' => ['Rosa', 'Judith'],
//                ],
//            ],
//            [
//                'name' => 'VueConf',
//                'speakers' => [
//                    'first_day' => ['Abigail', 'Joey'],
//                ],
//            ],
//        ]);
//
//        $plucked = $collection->pluck('speakers.first_day');
//
//        dd($plucked->all());
//
//        $collection = collect([
//            ['brand' => 'Tesla',  'color' => 'red'],
//            ['brand' => 'Pagani', 'color' => 'white'],
//            ['brand' => 'Tesla',  'color' => 'black'],
//            ['brand' => 'Pagani', 'color' => 'orange'],
//        ]);
//
//        $plucked = $collection->pluck('color', 'brand');
//
//        dd($plucked->all());

        //------------------------------------
//        $collection = collect(['name' => 'Desk', 'price' => 200]);
//        dump($collection);
//        dump($collection->all());
//        dump($collection->toArray());
        //-------------------------------------------
//        $collection = collect(
//            [['name' => 'Desk', 'price' => 200],
//            ['name'=>'Pro','price'=>210]]);
//
//        dump($collection->toJson());

    }

    public
    function implementHelper()
    {
//        dump("hello");

//        $array = Arr::add(['name' => 'Desk'], 'price', 100);
//        $array = Arr::collapse([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);
//        dump($array);


        //----Arr::dot()
//        $array = [
//            'products' => [
//                'desk' => [
//                    'price' => 10,
//                ],
//                'value' => [
//                    'base' => 123,
//                ],
//            ],
//        ];
//
//        $flattened = Arr::dot($array);
//        dd($flattened['products.value.base']);

        //----devide()
//        [$keys, $values] = Arr::divide([
//            [
//                'jaypal','dhaval','smit'
//            ],
//            [
//                'Parth','Dinesh','Jd'
//            ],
//        ]);
        //dump($values);

        //-----extra with devide
//        $data = Arr::collapse($values);
//        dump($data);

        //---Arr::except()
//        $array = ['name'=>'jaypal','position'=>'developer'];
//        $data = Arr::except($array,'position');
//        dump($data);

        //--Arr::first()

//        $array = ['name'=>'jaypal','position'=>'developer','age'=>30];
//        $data = Arr::exists($array,'position');
//        dump($data);

        //--Arr::flatten()
//        $array = [
//            'name'=>'Jaypal',
//            'language' => [
//                'php','java','python'
//            ]
//        ];
//
//        $data = Arr::flatten($array);
//        dump($data);

        //--Arr::forget()
//        $array = [
//            'products' =>
//                [
//                    'puma' =>
//                        [
//                            'price' => 100,
//                        ],
//                ],
//        ];
//        $dot = Arr::dot($array);
//        dump($dot['products.puma.price']);
//        dump(Arr::forget($array, 'products.puma'));
//        dump($array);

        //--Arr::first()

//        $array = [100,150,200,400];
//        $data = Arr::first($array,function ($val,$key){
//           dump($val > 200);
//        });

        //----Arr::get()

//        $array = ['products' => ['desk' => ['price' => 100]]];
//        $price = Arr::get($array, 'products.desk.price');
//        dump($price);

        //-----Arr::has

//        $array = ['product' => ['name' => 'Desk', 'price' => 100]];
//
//        $contains = Arr::has($array, 'product.name'); //--true
//        $contains1 = Arr::has($array, 'product.disc'); //--false
//
//        dump($contains);
//        dump($contains1);

        //----Arr::hasAny()

//        $array = ['product' => ['name' => 'Desk', 'price' => 100]];
//
//        $contains = Arr::hasAny($array, 'product.name');    // true
//        $contains1 = Arr::hasAny($array, ['product.name', 'product.discount']);// true
//        $contains2 = Arr::hasAny($array, ['category', 'product.discount']);//false
//
//        dump($contains);
//        dump($contains1);
//        dump($contains2);


        //-------Arr::keyBy()

//        $array = [
//            ['product_id' => 'prod-100', 'name' => 'Desk'],
//            ['product_id' => 'prod-200', 'name' => 'Chair'],
//        ];
//
//        $keyed = Arr::keyBy($array, 'name');
//        dump($keyed);

        //---Arr::map()

//        $array = ['first' => 'james', 'last' => 'kirk'];
//
//        $mapped = Arr::map($array, function ($value, $key) {
//            dump(ucfirst($key));
//            dump(ucfirst($value));
//        });

        //----extra work work pluck() with database
//        $user = User::whereBetween('id', [50, 100])
//                    ->pluck('name');
//        dd($user);

//        $array = [
//            ['developer' => ['id' => 1, 'name' => 'Taylor']],
//            ['developer' => ['id' => 2, 'name' => 'Abigail']],
//        ];
////
//        $names = Arr::pluck($array, 'developer.name');
//        dump($names);

//        $names = Arr::pluck($array, 'developer.name', 'developer.id');
//      dump($names);

        //--Arr::prepend()
//        $array = ['one', 'two', 'three', 'four'];
//
//        $array = Arr::prepend($array,'zero');
//        dump($array);

        //--Arr::pull()

//        $array = ['name' => 'Desk', 'price' => 100];
//
//        $name = Arr::pull($array, 'price');
//        dump($array);

        //---Arr::random()
//        $array = [1, 2, 3, 4, 5];
//
//        $random = Arr::random($array,2);
//        dump($random);

        //--Arr::set()
//        $array = ['products' => ['desk' => ['price' => 100]]];
//        dump($array);
//        $data = Arr::set($array, 'products.desk.price', 200);
//        dump($array);
//        dump($data);

        //---Arr::shuffle()
//        $array = Arr::shuffle(['hy', 'by', 'shy', 'lyy', 'my']);
//        dump($array);

//        $array = ['Desk', 'Table', 'Chair'];
//
//        dump($sorted = Arr::sort($array));

        //--Arr::undot()

//        $array = [
//            'user.name' => 'Kevin Malone',
//            'user.occupation' => 'Accountant',
//        ];
//
//        $array = Arr::undot($array);
//        dump($array);

        //------Arr::where()

//        $array = [100, '200', 300, '400', 500];
//
//        $filtered = Arr::where($array, function ($value, $key) {
//            return is_string($value);
//        });

//        $cart[] = [];
//        for ($i = 0; $i <= 5; $i++) {
//            for ($j = 0; $j <= 5; $j++) {
//                $cart[] = $i;
//            }
//        }
//        echo "<pre>";
//        print_r($cart);
//        echo "</pre>";

        //---implementing multidimensional array
//        $cars = array (
//            array("Volvo",22,18),
//            array("BMW",15,13),
//            array("Saab",5,2),
//            array("Land Rover",17,15)
//        );
//
//        $data[][] = [];
//        for ($row = 0; $row < 4; $row++) {
//            echo "<p><b>Row number $row</b></p>";
//            echo "<ul>";
//            for ($col = 0; $col < 3; $col++) {
//                $data[$row][$col]= $cars[$row][$col];
//            }
//            echo "</ul>";
//        }
//        dump($data);

//        $array = [0, null];
//
//        $filtered = Arr::whereNotNull($array);
//        dump($filtered);

        //--Arr::data_fill()
//        $data = ['products' => ['desk' => ['price' => 100]]];
//
//        $val = data_fill($data, 'products.desk.price', 200);
//
//        dump($val);
//        data_fill($data, 'products.desk.discount', 10);
//
//        dump($data);


        //--
//        $path = config_path();
//
//        $path = config_path('app.php');
//
//        $path = public_path();
//
//        $path = public_path('css/app.css');

//        $path = resource_path();
//
//        $path = resource_path('sass/app.scss');
//        $path = storage_path();
//
//        $path = storage_path('app/file.txt');
//        dump($path);


//--------------------------------------------------------------------------------------------------


//        $excerpt = Str::excerpt('This is my name', 'my', [
//            'radius' => 1
//        ]);
//        dd($excerpt);


//        $matches = Str::is('*foo*', 'foobar');
//        dump($matches);
//
//        $matches = Str::is('*baz', 'foobaz');
//        dump($matches);

        //--Str::is_json()
//        $result = Str::isJson('[1,2,3]');
//        dump($result);
//
//        $result = Str::isJson('{"first": "John", "last": "Doe"}');
//        dump($result);
//        $result = Str::isJson('{first: "John", last: "Doe"}');
//        dump($result);

//        $isUuid = Str::isUuid('a0a2a2d2-0b87-4a18-83f2-2529882be2de');
//        dump($isUuid);
//        $isUuid = Str::isUuid('f2n34n5n4n4-0wdf3-dfj3df-34nejn3');
//        dump($isUuid);


    }
}
