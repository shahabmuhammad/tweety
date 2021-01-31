<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    use HasFactory;


     protected $guarded=[];
    public function tweets(){
    	return $this->belongTo(Tweet::class);
    }




}
