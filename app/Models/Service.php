<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'category_id',
        'deleted',
    ];
    use HasFactory;

    public function storeService($data){

        return Service::create($data);

    }

    public function updateService($id,$data): int
    {

        return Service::where('id',$id)
            ->where('deleted',0)
            ->update($data);

    }

    public static function showService(int $id)
    {

        return DB::table('services')
            ->where('id','=',$id)
            ->where('deleted','=',0)
            ->first();

    }

    public function deleteService($id): int
    {

        return DB::table('services')
            ->where('id',$id)
            ->where('deleted',0)
            ->update(['deleted'=>1]);

    }

    public static function searchServices($name): Collection
    {

        return DB::table('services')
            ->where('name','LIKE',"%".$name."%")
            ->where('deleted','=',0)
            ->get();

    }

}
