<?php

namespace App\Http\Controllers;

use App\Models\Mypoint;
use Illuminate\Http\Request;
use App\Models\Reward;
use Auth;

class MypointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $rewards = Reward::where('user_id',Auth::user()->id)->get();
         $reward_counts = $rewards->where('user_id', Auth::user()->id);
         return response()->json(['rewards'=>$rewards,'reward_counts'=>$reward_counts,'success'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mypoint  $mypoint
     * @return \Illuminate\Http\Response
     */
    public function show(Mypoint $mypoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mypoint  $mypoint
     * @return \Illuminate\Http\Response
     */
    public function edit(Mypoint $mypoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mypoint  $mypoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mypoint $mypoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mypoint  $mypoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mypoint $mypoint)
    {
        //
    }
}
