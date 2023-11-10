<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date_start',
        'date_end',
        'class_name',
        'event_for',
        'bill_id',
        'user_id',
        'deleted'
    ];
    use HasFactory;

    public static function listEvents(): Collection
    {

        return DB::table('events')
            ->where('deleted','=',0)
            ->get();

    }

    public function storeEvent($data){

        return Event::create($data);

    }

    public function updateEvent($id,$data): int
    {

        return Event::where('id',$id)
            ->where('deleted',0)
            ->update($data);

    }

    public function deleteEvent($id): int
    {

        return DB::table('events')
            ->where('id',$id)
            ->where('deleted',0)
            ->update(['deleted'=>1]);

    }

    public static function showEvent(int $id)
    {

        return DB::table('events')
            ->where('id',$id)
            ->where('deleted',0)
            ->first();

    }

    public static function checkEventBill(string $event_for,int $bill_id)
    {

        return DB::table('events')
            ->where('event_for',$event_for)
            ->where('bill_id',$bill_id)
            ->where('deleted',0)
            ->first();

    }

    public static function deleteEventBill(string $event_for,int $bill_id): int
    {

        return DB::table('events')
            ->where('event_for',$event_for)
            ->where('bill_id',$bill_id)
            ->where('deleted',0)
            ->update(['deleted'=>1]);

    }

    public static function eventsForBill(): Collection
    {

        return DB::table('events')
//            ->where('event_for','=','bill')
            ->where('date_end','>',date('Y-m-d H:i:s'))
            ->where('deleted','=',0)
            ->orderBy('date_start')
            ->get();

    }
}
