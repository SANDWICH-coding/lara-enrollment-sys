<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Parents;
use Illuminate\Support\Facades\Validator;

class ParentsController extends Controller
{
    public function loadParents()
    {
        // Eager load the related user (singular)
        $allParents = Parents::with('user')->get();
    
        // Pass the allParents data to the view
        return view('admin.manage-parents', compact('allParents'));
    }


    public function storeParentWithUsername(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'salutation' => 'required|string|max:10',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'dob' => 'required|date',
            'contactNo' => 'required|digits_between:7,15',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $parentData = $request->only([
            'salutation',
            'firstName',
            'lastName',
            'dob',
            'contactNo',
            'address',
        ]);
    
        // Store parent data
        $parent = Parents::create($parentData);
    
        // Store user account associated with the parent
        $parent->user()->create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Set success message
        session()->flash('success', 'Parent added successfully.');
    
        return response()->json([
            'success' => true,
            'message' => 'Parent and user account created successfully.',
            'data' => $parent,
        ]);
    }
}
