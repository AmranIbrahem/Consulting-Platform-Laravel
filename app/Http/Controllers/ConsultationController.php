<?php

namespace App\Http\Controllers;

use App\Http\Requests\store_consRequest;
use App\Http\Responses\Response;
use App\Models\consultation;
use App\Models\Sub_Consultation;
use App\Models\Expert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    //return consultation :
    public function get_Cons (){
        $con=consultation::all();
        return response()->json([
            "message"=>"Success",
            "data"=>$con
        ],200);
    }
/////////////////////////////////////////////////////////////////////////////////////
    //return sub_consultation :
    public function get_Sub($consultation_id){
        $cons=consultation::find($consultation_id);
        if($cons){
            return response()->json([
                "message"=>"Success",
                "data"=>$cons->sub
            ],200);
         }
        else{
            return Response::Failure("Consulation not found",402);

        }

    }
/////////////////////////////////////////////////////////////////////////////////////
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'consultations_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Validation failed..!",
                "errors" => $validator->errors()->all()
            ], 422);
        }

        $cons=consultation::create($request->all());
        if($cons){
            return Response::Failure("Success",200);
        }
        else{
            return Response::Failure("Wrong",402);
        }
    }
//////////////////////////////////////////////////////////////////////////////////

public function store_cons(store_consRequest $request)
    {
        $x=consultation::find($request->consultation_id);
        if($x){
        $cons=Sub_Consultation::create($request->all());
         }
         else{
             return Response::Failure("Consulation not found",402);
         }
        if($cons){
            return Response::Failure("Success",200);
        }
        else{
            return Response::Failure("Wrong",402);

        }

    }


}
