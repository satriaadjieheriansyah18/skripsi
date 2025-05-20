<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'nama', 'no_telp', 'alamat', 'maps_link',
        'qty', 'total', 'status', 'product' , 'user_id', 'bukti_transfer'
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
