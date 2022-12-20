<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\DepartemenResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Passport;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    /**
    * index
    *
    * @return void
    */

    public function index(){
        //get posts
        $user = User::latest()->get();
        //render view with posts
        return new DepartemenResource(true, 'List Data User', $user);

    }

    /**
    * create
    *
    * @return void
    */
    public function create()
    {
        $user = User::all();

        return view('user.create', compact('supplier'));
    }

    //login
    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData,[
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],400); 
        if(!Auth::attempt($loginData))
            return response(['message' => 'Invalid Credentials'],401); 
        
        $user = Auth::user();
        if ($user->email_verified_at == NULL) {
            return response([
                'message' => 'Please Verify Your Email'
            ], 401); //Return error jika belum verifikasi email
        }
        $token = $user->createToken('Authentication Token')->accessToken; //generate token
        
        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]); //retun data user dan token dalam bentuk json
    }

    // public function logout(){
    //     $user = Auth::user()->token();
    //     $user->revoke();

    //     return response([
    //         'message' => 'Berhasil Logout',
    //     ]); //retun data user dan token dalam bentuk json
    // }

    /**
    * store
    *
    * @param Request $request
    * @return void
    */
    public function store(Request $request)
    {
        $registrationData = $request->all();
        $validate = Validator::make($registrationData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required'
        ]);

        // return error validation input
        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $registrationData['password'] = bcrypt($request->password); // enkripsi password
        $registrationData['is_active'] = 0;
        $user = User::create($registrationData); // membuat user baru
        // $user->sendApiEmailVerificationNotification();
        event(new Registered($user));
        return new DepartemenResource(true, 'Data User Berhasil Ditambahkan!', $user);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id)->delete();

        return new DepartemenResource(true, 'Data User Dihapus', $user); 
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $barang = Barang::find($id);
    //     $supplier = Supplier::all();

    //     //return view('proyek.edit', compact('proyek', 'departemen'));
    //     return view('barang.edit', compact('barang', 'supplier'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:60',
            'username' => 'required',
            'email'=> 'required|email:rfc,dns',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

         $user=User::find($id);
       
        $user->name =  $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->img = $request->get('img');

        $user->save();

        return new DepartemenResource(true, 'Data User Berhasil Diupdate!', $user);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response([
            'data' => $user
        ], 200);
    }
}
