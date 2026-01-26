<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = [
        'id_level',
        'user_fullname',
        'user_email',
        'username',
        'password',
        'user_softdel',
        'user_inserted_at',
        'user_inserted_by',
        'user_last_updated',
        'user_updated_by',
    ];

    protected $hidden = [
        'password',
    ];

    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'id_level', 'id_level');
    }
}
