<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Bill_detail extends Model
{
    protected $fillable = [
        'bill_id',
        'service_id',
        'price',
        'quantity',
        'total',
        'with_tva',
        'description',
        'user_id',
        'deleted',
    ];
    use HasFactory;

    public function storeBillDetail($data){

        return Bill_detail::create($data);

    }

    public static function listBillDetails($bill_id,$with_tva=null): Collection
    {

        $query = DB::table('bill_details');
        $query->where('bill_id','=',$bill_id);

        if(!is_null($with_tva))
            $query->where('with_tva','=',$with_tva);

        $query->where('deleted','=',0);

        return $query->get();


    }

    public static function deleteDetailByBill($bill_id): int
    {

        return Bill_detail::where('bill_id',$bill_id)
            ->where('deleted',0)
            ->update(['deleted'=>1]);

    }

}
