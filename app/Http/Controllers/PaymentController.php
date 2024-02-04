<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function allPayments()
    {
        $payments = Payment::with('user', 'booking')->get();

        return response()->json([
            'staus' => true,
            'total' => count($payments),
            'data'  => $payments
        ]);
    }

    public function savePayment(Request $request)
    {
        $this->validate($request, [
            'user_id'      => 'required',
            'booking_id'   => 'required',
            'amount_paid'  => 'required',
            'payment_date' => 'required'
        ]);

        try
        {
            $payment = new Payment();
            $payment->user_id = $request->user_id;
            $payment->booking_id = $request->booking_id;
            $payment->amount_paid = (int)$request->amount_paid;
            $payment->payment_date = $request->payment_date;
            $payment->save();

            return response()->json([
                'success' => true,
                'message' => 'Payment Was Saved Successfully!',
                'data'    => $payment
            ], 201);

        }
        catch (Exception $exp)
        {
            return response([
                'status'  => 'Failed',
                'message' => $exp->getMessage()
            ], 400);
        }
    }

    public function updatePayment(Request $request, $id)
    {
        try
        {
            if(Payment::where('id', '=', $id)->exists())
            {
                $updatePayment = Payment::findOrFail($id);
                $updatePayment->user_id = $request->user_id;
                $updatePayment->booking_id = $request->booking_id;
                $updatePayment->amount_paid = (int)$request->amount_paid;
                $updatePayment->payment_date = $request->payment_date;
                $updatePayment->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Payment Was Updated Successfully!',
                    'data'    => $updatePayment
                ], 201);
            }
            else
            {
                return response()->json([
                    'status'  => 'Failed',
                    'success' => false,
                    'message' => 'Payment With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
                ], 404);
            }

        }
        catch (Exception $exp)
        {
            return response([
                'status'  => 'Failed',
                'message' => $exp->getMessage()
            ], 400);
        }
    }

    public function deletePayment($id)
    {
        if(Payment::where('id', '=', $id)->exists())
        {
            $deletePayment = Payment::findOrFail($id);
            $deletePayment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Payment Was Deleted Successfully!',
                'status'  => 'success',
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Payment With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
            ], 404);
        }
    }
}
