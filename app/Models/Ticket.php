<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table='ticket';
    protected $primaryKey='ticket_id';
    protected $fillable=['user_id','session_id','hall_id','seat'];
    public $timestamps = false;
}
