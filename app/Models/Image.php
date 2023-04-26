<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Image extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'image',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'images_id','id');
    }
}
