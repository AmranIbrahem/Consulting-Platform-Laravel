<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\Models\consultation;
use App\Models\Expert;
use App\Models\Expert_Sub_Cons;
use App\Models\Sub_Consultation;
use Illuminate\Http\Request;

class Get_Experts extends Controller
{
    public function getExperts($id){

        $sub=Sub_Consultation::find($id);
        if($sub){
            $exp_arr = array();
            foreach($sub->getExperts as $value){
                array_push($exp_arr , array(
                "expert_id"=>$value->id,
                "full_name"=>$value->full_name,
                 "image"=>$value->image,
                "address"=>$value->address,

                ));
            }
                return response()->json([
                    "Experts"=>$exp_arr
                ],200);
        } else{
            return Response::Failure("This Sub_consultation not found",400);
        }

    }
/////////////////////////////////////////////////////////////////////////////////////
    public function getExpertscon($id){

        $consu=Consultation::find($id);
        if($consu){
        $exp_arr = array();
        $sub=Sub_Consultation::all();
        foreach($sub as $value){
            if ($value->consultation_id==$id){
                $id_sub=$value->id;

                $ex = Expert_Sub_Cons::all();
                foreach ($ex as $valuee){
                    if($valuee->sub_consultation_id==$value->id){
                        $id_expert=$valuee->expert_id;
                        $expert=Expert::where('id',$valuee->expert_id)->first();

                        if($expert){
                        array_push($exp_arr , array(
                            "expert_id"=>$valuee->expert_id,
                            "full_name"=>$expert->full_name,
                            "image"=>$expert->image,
                            "address"=>$expert->address,
                            "consultations"=>$consu->consultations_name,
                            "sub Consultation"=> $value->sub_cons_name
                             ));   }}}}}

                return response()->json([
                    "Experts"=>$exp_arr
                ],200);}
        else{
            return Response::Failure("This consultation not found",400);
        }

    }
/////////////////////////////////////////////////////////////////////////////////////

    public function allExperts(){
        $expert=Expert::all();
            if($expert){
            $exp_arr = array();
            foreach($expert as $value){

                $idExpert= $value->id;
                $expert2 = Expert_Sub_Cons::where('expert_id', $idExpert)->first();
                $sub1= $expert2->sub_consultation_id;
                $sub =Sub_Consultation::where('id',$sub1)->first();
                $con1=$sub->consultation_id;
                $con =consultation::where('id',$con1)->first();

                array_push($exp_arr , array(
                    "expert_id"=>$value->id,
                    "full_name"=>$value->full_name,
                    "image"=>$value->image,
                    "address"=>$value->address,
                    "consultations"=>$con->consultations_name,
                    "Sub Consultation"=>$sub->sub_cons_name,
                ));
                }
            return response()->json([
                "Experts"=>$exp_arr
            ],200);
        }
        else{
            return Response::Failure("There are no experts to display",400);

        }

    }

}
