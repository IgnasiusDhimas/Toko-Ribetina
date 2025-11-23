<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'kode_transaksi',
        'tanggal',
        'total'
    ];

    public function items()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}
