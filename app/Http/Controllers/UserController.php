<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();                
        return view('setting.account', ['user' => $user]);
    }
   
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // validate
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',                     
        ]);

        $user = User::where('id', $id)->first();
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');            
        $user->save();
        
        return redirect()->route('account')
            ->with('success', 'User Successfully Updated');
    }
    
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $password = $request->get('password');
        if(Hash::check($request->password, $user->password)) {
            $user->delete();
            return redirect()->route('home')
                ->with('success', 'User Successfully Deleted');
        } else {
            return redirect()->route('account');
        }        
    }
    
    public function changePassword() {
        $user = Auth::user();  
        return view('setting.changePassword', ['user' => $user]);
    }
}
