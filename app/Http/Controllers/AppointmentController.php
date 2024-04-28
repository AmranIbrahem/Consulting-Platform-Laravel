<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Responses\Response;
use App\Models\Appointment;
use App\Models\Expert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // API to save appointments:
    public function store(StoreRequest $request)
    {
        $expert = Expert::find($request->expert_id);
        if ($expert) {
            $times = Appointment::create([
                "expert_id" => $request->expert_id,
                "day_name" => $request->day_name,
                "start_hour" => $request->start_hour,
                "end_hour" => $request->end_hour,
            ]);
        }

        if ($times) {
            return Response::storeAppointment("Appointment save successfully",$times,200);
        } else {
            return Response::Failure("something went wrong",400);
        }

    }


}
