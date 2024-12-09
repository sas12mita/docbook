<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the specialization.
     */
    public function index()
    {
        $specializations=Specialization::get();
        if($specializations)
        {
            return response()->json(['status'=>true,'data'=>$specializations]);
        }
        else
        {
            return response()->json(['status'=>false,'message'=>'No data found']);
        }
        
    }

    /**
     * Store a newly created specification in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name'=>'required|string|max:255',
        ]);
        $specilization= Specialization::create([
            'name'=>$request->name,
        ]);
        if($specilization)
        {
            return response()->json(['status'=>true,'message'=>'Specialization created successfully']);
        }
        else{
            return response()->json(['status'=>false,'message'=>'Failed to create Specialization']);
        }
    }

    public function show(string $id)
    {
        $specialization=Specialization::find($id);
        if($specialization)
        {
            return response()->json(['status'=>true,'data'=>$specialization]);
        }
        else
        {
            return response()->json(['status'=>false,'message'=>'No data found']);
        }
    }

   
    /**
     *   update specialization
     */
    public function update(Request $request, string $id)
    {      
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $specialization = Specialization::find($id);

        if (!$specialization) {
            return response()->json([
                'success' => false,
                'message' => 'Specialization not found',
            ], 404);
        }

        $specialization->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'specialization' => $specialization,
        ], 200);
    }

 /**
     *   destory particular specializatioon from storage
     */
    public function destroy(string $id)
    {
        
        $specialization=Specialization::find($id);
        if(!$specialization)
        {
            return response()->json(['status'=>true,'message'=>'no data found']);
        }
        $specialization->delete();
        return response()->json(['status'=>true,'message'=>'Specialization deleted successfully']);
        
    }
}
