<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;
    protected $table='hall';
    protected $primaryKey='hall_id';
    protected $fillable=['name','cinema_id','capacity'];
    public $timestamps = false;
    public function getcinema(){
        return $this->belongsTo('App\Models\Cinema','cinema_id','cinema_id');
    }
}
