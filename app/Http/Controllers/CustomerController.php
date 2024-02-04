<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    public function allCustomers()
    {
        $customers = Customer::with('user')->get();

        return response()->json([
            'status' => 'success',
            'total'  => count($customers),
            'data'   => $customers
        ]);

    }

    public function saveCustomer(Request $request)
    {
        $this->validate($request, [
            'user_id'          => 'required',
            'customer_name'    => 'required',
            'customer_contact' => 'required',
            'customer_email'   => 'required',
            'password'         => ['required', Password::min(6)]
        ]);

        try
        {
            $customer = new Customer();

            if(User::where('id', '=', $request->user_id)->exists())
            {
                $customer->user_id = $request->user_id;
            }
            else
            {
                return response()->json([
                    'status'  => 'Failed',
                    'success' => false,
                    'message' => 'User With The ID Of ' . '(' . $request->user_id .')' . ' Does Not Exist'
                ], 404);
            }

            $customer->customer_name = $request->customer_name;
            $customer->customer_contact = $request->customer_contact;
            $customer->customer_email = $request->customer_email;
            $customer->username = $request->username;
            $customer->password = $request->password;
            $customer->account_status = (int)$request->account_status;
            $customer->save();

            return response()->json([
                'success' => true,
                'message' => 'Customer Was Saved Successfully!',
                'status'  => 'success',
                'data'    => $customer
            ], 201);

        }
        catch(Exception $exp)
        {
            return response([
                'status' => 'failed',
                'message' => $exp->getMessage()
            ], 400);
        }

    }

    public function updateCustomer(Request $request, $id)
    {
        try
        {
            if(Customer::where('id', '=', $id)->exists())
            {
                $updateCustomer = Customer::findOrFail($id);

                if(User::where('id', '=', $request->user_id)->exists())
                {
                    $updateCustomer->user_id = $request->user_id;
                }
                else
                {
                    return response()->json([
                        'status'  => 'Failed',
                        'success' => false,
                        'message' => 'User With The ID Of ' . '(' . $request->user_id .')' . ' Does Not Exist'
                    ], 404);
                }

                $updateCustomer->customer_name = $request->customer_name;
                $updateCustomer->customer_contact = $request->customer_contact;
                $updateCustomer->customer_email = $request->customer_email;
                $updateCustomer->username = $request->username;
                $updateCustomer->password = $request->password;
                $updateCustomer->account_status = (int)$request->account_status;
                $updateCustomer->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Customer Was Updated Successfully!',
                    'status'  => 'success',
                    'data'    => $updateCustomer
                ], 201);
            }
            else
            {
                return response()->json([
                    'status'  => 'Failed',
                    'success' => false,
                    'message' => 'Customer With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
                ], 404);
            }

        }
        catch(Exception $exp)
        {
            return response([
                'status' => 'failed',
                'message' => $exp->getMessage()
            ], 400);
        }
    }

    public function deleteCustomer($id)
    {
        if(Customer::where('id', '=', $id)->exists())
        {
            $deleteCustomer = Customer::findOrFail($id);
            $deleteCustomer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Customer Was Deleted Successfully!',
                'status'  => 'success',
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Customer With The ID Of ' . '(' . $id .')' . ' Does Not Exist'
            ], 404);
        }
    }

}
