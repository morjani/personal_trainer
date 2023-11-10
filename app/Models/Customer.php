<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'mobile',
        'fax',
        'email',
        'country_id',
        'city_id',
        'zip_code',
        'ice',
        'address',
        'prospect',
        'user_id',
        'deleted',
    ];
    use HasFactory;

    public function storeCustomer($data){

        return Customer::create($data);

    }

    public function updateCustomer($id,$data): int
    {

        return Customer::where('id',$id)
            ->where('deleted',0)
            ->update($data);

    }

    public static function showCustomer(int $id)
    {

        return DB::table('customers')
            ->where('id','=',$id)
            ->where('deleted','=',0)
            ->first();

    }

    public function deleteCustomer($id): int
    {

        return DB::table('customers')
            ->where('id','=',$id)
            ->where('deleted','=',0)
            ->update(['deleted'=>1]);

    }

    public static function searchCustomer($search) : Collection
    {
        return DB::table('customers')
            ->where('last_name','LIKE',"%".$search."%")
            ->where('deleted','=',0)
            ->get();
    }
}
