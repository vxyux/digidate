<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrManager extends Model
{
    use HasFactory;

    protected $table = 'qrmanager';

    protected $fillable = [
      'google2fa_enable',
      'google2fa_key'
    ];
}
