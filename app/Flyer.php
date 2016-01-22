<?php

namespace App;
use App\Photo;

use Illuminate\Database\Eloquent\Model;

class Flyer extends Model
{

    protected  $fillable = [

        'street',
        'city',
        'state',
        'country',
        'description',
        'price',
        'zip'

    ];

    public static function  LocatedAt($zip, $street)
    {
        $street = str_replace('-', '',$street);
        return static:: where(compact('zip','street'))->first();
    }


    public  function addPhoto(Photo $photo)
    {
        return $this->photos()->save($photo);
    }


    public function getPriceAttribute($price)
    {
        return '$'.number_format($price);
    }


    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function ownedBy(User $user)
    {
        return $this->user_id == $user-> id;
    }
}
