<?php

namespace App\Http\Controllers\Panel;

use JWTAuth;
use Validator;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = JWTAuth::user();

        // $review = Review::where('user_id' , $user->id)->get();

        // return $review;


        return response()->json(['review' => new ReviewResource($user) , 'success'=>true]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = JWTAuth::user();

        $validator = Validator::make($request->all(), [
            'content' => 'required',
            'rating' => 'required',
            ]);
        if($validator->fails()) {
                return response()->json(['success'=>false,'message'=>$validator->errors()->first()]);
            } else {
                    $status = Review::create(
                        ['user_id'=>$user->id,
                        'content'=>$request->content,
                        'rating'=>$request->rating,
                    ]);
                    if($status)
                    {
                        return response()->json(['message'=>'Review has been added successfully!','success'=>true]);
                    }
                return response()->json(['message'=>'Review not added please try again.','success'=>false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
