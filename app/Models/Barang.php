<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'stok', 'harga', 'total_nilai'];
    protected $primaryKey = 'id_barang';
}
