<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo; 


class Product extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai konvensi
    protected $table = 'products';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'nama',
        'image',
        'hargabeli',
        'hargajual',
        'category_id',
    ];

    // Relasi belongsTo dengan Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}