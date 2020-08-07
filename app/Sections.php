<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    //
    protected $table = 'sections';
    protected $keyType = 'string';
    protected $primaryKey = 'slug';
    

    public function sousSections() {
        return $this->hasMany('App\SousSections','id_section','slug')->get();
    }
}
