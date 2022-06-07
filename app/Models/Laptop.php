<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    protected $table = 'laptop';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
}
