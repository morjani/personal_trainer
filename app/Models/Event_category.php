<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Event_category extends Model
{
    protected $fillable = [
        'name',
        'class_name',
        'user_id',
        'deleted'
    ];
    use HasFactory;

    public static function listEventCategories(): Collection
    {

        return DB::table('event_categories')
            ->where('deleted','=',0)
            ->get();

    }

    public static function showEventCategory(int $id)
    {

        return DB::table('event_categories')
            ->where('id',$id)
            ->where('deleted',0)
            ->first();

    }

    public function updateEventCategory($id,$data): int
    {

        return Event_category::where('id',$id)
            ->where('deleted',0)
            ->update($data);

    }
}
