<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    protected $table = 'coupons'; // Bisa dihapus jika nama tabel mengikuti konvensi Laravel

    // Menentukan kolom yang dapat diisi
    protected $fillable = [
        'name',
        'type',
        'value',
        'status',
    ];
}
