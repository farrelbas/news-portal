<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\UserModel;

class LevelModel extends Model
{
    protected $table = 'tb_level';
    protected $primaryKey = 'id_level';
    public $timestamps = false;

    protected $fillable = [
        'level_name',
        'level_softdel',
        'level_inserted_at',
        'level_inserted_by',
        'level_last_updated',
        'level_updated_by',
    ];
}
