<?php

namespace App\Http\Controllers;

use App\Models\FollowUpMethod;
use App\Models\LeadSources;
use App\Models\LeadStatuses;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function leadstatues(){

        return response()->json([
            'status' => true,
            'message' => 'Lead Status Data Fetch Successfully',
            'data' => LeadStatuses::all(),
        ]);
       
    }

    public function leadstatusstore(Request $request){

       $request->validate([
            'lead_status' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        LeadStatuses::create([
            'lead_status' => $request->lead_status,
            'status' => $request->status,
            'type' => 'status',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Lead Status Created Successfully',
        ]);

    }

    public function leadstatusupdate(Request $request,$id){

        $data = LeadStatuses::findorFail($id);
        $data->update([
            'lead_status' => $request->lead_status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Lead Status Updated Successfully',
        ]);

    }

    public function leadstatusdelete($id){

        LeadStatuses::findorFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Lead Status Deleted Successfully',
        ]);

    }

    public function leadstatustoggle(Request $request,$id){

        $data = LeadStatuses::findOrFail($id);
        $data->status = $request->status;
        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Lead Status Updated Successfully'
        ]);

    }

    public function leadsource(){

        return response()->json([
            'status' => true,
            'message' => 'Lead Source Data Fetch Successfully',
            'data' => LeadSources::all(),
        ]);

    }

    public function leadsourcestore(Request $request){

        $request->validate([
            'source_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);;

        LeadSources::create([
            'source_name' => $request->source_name,
            'type' => 'source',
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Lead Source Added Successfully',
        ]);

    }

    public function leadsourceupdate(Request $request,$id){

        $data = LeadSources::findorFail($id);
        $data->update(['source_name' => $request->source_name]);

        return response()->json([
            'status' => true,
            'message' => 'Lead Source Updated Successfully',
        ]);

    }

    public function leadsourcedelete($id){

        LeadSources::findorFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Lead Source Deleted Successfully'
        ]);

    }

    public function leadsourcetoggle(Request $request,$id){

        $data = LeadSources::findorFail($id);
        $data->status = $request->status;
        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Lead Source Status Updated Successfully'
        ]);

    }

    public function leadfollowmethod(){

        return response()->json([
            'status' => true,
            'message' => 'Lead Follow Method Fetch Successfully',
            'data' => FollowUpMethod::all(),
        ]);

    }

    public function leadfollowmethodstore(Request $request){

        $request->validate([
            'method' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        FollowUpMethod::create([
            'method' => $request->method,
            'type' => 'method',
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Lead Follow Method Created Successfully'
        ]);

    }

    public function leadfollowmethodupdate(Request $request,$id){

        $data = FollowUpMethod::findorFail($id);
        $data->update(['method' => $request->method]);

        return response()->json([
            'status' => true,
            'message' => 'Lead Follow Method Update Successfully'
        ]);

    }

    public function leadfollowmethoddelete($id){

        FollowUpMethod::findorFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Lead Follow Method Deleted Successfully',
        ]);

    }

    public function leadfollowmethodtoggle(Request $request,$id){

        $data = FollowUpMethod::findorFail($id);
        $data->status = $request->status;
        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Lead Follow Method Updated Successfully',
        ]);

    }
    

}
