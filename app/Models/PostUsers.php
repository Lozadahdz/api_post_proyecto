<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostUsers extends Model
{
    use HasFactory;
    protected $table = 'post_users';
    protected $fillable = [
        'id_user',
        'tittle',
        'description',
        'status',
        'created_at',
    ];

    // MUTTATORS
    public function getFromDateAttribute()
    {
        if( $this->created_at->diffInDays() > 30 ) {
            return $this->created_at->format('Y-m-d');
        } else {
            return $this->created_at->diffForHumans();
        }
    }
}
