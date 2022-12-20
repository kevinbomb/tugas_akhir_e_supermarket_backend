<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Http\Resources\DepartemenResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class BarangController extends Controller
{
     /**
    * index
    *
    * @return void
    */

    public function index(){
        //get posts
        $barang = Barang::with('barang')->get();;
        //render view with posts
        return new DepartemenResource(true, 'List Data Barang', $barang);

    }

    /**
    * create
    *
    * @return void
    */
    public function create()
    {
        $barang = Barang::all();

        return view('barang.create', compact('supplier'));
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
        'supplier_id' => 'required',
        'harga'=> 'required || gte:0',
        'in_stok'=> 'required',
        'expired' => 'required || date',
        'img' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //Fungsi Simpan Data ke dalam Database
        $barang = Barang::create([
        'nama_barang' => $request->nama_barang,
        'supplier_id' => $request->supplier_id,
        'harga'=> $request->harga,
        'in_stok'=> $request->in_stok,
        'expired' => $request->expired,
        'img' => $request->img
        ]);
        return new DepartemenResource(true, 'Data Barang Berhasil Ditambahkan!', $barang);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::findOrfail($id)->delete();

        return new DepartemenResource(true, 'Data Barang Dihapus', $barang); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $barang = Barang::find($id);
        $supplier = Supplier::all();

        //return view('proyek.edit', compact('proyek', 'departemen'));
        return view('barang.edit', compact('barang', 'supplier'));
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
            'nama_barang' => 'required',
            'supplier_id' => 'required',
            'harga'=> 'required || gte:0',
            'in_stok'=> 'required',
            'expired' => 'required || date',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

        $barang=Barang::find($id);
       
        $barang->nama_barang =  $request->get('nama_barang');
        $barang->supplier_id = $request->get('supplier_id');
        $barang->harga = $request->get('harga');
        $barang->in_stok = $request->get('in_stok');
        $barang->expired = $request->get('expired');
        $barang->img = $request->get('img');

        $barang->save();

        return new DepartemenResource(true, 'Data Barang Berhasil Diupdate!', $barang);
    }

    public function show($id)
    {
        $barang = Barang::find($id);
        return response([
            'data' => $barang
        ], 200);
    }
}
