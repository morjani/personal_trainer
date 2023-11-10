<?php

namespace App\Models;

use Cron\AbstractField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Collection;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'deleted',
    ];
    use HasFactory;

    public function storeCategory($data){

        return Category::create($data);

    }

    public function updateCategory($id,$data): int
    {

        return Category::where('id',$id)
            ->where('deleted',0)
            ->update($data);

    }

    public function listCategories(): Collection
    {

        return DB::table('categories')
            ->where('deleted',0)
            ->get();

    }

    public function showCategory(int $id): object
    {

        return DB::table('categories')
            ->where('id',$id)
            ->where('deleted',0)
            ->first();

    }

    public function deleteCategory($id): int
    {

        return DB::table('categories')
            ->where('id',$id)
            ->where('deleted',0)
            ->update(['deleted'=>1]);

    }
}
