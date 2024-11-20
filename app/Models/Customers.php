<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    // Nama tabel yang sesuai, jika Laravel tidak mendeteksi nama tabel secara otomatis
    protected $table = 'customers';

    // Kolom yang diizinkan untuk diisi (mass assignment)
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address'
    ];
}
