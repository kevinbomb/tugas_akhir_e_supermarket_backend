<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    /**
    * fillable
    *
    * @var array
    */

    protected $fillable = [
        'nama_barang',
        'supplier_id',
        'harga',
        'in_stok',
        'expired',
        'img',
    ]; 

    public function barang()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
}
