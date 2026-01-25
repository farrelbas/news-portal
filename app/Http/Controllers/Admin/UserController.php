<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\UserModel;
use App\Models\Master\LevelModel;

class UserController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(Request $request)
    {
        $sortir = $request->sortir ?? 10;
        $search = $request->search;

        $data_user = UserModel::join('tb_level', 'tb_level.id_level', '=', 'tb_user.id_level')
            ->join('tb_user as u_inserted', 'u_inserted.id_user', '=', 'tb_user.user_inserted_by')
            ->where('tb_user.user_softdel', 0)
            ->select([
                'tb_user.*',
                'tb_level.level_name',
                'u_inserted.user_fullname as inserted_by_name',
            ]);

        if ($search) {
            $data_user->where(function ($q) use ($search) {
                $q->where('user_fullname', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_email', 'LIKE', "%{$search}%");
            });
        }

        $data_user = $data_user
            ->orderBy('tb_user.id_user', 'desc')
            ->paginate($sortir);

        return view('Admin.Master.user', [
            'title' => 'User',
            'data_user' => $data_user,
            'data_level' => LevelModel::where('level_softdel', 0)->get()
        ]);
    }

    public function store(Request $request)
    {
        if ($request->id_user) {

            $data = [
                'id_level' => $request->id_level,
                'user_fullname' => $request->user_fullname,
                'user_email' => $request->user_email,
                'username' => $request->username,
                'user_last_updated' => now(),
                'user_updated_by' => session('id_user'),
            ];

            if ($request->password) {
                $data['password'] = md5($request->password);
            }

            UserModel::where('id_user', $request->id_user)->update($data);

            return response()->json([
                'status'  => true,
                'message' => 'User updated successfully'
            ]);
        }

        UserModel::create([
            'id_level' => $request->id_level,
            'user_fullname' => $request->user_fullname,
            'user_email' => $request->user_email,
            'username' => $request->username,
            'password' => md5($request->password),
            'user_softdel' => 0,
            'user_inserted_at' => now(),
            'user_inserted_by' => session('id_user'),
            'user_last_updated' => now(),
            'user_updated_by' => session('id_user'),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'User added successfully'
        ]);
    }

    public function delete(Request $request)
    {
        UserModel::where('id_user', $request->id_user)->update([
            'user_softdel' => 1,
            'user_last_updated' => now(),
            'user_updated_by' => session('id_user'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
