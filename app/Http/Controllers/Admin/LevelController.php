<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\LevelModel;

class LevelController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function level(Request $request)
    {
        $sortir = $request->sortir ?? 10;
        $search = $request->search;

        $data_level = LevelModel::join('tb_user', 'tb_user.id_user', '=', 'tb_level.level_updated_by')
            ->where('level_softdel', 0);

        if ($search) {
            $data_level->where('level_name', 'LIKE', "%{$search}%");
        }

        $data_level = $data_level
            ->orderBy('tb_level.id_level', 'desc')
            ->paginate($sortir);

        return view('Admin.Master.level', [
            'title' => 'Level',
            'data_level' => $data_level,
        ]);
    }
}
