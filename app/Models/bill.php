<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Collection;

class bill extends Model
{
    protected $fillable = [
        'number',
        'reference',
        'state',
        'type',
        'payment_method',
        'total_ht',
        'total_ttc',
        'tva',
        'date',
        'event_date',
        'descrpition',
        'customer_address',
        'user_id',
        'customer_id',
        'bill_id',
        'proforma_id',
        'deleted',
    ];

    use HasFactory;

    public static function stateCountBill(): Collection
    {

        return DB::table('bills')
            ->select(["state",DB::raw('COUNT(id) as total')])
            ->where('deleted','=',0)
            ->groupBy('state')
            ->get();

    }

    public static function storeBill($data){

        return bill::create($data);

    }

    public function updateBill($id,$data): int
    {

        return bill::where('id',$id)
            ->where('deleted',0)
            ->update($data);

    }

    public function deletedBill($id): int
    {

        return DB::table('bills')
            ->where('id','=',$id)
            ->where('deleted','=',0)
            ->update(['deleted'=>1]);

    }

    public static function lastBill()
    {

        return DB::table('bills')
            ->orderBy('id','DESC')
            ->first();

    }

    public static function showBill(int $id)
    {

        return DB::table('bills')
            ->where('id','=',$id)
            ->where('deleted',0)
            ->first();

    }

    public static function sumBillMonth(){

        return bill::where('deleted',0)
            ->where(DB::raw("(DATE_FORMAT(date,'%Y-%m'))"),'=',date('Y-m'))
            ->selectRaw("state,SUM(total_ttc) as total")
            ->groupBy('state')
            ->get();

    }

    public static function sumBill(){

        return bill::where('deleted',0)
            ->where(DB::raw("(DATE_FORMAT(date,'%Y'))"),'=',date('Y'))
            ->selectRaw("state,SUM(total_ttc) as total")
            ->groupBy('state')
            ->get();

    }

    public static function countBillMonth(){

        return bill::where('deleted',0)
            ->where(DB::raw("(YEAR(date))"),'=',date('Y'))
            ->selectRaw("MONTH(date) as mnth,state,COUNT(id) as count")
            ->groupBy('mnth')
            ->groupBy('state')
            ->get();

    }

}
