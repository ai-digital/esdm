<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'slug', 'tanggal', 'isi', 'tags', 'kategori_id', 'gambar', 'user_id'];
    protected $casts = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(Categories::class, 'kategori_id', 'id');
    }
}
