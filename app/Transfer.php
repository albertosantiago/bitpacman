<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = ['ip', 'address','amount'];
}
