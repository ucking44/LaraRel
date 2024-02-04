<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function allUsers()
    {
        $users = User::all();

        return response()->json([
            'status' => 'success',
            'total'  => count($users),
            'data'   => $users
        ]);
    }

    public function saveUser(Request $request)
    {
        //dd($request);
        $this->validate($request, [
            'full_name'     => 'required',
            'contact_no'    => 'required',
            'username'      => 'required',
            'email_address' => 'required',
            'userpassword'  => ['required', Password::min(6)]
        ]);

        try
        {
            $user = new User();
            $user->full_name = $request->full_name;
            $user->contact_no = $request->contact_no;
            $user->username = $request->username;
            $user->email_address = $request->email_address;
            $user->userpassword = $request->userpassword;
            $user->account_category = (int)$request->account_category;
            $user->account_status = (int)$request->account_status;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User Was Saved Successfully!',
                'status'  => 'success',
                'data'    => $user
            ], 201);
        }
        catch (Exception $e)
        {
            return response([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);

        }

    }

    public function updateUser(Request $request, $id)
    {
        try
        {
            if(User::where('id', '=', $id)->exists())
            {
                $userUpdate = User::findOrFail($id);
                $userUpdate->full_name = $request->full_name;
                $userUpdate->contact_no = $request->contact_no;
                $userUpdate->username = $request->username;
                $userUpdate->email_address = $request->email_address;
                $userUpdate->userpassword = $request->userpassword;
                $userUpdate->account_category = (int)$request->account_category;
                $userUpdate->account_status = (int)$request->account_status;
                $userUpdate->save();

                return response()->json([
                    'success' => true,
                    'message' => 'User Was Updated Successfully!',
                    'status'  => 'success',
                    'data'    => $userUpdate
                ], 201);
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
                ], 404);
            }
        }
        catch (Exception $e)
        {
            return response([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);

        }
    }

    public function deleteUser($id)
    {
        if(User::where('id', '=', $id)->exists())
        {
            $deleteUser = User::findOrFail($id);
            $deleteUser->delete();

            return response()->json([
                'success' => true,
                'message' => 'User Was Deleted Successfully!',
                'status'  => 'success',
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'User With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
            ], 404);
        }
    }
}
