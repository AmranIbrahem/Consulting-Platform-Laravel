<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRequest;
use App\Http\Responses\Response;
use App\Models\Expert;
use App\Models\Appointment;
use APP\Models\Experience;
use APP\Models\Sub_Con_Expert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExpertController extends Controller
{

    //API to save/update name,add,mob,image :
    public function update(UpdateRequest $request)
    {
        $expert = Expert::find($request->expert_id);
        if ($expert) {
            $expert->full_name = $request->full_name;
            $expert->address = $request->address;
            $expert->mobile = $request->mobile;
            $expert->balance = $request->balance;
            $expert->price = $request->price;

            ///////////////////////
            if ($request->image) {
                $destination = time() . $request->image->getClientOriginalName();
                $request->image->move('images/experts', $destination);
                $expert->image = $destination;
            }
            ///////////////////////

            $result = $expert->save();
            if ($result) {
                return Response::updateSuccess("Data is updated",$expert,200);

            } else {
                return Response::Failure("Something went wrong ",400);
            }
        } else {
            return Response::Failure("Expert not found",400);

        }
    }
}
