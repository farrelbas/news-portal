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

    public function index(Request $request)
    {
        $sortir = $request->sortir ?? 10;
        $search = $request->search;

        $data_level = LevelModel::join('tb_user', 'tb_user.id_user', '=', 'tb_level.level_updated_by')
            ->select([
                'tb_level.*',
                'tb_user.user_fullname'
            ])
            ->where('tb_level.level_softdel', 0);

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

    public function store(Request $request)
    {
        if ($request->id_level) {

            LevelModel::where('id_level', $request->id_level)
                ->where('level_softdel', 0)
                ->update([
                    'level_name' => $request->level_name,
                    'level_last_updated' => now(),
                    'level_updated_by' => session('id_user'),
                ]);

            return response()->json([
                'status' => true,
                'message' => 'Level updated successfully'
            ]);
        }

        LevelModel::create([
            'level_name' => $request->level_name,
            'level_softdel' => 0,
            'level_inserted_at' => now(),
            'level_inserted_by' => session('id_user'),
            'level_last_updated' => now(),
            'level_updated_by' => session('id_user'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Level added successfully'
        ]);
    }

    public function delete(Request $request)
    {
        LevelModel::where('id_level', $request->id_level)->update([
            'level_softdel'      => 1,
            'level_last_updated' => date('Y-m-d H:i:s'),
            'level_updated_by'   => session('id_user'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Level deleted successfully'
        ]);
    }
}
