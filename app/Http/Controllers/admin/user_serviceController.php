<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Controllers\Tools;
use Illuminate\Database\QueryException;

class user_serviceController extends Controller
{

    //
    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    // Create User -- Type User //

    public function nouvelUser(Request $request)
    {
      try {
        $validator = Validator::make($request->all(), [
  
            'name' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
    
            return response()->json(['message' => 'Veuillez corriger les erreurs suivantes :', 'errors' => $validator->errors()], 400);

        }  else {
                if ($request->input('password') !== null && $request->input('password') !== '') {
                    $password = $this->tools->crypterChaine($this->tools->controle_space($request->input('password')));
                } else {
                    $password = $this->tools->crypterChaine('Compta2024');
                }
                if ($request->input('type') !== null && $request->input('type') !== '') {
                    $type = $this->tools->$request->input('type');
                } else {
                    $type = 'user';
                }
          
            $nb = DB::table('users')->count();
            $nb++;
            $nb = $nb++;
            $user = new user();
            $user->name =  $this->tools->controle_space($request->input('name'));
            $user->email = $this->tools->controle_space($request->input('email'));
            $user->type = $type;
            $user->password  = $password;
            $user->save();
        }
        return redirect()->back()
          ->with('success', 'You have successfully add user.');

        } catch (QueryException $e) {

            return response()->json($e->getMessage());
        }
      
    }

    public function update(Request $request, string $id)
    {
        //

        try {
            $user = DB::table('users')
                ->where('id', $id)
                ->first();

            if ($user) {
                DB::table('users')
                    ->where('id', $id)
                    ->update(array(
                        'name' => $request->input('name') !== null ? $this->tools->controle_space($request->input('name')) : $user->name,
                        'email' => $request->input('email') !== null ? $this->tools->controle_space($request->input('email')) : $user->email,
                        'password' => $request->input('password') !== null ? $this->tools->crypterChaine($this->tools->controle_space($request->input('password'))) : $user->password,
                        'type' => $request->input('type') !== null ? $this->tools->controle_space($request->input('type')) : $user->type,
                        'updated_at' => $this->tools->HeureLocale(),
                    ));
                $user = DB::table('users')
                    ->where('id', $id)
                    ->first();
                    return redirect()->back()->with('success', 'You have successfully update user.');
            }
            return response()->json(['message' => 'User not found'], 404);
        } catch (QueryException $e) {

            return response()->json($e->getMessage());
        }
    }

    public function destroy(string $id)
    {

        try {
            $user = DB::table('users')
                ->where('id', $id)
                ->first();
            if ($user) {
                $user = DB::table('users')
                    ->where('id', $id)
                    ->delete();
                    return redirect()->back()->with('success', 'You have successfully update user.');
            }
            return response()->json(['message' => 'user not found'], 404);
        } catch (QueryException $e) {

            return response()->json($e->getMessage());
        }
    }



    
}
