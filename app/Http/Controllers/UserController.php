<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = DB::table('users')->get();
        return view('users.index', ['users' => $users]);
    }

    public function create(){
        return view('users.create');
    }

    public function store(StoreUserRequest $request){
        if ($request->passwd != $request->passwd2){
            $request->flash();
            return redirect('/users/create')->with('error', 'Passwords do not match!');
        }
        if (DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->passwd),
            'created_at' => now(),
        ])) {
            return redirect('/users')->with('success', 'User created successfully!');
        }
        else {
            return redirect('/users')->with('error', 'User not created!');
        }
    }

    public function show($id) {
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            return redirect('/users')->with('error', 'User not found!');
        }
        return view('users.show', ['user' => $user]);
    }

    public function destroy($id) {
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            return redirect('/users')->with('error', 'User not found!');
        }
        DB::table('users')->delete($id);
        return redirect('/users')->with('success', 'User deleted successfully!');
    }

    public function edit($id) {
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            return redirect('/users')->with('error', 'User not found!');
        }
        return view('users.edit', ['user' => $user]);
    }

    public function update(UpdateUserRequest $request, $id) {
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            return redirect('/users')->with('error', 'User not found!');
        }
        if (empty($request->passwd) and empty($request->passwd2)) {
            DB::table('users')->where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'updated_at' => now(),
            ]);
            return redirect('/users')->with('success', 'User updated successfully!');
        }
        elseif ($request->passwd != $request->passwd2) {
            $request->flash();
            return redirect("/users/$id/edit")->with('error', 'Passwords do not match!');
        }
        else {
            DB::table('users')->where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>  Hash::make($request->passwd),
                'updated_at' => now(),
            ]);
            return redirect('/users')->with('success', 'User updated successfully!');
        }
    }
}
