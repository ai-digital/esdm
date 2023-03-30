<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'is_file', 'files', 'kategori', 'user_id'];
    protected $casts = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
