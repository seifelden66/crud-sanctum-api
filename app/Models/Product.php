<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'price','description','slug', 'user_id'
    ];
    public function user(){
            return $this->belongsTo(User::class)->withDefault(); // 1-n relationship
    }
}
