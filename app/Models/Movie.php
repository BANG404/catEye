<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $table='movie';
    protected $primaryKey='movie_id';
    protected $fillable=['name','staring','detail','duration','score','type','picture','boxOffice','commentsCount','releaseDate','boxOfficeUnit','foreignName','releasePoint','commentsUnit'];
    public $timestamps = false;
    // protected $timestamps=false;
    // protected $guarded=[];
    public function getcomments(){
        return $this->hasMany('App\Models\Comments','movie_id','movie_id');
    }

}
