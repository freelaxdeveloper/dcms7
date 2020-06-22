<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ChatMini extends Model
{
    protected $table = 'chat_mini';

    public const ID = 'id';
    public const ID_USER = 'id_user';
    public const TIME = 'time';
    public const MESSAGE = 'message';

    protected $fillable = [
        self::ID_USER,
        self::TIME,
        self::MESSAGE,
    ];

    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class, self::ID_USER);
    }
}