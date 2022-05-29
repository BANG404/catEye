<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $table='session';
    protected $primaryKey='session_id';
    protected $fillable=['hall_id','cinema_id','movie_id','date','startTime','price','remain'];
    public $timestamps = false;
}
