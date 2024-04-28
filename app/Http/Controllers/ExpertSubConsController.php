<?php

namespace App\Http\Controllers;

use App\Http\Requests\store_subRequest;
use App\Http\Responses\Response;
use App\Models\Expert_Sub_Cons;
use App\Models\Expert;
use App\Models\Sub_Consultation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ExpertSubConsController extends Controller
{

    public function store_sub(store_subRequest $request)
    {
      $exp=Expert::find($request->expert_id);

      if($exp){
      $var=$request->sub_consultation_id;
      $value=Sub_Consultation::find($var);
        if($value){
            Expert_Sub_Cons::create([
               'expert_id'=>$request->expert_id,
               'sub_consultation_id'=>$var
            ]);
            return Response::Failure("Success",200);

        } else{
            return Response::Failure("Invalid SubConsultation",400);}
      } else{
          return Response::Failure("Invalid Expert",400);
        }

    }


}
