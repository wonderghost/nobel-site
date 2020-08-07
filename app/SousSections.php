<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SousSections extends Model
{
    //
    protected $table = 'sous_sections';
    protected $keyType = 'string';
    protected $primaryKey = 'slug';
}
