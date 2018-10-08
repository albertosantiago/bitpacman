<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraAward extends Model
{
    protected $fillable = ['ip', 'address','amount'];
}
