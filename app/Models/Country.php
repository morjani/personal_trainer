<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Country extends Model
{
    protected $fillable = [
        'name',
        'deleted',
    ];
    use HasFactory;

    public static function listCountries(): Collection
    {

        return DB::table('countries')
            ->where('deleted',0)
            ->get();

    }
}
