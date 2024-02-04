<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Bus;
use App\Models\User;
use App\Models\Driver;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function allSchedules()
    {
        $schedules = Schedule::with('user', 'bus', 'driver')->get();

        return response()->json([
            'status' => 'success',
            'total'  => count($schedules),
            'data'   => $schedules
        ]);
    }

    public function saveSchedule(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'bus_id' => 'required',
            'driver_id' => 'required',
            'starting_point' => 'required',
            'destination' => 'required',
            'schedule_date' => 'required',
            'departure_time' => 'required',
            'fare_amount' => 'required'
        ]);

        try
        {
            $schedule = new Schedule();

            if(User::where('id', '=', $request->user_id)->exists())
            {
                $schedule->user_id = $request->user_id;
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User With The ID Of ' . '(' . $request->user_id .')' . ' Does Not Exist'
                ], 404);
            }

            if(Bus::where('id', '=', $request->bus_id)->exists())
            {
                $schedule->bus_id = $request->bus_id;
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Bus With The ID Of ' . '(' . $request->bus_id .')' . ' Does Not Exist'
                ], 404);
            }

            if(Driver::where('id', '=', $request->driver_id)->exists())
            {
                $schedule->driver_id = $request->driver_id;
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Driver With The ID Of ' . '(' . $request->driver_id .')' . ' Does Not Exist'
                ], 404);
            }

            $schedule->starting_point = $request->starting_point;
            $schedule->destination = $request->destination;
            $schedule->schedule_date = $request->schedule_date;
            $schedule->departure_time = $request->departure_time;
            $schedule->estimated_arrival_time = $request->estimated_arrival_time;
            $schedule->fare_amount = (int)$request->fare_amount;
            $schedule->remarks = $request->remarks;
            $schedule->save();

            return response()->json([
                'success' => true,
                'message' => 'Schedule Was Saved Successfully!',
                'status'  => 'success',
                'data'    => $schedule
            ], 201);

            //toTimeString();

        }
        catch (Exception $e)
        {
            return response([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);

        }
    }

    public function updateSchedule(Request $request, $id)
    {
        try
        {
            if(Schedule::where('id', '=', $id)->exists())
            {
                $updateSchedule = Schedule::findOrFail($id);

                if(User::where('id', '=', $request->user_id)->exists())
                {
                    $updateSchedule->user_id = $request->user_id;
                }
                else
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'User With The ID Of ' . '(' . $request->user_id .')' . ' Does Not Exist'
                    ], 404);
                }

                if(Bus::where('id', '=', $request->bus_id)->exists())
                {
                    $updateSchedule->bus_id = $request->bus_id;
                }
                else
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Bus With The ID Of ' . '(' . $request->bus_id .')' . ' Does Not Exist'
                    ], 404);
                }

                if(Driver::where('id', '=', $request->driver_id)->exists())
                {
                    $updateSchedule->driver_id = $request->driver_id;
                }
                else
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Driver With The ID Of ' . '(' . $request->driver_id .')' . ' Does Not Exist'
                    ], 404);
                }

                $updateSchedule->starting_point = $request->starting_point;
                $updateSchedule->destination = $request->destination;
                $updateSchedule->schedule_date = $request->schedule_date;
                $updateSchedule->departure_time = $request->departure_time;
                $updateSchedule->estimated_arrival_time = $request->estimated_arrival_time;
                $updateSchedule->fare_amount = (int)$request->fare_amount;
                $updateSchedule->remarks = $request->remarks;
                $updateSchedule->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Schedule Was Updated Successfully!',
                    'status'  => 'success',
                    'data'    => $updateSchedule
                ], 201);

                //toTimeString();
            }
            else
            {
                return response()->json([
                    'status'  => 'Failed',
                    'success' => false,
                    'message' => 'Schedule With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
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

    public function deleteSchedule($id)
    {
        if(Schedule::where('id', '=', $id)->exists())
        {
            $deleteSchedule = Schedule::findOrFail($id);
            $deleteSchedule->delete();

            return response()->json([
                'success' => true,
                'message' => 'Schedule Was Deleted Successfully!',
                'status'  => 'success',
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Schedule With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
            ], 404);
        }
    }
}
