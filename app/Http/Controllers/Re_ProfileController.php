<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\Models\Expert;
use App\Models\Experience;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class Re_ProfileController extends Controller
{

    public function profileInfo($id)
    {

        $expert = Expert::find($id);
        if ($expert) {
            $exp_arr = array();
            foreach ($expert->experiences as $exp) {
                array_push($exp_arr, array(
                    "id" => $exp->id,
                    "experience" => $exp->experience
                ));
            }
            // $app_arr = array();
            // foreach ($expert->appointments as $appointment){
            //     array_push($app_arr, array(
            //         "id"=>$appointment->id,
            //         'day_name' => $appointment->day_name,
            //         'start_hour' => $appointment->start_hour,
            //         'end_hour' => $appointment->end_hour,
            //     ));
            // }
            // $sub_arr = array();
            // foreach ($expert->getExpertSubconsultation as $sub) {
            //     array_push($sub_arr, array(
            //         "id"=>$sub->id,
            //         "sub_consultation"=>$sub->sub_cons_name
            //     ));
            // }
            $dis = public_path('images\\experts\\');
            return response()->json([
                "full_name" => $expert->full_name,
                "email" => $expert->email,
                "address" => $expert->address,
                "mobile" => $expert->mobile,
                "image" => $expert->image . " " . $dis,
                "balance" => $expert->balance,
                "price" => $expert->price,
                "experiences" => $exp_arr,
                // "appointments" => $app_arr,
                // "sub_consultation"=>$sub_arr
            ], 200);
        } else {
            return Response::Failure("Not found..!",404);
        }
    }
    ///////////////////////////////////////////////////////////////////////////////////////

    public function updateProfileInfo(Request $request, $expert_id)
    {
        $expert = Expert::find($expert_id);
        if ($expert) {
            if ($request->address || $request->mobile || $request->price || $request->balance) {
                $expert->address = $request->address;
                $expert->mobile = $request->mobile;
                $expert->price = $request->price;
                $expert->balance =  $expert->balance+ $request->balance;
            }

            if ($request->hasFile('image')) {
                $destination = public_path('images\\experts\\' . $expert->image);
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $newdestination = time() . $request->image->getClientOriginalName();
                $request->image->move('images\\experts\\', $newdestination);
                $expert->image = $newdestination;
            }

            if ($request->experience) {
                $exp = Experience::create([
                    "expert_id" => $expert_id,
                    "experience" => $request->experience,
                ]);
            }

            $result = $expert->save();
            if ($result) {
                return Response::Failure("Data is updated",200);
            } else {
                return Response::Failure("Something went wrongt",400);
            }
        } else {
            return Response::Failure("Expert not found",404);
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////

    public function deleteImage($expert_id)
    {
        $expert = Expert::find($expert_id);
        if ($expert) {
            $destination = public_path('images\\experts\\' . $expert->image);
            if (File::exists($destination)) {
                File::delete($destination);
                $expert->image = Null;
                $expert->save();

                return Response::Failure("Image deleted successfuly",200);

            } else {
                return Response::Failure("image not found",200);
            }
        } else {
            return Response::Failure("Expert not found",400);
        }
    }


}
