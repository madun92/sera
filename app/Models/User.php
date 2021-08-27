<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Jenssegers\Mongodb\Auth\User as Model;
use Jenssegers\Mongodb\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
/**
 * Class User
 *
 * @package 
 *
 * @author  Wahid Hidayat <lamjoart@gmail.com>
 *
 * @OA\Schema(
 *     description="User model",
 *     title="User model",
 *     required={"name", "fillable"},
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract,JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * 
     *   @OA\Property(
     *     format="int64",
     *     description="ID",
     *     title="ID",
     * )
     *
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    // protected $connection = 'mongodb';

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /** 
     * Relations
     */

     public function posts()
     {
         return $this->hasMany(Post::class);
     }
}
