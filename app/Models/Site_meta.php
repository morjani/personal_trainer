<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Site_meta extends Model
{
    protected $fillable = [
        'name',
        'value',
        'deleted',
    ];

    use HasFactory;

    public static function allMetas(): Collection
    {

        return DB::table('site_metas')
            ->where('deleted','=',0)
            ->get();

    }

    public static function updateSiteMeta($name,$data): int
    {

        return Site_meta::where('name',$name)
            ->where('deleted',0)
            ->update($data);

    }

    public static function metaByName(string $name)
    {

        return DB::table('site_metas')
            ->where('name','=',$name)
            ->where('deleted','=',0)
            ->first();

    }
}
