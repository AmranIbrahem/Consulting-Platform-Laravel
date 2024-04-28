<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\Models\Expert;
use App\Models\Sub_Consultation;
use App\Models\Expert_Sub_Cons;
use App\Models\Consultation;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchByExpertName($name)
    {
        $expert = Expert::where("full_name", "like", "%" . $name . "%")->get();

        if ($expert) {
            $exp_arr = array();
            foreach ($expert as $value) {
                $idExpert= $value->id;
                $expert2 = Expert_Sub_Cons::where('expert_id', $idExpert)->first();
                $sub1= $expert2->sub_consultation_id;
                $sub =Sub_Consultation::where('id',$sub1)->first();
                $con1=$sub->consultation_id;
                $con =consultation::where('id',$con1)->first();

                array_push($exp_arr, array(
                    "id" => $value->id,
                    "name" => $value->full_name,
                    "image"=>$value->image,
                    "address"=>$value->address,
                    "consultations"=>$con->consultations_name,
                    "Sub Consultation"=>$sub->sub_cons_name,
                ));
            }
        }

        if ($exp_arr) {
            return response()->json([
                "message" => "Success",
                "data_exp" => $exp_arr,
            ], 200);
        } else {
            return Response::Failure("not found",402);
        }
    }
///////////////////////////////////////////////////////////////////////
    public function searchBySubConsName($name)
    {
        $sub_cons = Sub_Consultation::where("sub_cons_name", "like", "%" . $name . "%")->get();

        if ($sub_cons) {
            $sub_arr = array();
            foreach ($sub_cons as $value) {
                array_push($sub_arr, array(
                    "id" => $value->id,
                    "name" => $value->sub_cons_name,
                ));
            }
        }

        if ($sub_arr) {
            return response()->json([
                "message" => "Success",
                "data_sub" => $sub_arr
            ], 200);
        } else {
            return Response::Failure("not found",402);
        }
    }

    // public function search($name)
    // {
    //     $expert = Expert::where("full_name", "like", "%" . $name . "%")->get();
    //     $sub_cons = Sub_Consultation::where("sub_cons_name", "like", "%" . $name . "%")->get();


    //     if ($expert) {
    //         $exp_arr = array();
    //         foreach ($expert as $value) {
    //             array_push($exp_arr, array(
    //                 "id" => $value->id,
    //                 "name" => $value->full_name
    //             ));
    //         }
    //     }

    //     if ($sub_cons) {
    //         $sub_arr = array();
    //         foreach ($sub_cons as $value) {
    //             array_push($sub_arr, array(
    //                 "id" => $value->id,
    //                 "name" => $value->sub_cons_name
    //             ));
    //         }
    //     }

    //     if ($exp_arr && $sub_arr) {
    //         return response()->json([
    //             "message" => "Success",
    //             "data_exp" => $exp_arr,
    //             "data_sub" => $sub_arr
    //         ], 200);
    //     } else if ($exp_arr) {
    //         return response()->json([
    //             "message" => "Success",
    //             "data_exp" => $exp_arr,
    //         ], 200);
    //     } else if ($sub_arr) {
    //         return response()->json([
    //             "message" => "Success",
    //             "data_sub" => $sub_arr
    //         ], 200);
    //     }

    //     return response()->json([
    //         "message" => "not found"
    //     ], 404);
    // }
}
