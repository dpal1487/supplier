<?php

namespace App\Http\Controllers\Panel;

use App\Models\Support;
use App\Models\SupportProblem;
use Illuminate\Http\Request;
use Validator;
use DB;
use Redirect;
use Auth;
use App\Http\Resources\Panel\SupportTicketResource;
use App\Models\SupportTicket;
use Illuminate\Http\Response;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user =  Auth::user();
        $support_problems = SupportProblem::all();
        $tickets = SupportTicket::where(['user_id' => $user->id, 'status' => 0])->paginate(10);
        $close_tickets = SupportTicket::where(['user_id' => $user->id, 'status' => 1])->get();

        if (count($tickets) > 0) {
            return SupportTicketResource::collection($tickets)->additional(['supportProblems' => $support_problems, 'close_tickets' => $close_tickets, 'success' => true]);
        } else {
            return response()->json(['data' => null, 'supportProblems' => $support_problems, 'meta' => null, 'success' => false]);
        }
    }

    public function store(Request $request)
    {
        //return $request->all();
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'due_date' => 'required',
            'problem' => 'required',
            'priority' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        } else {
            try {
                $ticket = SupportTicket::create([
                    'user_id' => $user->id,
                    'subject' => $request->subject,
                    'priority' => $request->priority,
                    'problem' => $request->problem,
                    'due_date' => $request->due_date,
                    'description' => $request->description,
                ]);
                if ($ticket->save()) {
                    return response()->json(['success' => true, 'message' => createMessage('Ticket')], Response::HTTP_OK);
                }
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function show(Support $support)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function edit(Support $support)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Support $support)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function destroy(Support $support)
    {
        //
    }
    /*public function getAddTicket()
    {
        return view('backend/addticket');
    }

    public function AddTicket(Request $request){
        $user =  Auth::user();
        $validator = Validator::make($request->all(), [
            'problem' => 'required',
            'priority' => 'required',
            'project' => '',
            'description'=> 'required',
            ]);

        if($validator->fails()){
            return Redirect::to('addticket')->withErrors($validator);
        } else {
            $user_id = $user->id;
            $problem =  $request->problem;
            $priority =  $request->priority;
            $project =  $request->project;
            $description =  $request->description;
            $result = DB::table('support_tickets')->insert([
            'user_id' => $user_id,
            'problem' => $problem,
            'priority' => $priority,
            'project' => $project,
            'description' => $description,
            'status' => '0',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
            ]);

            if($result){
                return response()->json(['message'=>'Ticket Created Successfully!','success'=>true]);
            }

        }
    }
    public function getEditTicket($id)
    {
        $tickets = Support_ticket::where('id',$id)->first();
        return response()->json(['tickets'=>$tickets,'success'=>true]);
    }
    public function updateTicket(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'problem' => 'required',
            'priority' => 'required',
            'project' => '',
            'description'=> 'required',
            ]);

        if($validator->fails()){
            return Redirect::to('editticket')->withErrors($validator);
        } else {
            $problem =  $request->problem;
            $priority =  $request->priority;
            $project =  $request->project;
            $description =  $request->description;
            $result = Support_ticket::where('id',$id)->update([
            'user_id' => Auth::user()->id,
            'problem' => $problem,
            'priority' => $priority,
            'project' => $project,
            'description' => $description,
            'updated_at' => date('Y-m-d H:i:s')
            ]);

            if($result){
                return response()->json(['message'=>'Ticket Updated Successfully!','success'=>true]);
            }

        }
    }*/
}
