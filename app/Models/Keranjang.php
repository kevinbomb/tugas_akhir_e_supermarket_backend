<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    /**
    * fillable
    *
    * @var array
    */
    protected $fillable = [
        'nama_barang',
        'jumlah',
        'harga',
        'user_id',
        'status',
    ]; 
}
