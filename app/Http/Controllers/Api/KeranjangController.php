<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Http\Resources\DepartemenResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class KeranjangController extends Controller
{
        /**
        * index
        *
        * @return void
        */
        
        public function index(){
            //get departemen
            $keranjang = Keranjang::latest()->get();
            //render view with posts
            return new DepartemenResource(true, 'List Data Keranjang', $keranjang);
        }

        /**
        * index
        *
        * @return void
        */
        
        public function indexbuyer($user_id){
            //get departemen
            $keranjang = Keranjang::where('user_id', $user_id)->get();
            //render view with posts
            return new DepartemenResource(true, 'List Data Keranjang', $keranjang);
        }
    
    
        /**
        * store
        *
        * @param Request $request
        * @return void
        */
        public function store(Request $request)
        {
            //Validasi Formulir
            $validator = Validator::make($request->all(), [
                'nama_barang' => 'required',
                'jumlah' => 'required',
                'harga' => 'required',
                'user_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            //Fungsi Post ke Database
            $keranjang = Keranjang::create([
                'nama_barang' => $request->nama_barang,
                'jumlah' => $request->jumlah,
                'harga' => $request->harga,
                'user_id' => $request->user_id,
                'status' => $request->status,
            ]);
                return new DepartemenResource(true, 'Data Keranjang Berhasil Ditambahkan!', $keranjang);
        
        }
        
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $keranjang = Keranjang::findOrfail($id); //mencari data product berdasarkan id
            $keranjang->delete();
    
            return new DepartemenResource(true, 'Data Keranjang Dihapus', $keranjang);        
        }
    
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
            
    
             //find departemen by ID
            $keranjang = Keranjang::find($id);
    
                //update post
                   $keranjang->status = $request->get('status');
                   $keranjang->save();
                return new DepartemenResource(true, 'Berhasil Bayar!', $keranjang);
    
        }
    
        public function show($id)
        {
            $supplier = Supplier::find($id);
            return response([
                'data' => $supplier
            ], 200);
        }
}
