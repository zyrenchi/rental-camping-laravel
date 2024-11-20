<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model
    protected $table = 'rentals';

    // Kolom yang diizinkan untuk diisi (mass assignment)
    protected $fillable = [
        'customer_id',
        'equipment_id',
        'rental_date',
        'return_date',
        'quantity',
        'total_price',
        'status'
    ];

    // Relasi dengan model Customer
    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    // Relasi dengan model Equipment
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
