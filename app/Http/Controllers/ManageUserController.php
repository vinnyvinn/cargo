<?php

namespace App\Http\Controllers;

use App\Department;
use App\Mail\UserCreated;
use App\Role;
use App\User;
use Esl\helpers\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ManageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manage-users.index')
            ->withUsers(User::with(['department'])->simplePaginate(25));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage-users.create')
            ->withRoles(Role::all()->sortBy('name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        Mail::to(['email'=>$data['email']])
            ->cc(['marvincollins114@gmail.com'])
            ->send(new UserCreated(['name'=>$data['name'],
                'password'=>$data['password'],
                'email'=>$data['email']]));

        $user->roles()->attach($data['role']);

        return redirect('/manage-users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('manage-users.edit')
            ->withUser(User::findOrFail($id))
            ->withDepartments(Department::all()->sortBy('name'))
            ->withRoles(Role::all()->sortBy('name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->all();
        $user = User::findOrFail($id);
        $user->update($data);

        Mail::to(['email'=>$data['email']])
            ->cc(['marvincollins114@gmail.com'])
            ->send(new UserCreated(['name'=>$data['name'],
                'password'=>$data['password'],
                'email'=>$data['email']]));

        $user->isRole(Role::findOrFail($data['role'])->slug) ?? $user->roles()->attach($data['role']);;

        return redirect('/manage-users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect('/manage-users');

    }

    public function createRole()
    {
        return view('manage-users.roles')
        ->withPermissions(Constants::PERMISSIONS);
    }

    public function storeRole(Request $request)
    {
        $permissions = array_map(function ($permission){
            return $permission = true;
        }, $request->permissions);

//        dd($request->permissions, $permissions);

        Role::create([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'permissions' => json_encode($permissions)
        ]);

        return view('manage-users.index-roles')
            ->withRoles(Role::all()->sortBy('name'));
    }

    public function roles()
    {
        return view('manage-users.index-roles')
           ->withRoles(Role::all()->sortBy('name'));
    }

    public function deleteRole($id)
    {
        Role::findOrFail($id)->delete();
        return view('manage-users.index-roles')
            ->withRoles(Role::all()->sortBy('name'));

    }
}
