<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function allDrivers()
    {
        $drivers = Driver::with('user')->get();

        return response()->json([
            'status' => 'success',
            'total'  => count($drivers),
            'data'   => $drivers
        ]);

    }

    public function saveDriver(Request $request)
    {
        $getUser = DB::table('users')
                     ->select('id', 'full_name', 'contact_no', 'username')
                     ->where(['id' => $request->user_id])
                     ->first();

        try
        {
            $this->validate($request, [
                //'user_id'        => 'required',
                'driver_name'    => 'required',
                'driver_contact' => 'required'
            ]);

            $driver = new Driver();

            if(User::where('id', '=', $request->user_id)->exists())
            {
                $driver->user_id = $getUser->id;
            }
            else
            {
                return response()->json([
                    'status'  => 'Failed',
                    'success' => false,
                    'message' => 'User With The ID Of ' . '(' . $request->user_id .')' . ' Does Not Exist'
                ], 404);
            }

            $driver->driver_name = $request->driver_name;
            $driver->driver_contact = $request->driver_contact;
            $driver->save();

            return response()->json([
                'success' => true,
                'message' => 'Driver Was Saved Successfully!',
                'status'  => 'success',
                'data'    => $driver
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

    public function updateDriver(Request $request, $id)
    {
        try
        {
            if(Driver::where('id', '=', $id)->exists())
            {
                $updateDriver = Driver::findOrFail($id);

                if(User::where('id', '=', $request->user_id)->exists())
                {
                    $updateDriver->user_id = $request->id;
                }
                else
                {
                    return response()->json([
                        'status'  => 'Failed',
                        'success' => false,
                        'message' => 'User With The ID Of ' . '(' . $request->user_id .')' . ' Does Not Exist'
                    ], 404);
                }

                $updateDriver->driver_name = $request->driver_name;
                $updateDriver->driver_contact = $request->driver_contact;
                $updateDriver->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Driver Was Updated Successfully!',
                    'status'  => 'success',
                    'data'    => $updateDriver
                ], 200);
            }
            else
            {
                return response()->json([
                    'status'  => 'Failed',
                    'success' => false,
                    'message' => 'Driver With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
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

    public function deleteDriver($id)
    {
        if(Driver::where('id', '=', $id)->exists())
        {
            $deleteDriver = Driver::findOrFail($id);
            $deleteDriver->delete();

            return response()->json([
                'success' => true,
                'message' => 'Driver Was Deleted Successfully!',
                'status'  => 'success',
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Driver With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
            ], 404);
        }
    }
}
