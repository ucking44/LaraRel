<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Schedule;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function allBookings()
    {
        $bookings = Booking::with('user', 'customer', 'schedule')->get();

        return response()->json([
            'status' => 'success',
            'total'  => count($bookings),
            'data'   => $bookings
        ]);
    }

    public function saveBooking(Request $request)
    {
        $this->validate($request, [
            'user_id'         => 'required',
            'customer_id'     => 'required',
            'schedule_id'     => 'required',
            'number_of_seats' => 'required',
            'fare_amount'     => 'required',
            'total_amount'    => 'required',
            'date_of_booking' => 'required',
        ]);

        try
        {
            $booking = new Booking();

            if(User::where('id', '=', $request->user_id)->exists())
            {
                $booking->user_id = $request->user_id;
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User With The ID Of ' . '(' . $request->user_id .')' . ' Does Not Exist'
                ], 404);
            }

            if(Customer::where('id', '=', $request->customer_id)->exists())
            {
                $booking->customer_id = $request->customer_id;
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Customer With The ID Of ' . '(' . $request->customer_id .')' . ' Does Not Exist'
                ], 404);
            }

            if(Schedule::where('id', '=', $request->schedule_id)->exists())
            {
                $booking->schedule_id = $request->schedule_id;
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Schedule With The ID Of ' . '(' . $request->schedule_id .')' . ' Does Not Exist'
                ], 404);
            }

            $booking->number_of_seats = (int)$request->number_of_seats;
            $booking->fare_amount = (int)$request->fare_amount;
            $booking->total_amount = (int)$request->total_amount;
            $booking->date_of_booking = $request->date_of_booking;
            $booking->booking_status = (int)$request->booking_status;
            $booking->save();

            return response()->json([
                'success' => true,
                'message' => 'Booking Was Saved Successfully!',
                'status'  => 'success',
                'data'    => $booking
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

    public function updateBooking(Request $request, $id)
    {
        try
        {
            if(Booking::where('id', '=', $id)->exists())
            {
                $booking = Booking::findOrFail($id);

                if(User::where('id', '=', $request->user_id)->exists())
                {
                    $booking->user_id = $request->user_id;
                }
                else
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'User With The ID Of ' . '(' . $request->user_id .')' . ' Does Not Exist'
                    ], 404);
                }

                if(Customer::where('id', '=', $request->customer_id)->exists())
                {
                    $booking->customer_id = $request->customer_id;
                }
                else
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Customer With The ID Of ' . '(' . $request->customer_id .')' . ' Does Not Exist'
                    ], 404);
                }

                if(Schedule::where('id', '=', $request->schedule_id)->exists())
                {
                    $booking->schedule_id = $request->schedule_id;
                }
                else
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Schedule With The ID Of ' . '(' . $request->schedule_id .')' . ' Does Not Exist'
                    ], 404);
                }

                $booking->number_of_seats = (int)$request->number_of_seats;
                $booking->fare_amount = (int)$request->fare_amount;
                $booking->total_amount = (int)$request->total_amount;
                $booking->date_of_booking = $request->date_of_booking;
                $booking->booking_status = (int)$request->booking_status;
                $booking->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Booking Was Updated Successfully!',
                    'status'  => 'success',
                    'data'    => $booking
                ], 201);
            }
            else
            {
                return response()->json([
                    'status'  => 'Failed',
                    'success' => false,
                    'message' => 'Booking With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
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

    public function deleteBooking($id)
    {
        if(Booking::where('id', '=', $id)->exists())
        {
            $deleteBooking = Booking::findOrFail($id);
            $deleteBooking->delete();

            return response()->json([
                'success' => true,
                'message' => 'Booking Was Deleted Successfully!',
                'status'  => 'success',
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Booking With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
            ], 404);
        }
    }
}
