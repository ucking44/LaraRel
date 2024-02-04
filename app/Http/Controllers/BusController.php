<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Bus;
use App\Models\User;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function allBuses()
    {
        $buses = Bus::with('user')->get();

        return response()->json([
            'status' => 'success',
            'total'  => count($buses),
            'data'   => $buses
        ]);
    }

    public function saveBus(Request $request)
    {
        try
        {
            $this->validate($request, [
                'user_id' => 'required',
                'bus_number' => 'required',
                'bus_plate_number' => 'required',
                'bus_type' => 'required',
                'capacity' => 'required'
            ]);

            $bus = new Bus();

            if(User::where('id', '=', $request->user_id)->exists())
            {
                $bus->user_id = $request->user_id;
            }
            else
            {
                return response()->json([
                    'status'  => 'Failed',
                    'success' => false,
                    'message' => 'User With The ID Of ' . '(' . $request->user_id .')' . ' Does Not Exist'
                ], 404);
            }

            $bus->bus_number = $request->bus_number;
            $bus->bus_plate_number = $request->bus_plate_number;
            $bus->bus_type = $request->bus_type;
            $bus->capacity = $request->capacity;
            $bus->save();

            return response()->json([
                'success' => true,
                'message' => 'Bus Was Saved Successfully!',
                'status'  => 'success',
                'data'    => $bus
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

    public function updateBus(Request $request, $id)
    {
        try
        {
            if(Bus::where('id', '=', $id)->exists())
            {
                $updateBus = Bus::findOrFail($id);
                if(User::where('id', '=', $request->user_id)->exists())
                {
                    $updateBus->user_id = $request->user_id;
                }
                else
                {
                    return response()->json([
                        'status'  => 'Failed',
                        'success' => false,
                        'message' => 'User With The ID Of ' . '(' . $request->user_id .')' . ' Does Not Exist'
                    ], 404);
                }

                $updateBus->bus_number = $request->bus_number;
                $updateBus->bus_plate_number = $request->bus_plate_number;
                $updateBus->bus_type = $request->bus_type;
                $updateBus->capacity = $request->capacity;
                $updateBus->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Bus Was Updated Successfully!',
                    'status'  => 'success',
                    'data'    => $updateBus
                ], 200);
            }
            else
            {
                return response()->json([
                    'status'  => 'Failed',
                    'success' => false,
                    'message' => 'Bus With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
                ], 404);
            }
        }
        catch (Exception $exp)
        {
            return response([
                'status' => 'Failed',
                'message' => $exp->getMessage()
            ], 400);
        }
    }

    public function deleteBus($id)
    {
        if(Bus::where('id', '=', $id)->exists())
        {
            $deleteBus = Bus::findOrFail($id);
            $deleteBus->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bus Was Deleted Successfully!',
                'status'  => 'success',
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Bus With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
            ], 404);
        }
    }

    /////  LAZY LOADING

        // $buses = Bus::all();

        // foreach($buses as $bus)
        // {
        //     echo $bus->user->count();
        // }

}
