<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'image',
        'status'
    ];
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
