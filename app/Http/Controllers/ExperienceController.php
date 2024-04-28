<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExperienceRequest;
use App\Http\Responses\Response;
use App\Models\Experience;
use App\Models\Expert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{

    public function experience(ExperienceRequest $request)
    {
        $expert =Expert::find($request->expert_id);
        if ($expert) {
            $exp=Experience::create([
                "expert_id"=>$request->expert_id,
                "experience"=>$request->experience
            ]);

        }else{
            return Response::Failure("Expert not found",200);
        }

       if($exp){
           return Response::experience("Experience added successfully",$expert,$exp,200);
       } else {
          return Response::Failure("something went wrong",400);
      }

    }

 ////////////////////////////////////////////////////////////////////////////////
    public function deleteExperience($expert_id,$experience_id){
        $expert=Expert::find($expert_id);
        if($expert){
            $experience=Experience::find($experience_id);
            if($experience){
                $result=$experience->delete();
                if($result){
                    return Response::Failure("Experience deleted successfuly",200);
                }
                else{
                    return Response::Failure("something went wrong",400);

                }
            }else{
                return Response::Failure("Experience not found..!",201);
            }
        }else{
            return Response::Failure("Expert not found..!",201);
        }
    }


}
