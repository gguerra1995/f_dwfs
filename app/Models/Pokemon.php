<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $fillable = [
        "photo",
        "name",
        "ps",
        "atq",
        "df",
        "atq_spl",
        "df_spl",
        "spl",
        "vel",
        "acc",
        "evs"
    ];

    protected $table = "pokemon";
}

/**
 * 
 * 
 */
