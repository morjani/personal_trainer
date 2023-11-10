<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function showProfile(int $id)
    {

        return DB::table('users')
            ->where('id',$id)
            ->first();

    }

    public function storeUser($data){

        return User::create($data);

    }

    public function updateUser($id,$data): int
    {

        return User::where('id',$id)
            ->update($data);

    }

    public static function profileByEmail(string $email,$id=null)
    {

        $query = DB::table('users')
            ->where('email','=',$email);

        if($id)
            $query->where('id','<>',$id);

        return$query->first();

    }
    public static function profileByName(string $name,$id=null)
    {

        $query = DB::table('users')
            ->where('name','=',$name);

        if($id)
            $query->where('id','<>',$id);

        return$query->first();

    }
}
