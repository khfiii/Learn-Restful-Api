<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Form extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug','allowed_domains', 'description', 'limit_one_response', 'user_id']; 

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts()
    {
       return [
        'allowed_domains'=> 'array'
       ];  
    }


}
