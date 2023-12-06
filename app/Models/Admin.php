<?php

namespace App\Models;

use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameAvatar(): string
    {
        if (auth()->user()['name']){
            $arr = explode(' ',auth()->user()['name']);
            switch (true){
                case sizeof($arr) >= 2:
                    $res = substr($arr[0], 0, 1).substr($arr[1], 0, 1);
                    break;
                default:
                    $res = substr(auth()->user()['name'], 0, 2);
            }
            return Str::upper($res);
        }else{
            return 'OO';
        }
    }

    public function sendPasswordResetNotification($token)
    {
        try {
            $this->notify(new AdminResetPasswordNotification($token, $this['email']));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }
}
