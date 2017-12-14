<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Runner extends Model
{
	/**
  * The attributes that are mass assignable.
  *
  * @var array
  */
 protected $fillable = [
     'country', 'lane', 'heat', 'secondLeg', 'firstLeg', 'name', 'year'
 ];



}
