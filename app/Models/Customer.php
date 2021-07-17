<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'updater_id',
        'name',
        'surname',
        'photo',
    ];

    public function creatorUser(){
        $this->belongsTo('App\Models\User', 'creator_id');
    }

    public function updaterUser(){
        $this->belongsTo('App\Models\User', 'updater_id');
    }
}
