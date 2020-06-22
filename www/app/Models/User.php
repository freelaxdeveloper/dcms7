<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Capsule\Manager as DB;

class User extends Model
{
    protected $appends = [
        'nick',
        'icon',
    ];

    function getIconAttribute()
    {
        $is_ban = DB::table('ban')
            ->where('id_user', $this->attributes['id'])
            ->where('time_start', '<', TIME)
            ->where(function (Builder $query) {
                $query->where('time_end', '>', TIME);
                $query->orWhereNull('time_end');
            })->count();


        // система
        if ($this->attributes['group'] === 6 && $this->attributes['id'] === 0) {
            return 'system';
        }
        // забаненый пользователь
        if ($is_ban) {
            return 'shit';
        }
        // администратор
        if ($this->attributes['group'] >= 2) {
            return 'admin.' . $this->attributes['sex'];
        }
        // пользователь
        if ($this->attributes['group']) {
            if ($this->attributes['vk_id'])
                return 'user.vk';
            return 'user.' . $this->attributes['sex'];
        }
        // гость
        return 'guest';
    }

    public function getNickAttribute()
    {
        if ($this->attributes['vk_id']){
            $login = $this->attributes['vk_first_name'].' '.$this->attributes['vk_last_name'];
        }else{
            $login = $this->attributes['login'];
        }

        $online = DB::table('users_online')->where('id_user', $this->attributes['id'])->count();

        $ret = array('<span class="' . ($online ? 'DCMS_nick_on' : 'DCMS_nick_off') . '">' . $login . '</span>');

        if ($this->attributes['donate_rub'])
            $ret[] = '<span class="DCMS_nick_donate"></span>';

        if ($this->attributes['ank_m_r'] && $this->attributes['ank_d_r']){
            $today_date = date('m-d', mktime(0, 0, 0, date("m"), date("d"), 0));
            $birthday_date = date('m-d', mktime(0, 0, 0, $this->attributes['ank_m_r'], $this->attributes['ank_d_r'], 0));
            if ($today_date == $birthday_date)
                $ret[] = '<span class="DCMS_nick_birthday"></span>';
        }

        return join('', $ret);
    }
}