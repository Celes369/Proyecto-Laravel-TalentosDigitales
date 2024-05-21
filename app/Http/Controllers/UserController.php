<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\UserData;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserCreatedNotification;
use Illuminate\Support\Facades\Hash;




class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('userdata')->get();
        return view('user.list', compact('users')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        //$roles = Role::where('name', 'User')->get();
        //dd($roles);
        $user = new User();
    return view('user.create', compact('user','roles')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $validator = Validator::make($request->all(),[
                'first_name'  => 'required|between:1,100',
                'last_name'  => 'required|between:1,100',
                'email'  => 'required|between:1,64|email',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput();
            }


           $role = Role::where('id', $request->role)->first();
           $user = User::create([
            'name'       => $request->name,
            'username'       => $request->username,
            'email'       => $request->email,
            'password'       => Hash::make($request->password),
           ]);

           if ($request->file('avatar')) {
            $image = $request->file('avatar');
            $type = $image->getClientOriginalExtension();
            $img =date('Y-m-d-H-i-s') . '-id' . $user->id . '.' . $type;
            $image->move('user/', $img);

            $avatar_image = 'user/' .$img;
           }else{
            $avatar_image = '/dist/img/user2-160x160.jpg' .$img;
           }

           $userData = UserData::create([
            'user_id'          =>$user->id,
            'first_name'       =>$request->first_name,
            'last_name'        =>$request->last_name,
            'dni'              =>$request->dni,
            'avatar'           =>$avatar_image,
            'address'          =>$request->address,
            'mobile'           =>$request->mobile,
            'date_of_birth'    =>$request->date_of_birth,
        ]);

        if (!is_null($user && $userData)) {
            $user->assignRole($role->name);
            DB::commit();
           
            return redirect('user.idex');
        }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('user.create');
        }
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
    public function edit(User $user)
    {
     $user = User::where('id', $user->id)->with('userdata', 'roles')->first();
     $roles = Role::all();
     return view('user.edit', compact('user', 'roles'));  
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
     try {
        DB::beginTransaction();
        
        $validator = Validator::make($request->all(), [
            'first_name'  => 'required|between:1,100',
            'last_name'   => 'required|between:1,100',
             'email'       => 'required|between:1,64|email',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        
        // Solo actualiza la contraseña si se proporciona una nueva
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $userData = UserData::where('user_id', $id)->first();
        $userData->first_name = $request->first_name;
        $userData->last_name = $request->last_name;
        $userData->dni = $request->dni;
        $userData->address = $request->address;
        $userData->mobile = $request->mobile;
        $userData->date_of_birth = $request->date_of_birth;
        $userData->save();

        DB::commit();

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to update user');
    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
