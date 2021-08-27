<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Post
 *
 * @package 
 *
 * @author  Wahid Hidayat <lamjoart@gmail.com>
 *
 * @OA\Schema(
 *     description="Post model",
 *     title="Post model",
 *     required={"name", "fillable"},
 *     @OA\Xml(
 *         name="Post"
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
