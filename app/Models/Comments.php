<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $table='comments';
    protected $primaryKey='comments_id';
    protected $fillable=['movie_id','user_id','comments'];
    public $timestamps = false;
    public function getmovie(){
        return $this->belongsTo('App\Models\Movie','movie_id','movie_id');
    }
}
