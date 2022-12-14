<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    /**
    * fillable
    *
    * @var array
    */
    protected $fillable = [
        'nama_supplier',
        'alamat_supplier',
        'deskripsi',
    ]; 

    public function supplier()
    {
        return $this->hasMany(Barang::class);
    }
}
