<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class Attachement extends Model
{
    protected $fillable = [
        'user_id',
        'relation_id',
        'relation_text',
        'name',
        'type',
        'mime_type',
        'link',
        'attachement_deleted',
    ];
    use HasFactory;

    public static function storeAttachement($data)
    {

        return Attachement::create($data);

    }

    public static function showAttachement($id)
    {

        return DB::table('attachements')
            ->where('id',$id)
            ->where('deleted',0)
            ->first();

    }

    public static function getAttachementByTable($table,$id)
    {

        return DB::table('attachements')
            ->where('relation_text',$table)
            ->where('relation_id',$id)
            ->where('deleted',0)
            ->first();

    }

    public static function updateAttachement($id,$data): int
    {

        return DB::table('attachements')
            ->where('id','=',$id)
            ->where('deleted','=',0)
            ->update($data);

    }

    public function removeAttachement($id): int
    {

        return DB::table('attachements')
            ->where('id',$id)
            ->where('deleted',0)
            ->update(['deleted'=>1]);

    }
}
