<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class News extends Model
{
    public const ID = 'id';
    public const TIME = 'time';
    public const TITLE = 'title';
    public const TEXT = 'text';
    public const ID_USER = 'id_user';
        public const SENDED = 'sended';

    protected $fillable = [
        self::TIME,
        self::TITLE,
        self::TEXT,
        self::ID_USER,
        self::SENDED,
    ];

    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class, self::ID_USER);
    }
}