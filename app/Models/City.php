<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class City extends Model
{
    protected $fillable = [
        'name',
        'deleted',
    ];
    use HasFactory;

    public static function listCities(): Collection
    {

        return DB::table('cities')
            ->where('deleted','=',0)
            ->get();

    }

    public static function searchCities($name): Collection
    {

        return DB::table('cities')
            ->where('name','LIKE',"%".$name."%")
            ->where('deleted','=',0)
            ->get();

    }

    public static function showCity($id): object
    {

        return DB::table('cities')
            ->where('id','=',$id)
            ->where('deleted','=',0)
            ->first();

    }
}
