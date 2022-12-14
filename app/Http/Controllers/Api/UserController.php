<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\DepartemenResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Passport;
use App\Http\Controllers\Controller;

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
        if ($user->is_active == 0) {
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
        // //Validasi Formulir
        // $validator = Validator::make($request->all(), [
        // 'email'=> 'required || email',
        // 'password'=> 'required',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }
        // //Fungsi Simpan Data ke dalam Database
        // $user = User::create([
        // 'name' => $request->name,
        // 'username' => $request->username,
        // 'email'=> $request->email,
        // 'password'=> $request->password,
        // 'img' => $request->img,
        // 'is_active' => 0
        // ]);
        // return new DepartemenResource(true, 'Data User Berhasil Ditambahkan!', $user);

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
        return new DepartemenResource(true, 'Data User Berhasil Ditambahkan!', $user);
    }
    
    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $user = User::findOrfail($id)->delete();

    //     return new DepartemenResource(true, 'Data Barang Dihapus', $user); 
    // }

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

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //Validasi Formulir
    //     $validator = Validator::make($request->all(), [
    //         'nama_barang' => 'required',
    //         'supplier_id' => 'required',
    //         'harga'=> 'required || gte:0',
    //         'in_stok'=> 'required',
    //         'expired' => 'required || date'
    //         ]);
    //         if ($validator->fails()) {
    //             return response()->json($validator->errors(), 422);
    //         }

    //     $barang=Barang::find($id);
       
    //     $barang->nama_barang =  $request->get('nama_barang');
    //     $barang->supplier_id = $request->get('supplier_id');
    //     $barang->harga = $request->get('harga');
    //     $barang->in_stok = $request->get('in_stok');
    //     $barang->expired = $request->get('expired');

    //     $barang->save();

    //     return new DepartemenResource(true, 'Data Barang Berhasil Diupdate!', $barang);
    // }

    public function show($id)
    {
        $user = User::find($id);
        return response([
            'data' => $user
        ], 200);
    }
}
