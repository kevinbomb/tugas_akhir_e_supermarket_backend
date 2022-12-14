<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Http\Resources\DepartemenResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;



class SupplierController extends Controller
{
    /**
    * index
    *
    * @return void
    */
    
    public function index(){
        //get departemen
        $supplier = Supplier::latest()->get();
        //render view with posts
        return new DepartemenResource(true, 'List Data Supplier', $supplier);
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
            'nama_supplier' => 'required',
            'alamat_supplier' => 'required',
            'deskripsi' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //Fungsi Post ke Database
        $supplier = Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'alamat_supplier' => $request->alamat_supplier,
            'deskripsi' => $request->deskripsi
        ]);
            return new DepartemenResource(true, 'Data Supplier Berhasil Ditambahkan!', $supplier);
    
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrfail($id); //mencari data product berdasarkan id
        $supplier->delete();

        return new DepartemenResource(true, 'Data Supplier Dihapus', $supplier);        
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);

        // return view('departemen.edit', compact('departemen'));
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
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'nama_supplier' => 'required',
            'alamat_supplier' => 'required',
            'deskripsi' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

         //find departemen by ID
        $supplier = Supplier::find($id);

            //update post
               $supplier->nama_supplier = $request->get('nama_supplier');
               $supplier->alamat_supplier = $request->get('alamat_supplier');
               $supplier->deskripsi = $request->get('deskripsi');
               $supplier->save();
            return new DepartemenResource(true, 'Data Supplier Berhasil Diupdate!', $supplier);

    }

    public function show($id)
    {
        $supplier = Supplier::find($id);
        return response([
            'data' => $supplier
        ], 200);
    }
}
