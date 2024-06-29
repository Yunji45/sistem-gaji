<?php

namespace App\Http\Controllers\Creator;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CreatorController extends Controller
{
    public function index()
    {
        $title = 'Create User';
        $data['data'] = User::with('roles','permissions')->get();
        // $data = User::with('roles')->get()->take(2);
        $data['trashed'] = [];
        if(!is_null(User::onlyTrashed()->get())){
            $data['trashed'] = User::onlyTrashed()->get();
        }
        // return response()->json([
        // 'data' => $data
        // ]);
        return view('Creator.create',compact('title','data'));
    }
    public function create(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $hak_akses = $request->hak_akses;
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ])->assignRole($hak_akses);
        return redirect()->back()->with('success','Berhasil tambahkan akun!');
        // return response()->json([
        //     'data' => $request->all()
        // ]);
    }
    public function view($id)
    {
        $data = User::where('id',$id)->first();
        $title = 'Edit User';
        return view('Creator.view',compact('data','title'));
    }
    public function delete($id)
    {
        User::where('id',$id)->delete();
        return redirect()->back()->with('success','Sukses menghapus!');
    }
    public function restore($id)
    {
        User::where('id',$id)->restore();
        return redirect()->back()->with('success','Sukses mengembalikan!');
    }
    public function edit(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $hak_akses = $request->hak_akses;
        User::where('id',$request->id)
        ->update([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
        User::where('id',$request->id)->first()->syncRoles($hak_akses);
        return redirect()->to('create_user')->with('success','Berhasil update akun!');
    }
}
