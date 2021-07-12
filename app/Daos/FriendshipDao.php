<?php


namespace App\Daos;


use Illuminate\Database\Eloquent\Model;

class FriendshipDao extends Model
{
    protected $table = 'friends';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public const PROPERTY_USER_ID = 'user_id';
    public const PROPERTY_FRIEND_ID = 'friend_id';
}
