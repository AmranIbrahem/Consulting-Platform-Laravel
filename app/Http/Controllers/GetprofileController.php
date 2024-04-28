<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use Illuminate\Http\Request;
use App\Models\Expert;
use App\Models\Experience;

class GetprofileController extends Controller
{
    public function getProfile($expert_id)
    {
        $expert = Expert::find($expert_id);
        if ($expert) {
            $exp_arr = array();
            foreach ($expert->experiences as $exp) {
                array_push($exp_arr, array(
//                    "id" => $exp->id,
                    "experience" => $exp->experience
                ));
            }
            $app_arr = array();
            foreach ($expert->appointments as $appointment) {
                array_push($app_arr, array(
                    "id" => $appointment->id,
                    'day_name' => $appointment->day_name,
                    'start_hour' => $appointment->start_hour,
                    'end_hour' => $appointment->end_hour,
                ));
            }
            $sub_arr = array();
            foreach ($expert->getExpertSubconsultation as $sub) {
                array_push($sub_arr, array(
//                    "id" => $sub->id,
                    "sub_consultation" => $sub->sub_cons_name
                ));
            }
            $dis = public_path('images\\experts\\');
            return response()->json([
                "full_name" => $expert->full_name,
                "address" => $expert->address,
                "mobile" => $expert->mobile,
                "image" => $expert->image,
                "price" => $expert->price,
                "experiences" => $exp->experience,
                "appointments" => $app_arr,
                "sub_consultation" => $sub->sub_cons_name
            ], 200);
        } else {
            return Response::Failure("not found",402);
        }
    }

}
