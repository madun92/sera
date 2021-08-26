<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model;
/**
 * Class User
 *
 * @package 
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 *
 * @OA\Schema(
 *     description="Pet model",
 *     title="Pet model",
 *     required={"name", "fillable"},
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class Post extends Model 
{
    protected $primaryKey = "_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * 
     *   @OA\Property(
     *     format="int64",
     *     description="ID",
     *     title="ID",
     * )
     *
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Getters
     */
    // public function getIdAttribute($value= null)
    // {
    //     // return $this->_id;
    //     return $this->attributes['_id'];
    // }
}
