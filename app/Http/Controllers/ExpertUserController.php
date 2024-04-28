<?php

namespace App\Http\Controllers;

use App\Http\Requests\reserveAppointmentRequest;
use App\Http\Responses\Response;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Expert;
use App\Models\ExpertUser;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ExpertUserController extends Controller
{
    // Get Days :
    public function getDaysInAWeek($expert_id)
    {
        $expert = Expert::find($expert_id);

        $app_arr = array();
        if ($expert) {
            foreach ($expert->appointments as $appointment) {
                array_push($app_arr, array(
                    "id" => $appointment->id,
                    'day_name' => $appointment->day_name,
                ));
            }
        }
        return response()->json([
            "message" => "Success",
            "Days" => $app_arr
        ], 200);
    }


    // Get Expert Free Hours :
    public function getFreeAppointments(Request $request)
    {
        $expert_id = $request->expert_id;
        $date = (new Carbon($request->date))->format('Y-m-d');
        $day_name = (new Carbon($date))->format('l');

        $appointment = Appointment::where("expert_id", $expert_id)->where("day_name", $day_name)->first();

        if ($appointment) {
            $start_hour = new Carbon($appointment->start_hour);
            $end_hour = new Carbon($appointment->end_hour);

            $expert_free_hours = array();
            $temp = (new Carbon($start_hour));

            $date_reserved = ExpertUser::where("expert_id", $expert_id)->where("day_date", $date)->get();

            $date_array = array();
            foreach ($date_reserved as $value) {
                array_push($date_array, array(
                    "start" => $value->start_date,
                    "end" => $value->end_date
                ));
            }

            while ($temp->lessThan($end_hour)) {
                if (count($date_array) != 0) {
                    if ($this->isReserverd($temp, $date_array)) {
                        $temp = (new Carbon($temp))->addMinutes(30);
                    } else {
                        array_push($expert_free_hours, ($temp)->format('h:i:s'));
                        $temp = (new Carbon($temp))->addMinutes(30);
                    }
                } else {
                    array_push($expert_free_hours, ($temp)->format('h:i:s'));
                    $temp = (new Carbon($temp))->addMinutes(30);
                }
            }

            if (count($expert_free_hours) > 0) {
                return response()->json([
                    "date_reserved" => $date_reserved,
                    "expert_free_hours" => $expert_free_hours,
                ], 200);
            }
            if (count($expert_free_hours) == 0) {
                return Response::Failure("Day appointments full!!",203);
            }
        } else {
            return Response::Failure("No appointments",400);
        }
    }

    public function isReserverd($date, $date_array)
    {
        foreach ($date_array as $value_date) {
            if (($date->greaterThanOrEqualTo($value_date['start'])) && ($date->lessThan($value_date['end']))) {
                return true;
            }
        }
    }


    public function reserveAppointment(reserveAppointmentRequest $request)
    {
        $expert = Expert::find($request->expert_id);

        if ($request->type == 1)
            $user = Expert::find($request->user_id);
        else if ($request->type == 2)
            $user = User::find($request->user_id);

        if ($expert) {
            $start_date = new Carbon($request->start_date);
            $end_date = $start_date->addMinutes(30);

            if ($user->balance >= $expert->price) {

                $user->balance -= $expert->price;
                $expert->balance += $expert->price;
                $user->save();
                $expert->save();

                $expert_user = ExpertUser::create([
                    "expert_id" => $request->expert_id,
                    "user_id" => $request->user_id,
                    "day_date" => $request->day_date,
                    "start_date" => $request->start_date,
                    "end_date" => $end_date,
                    "type" => $request->type,
                ]);

                return response()->json([
                    "message" => "Reserverd successfully.",
                    "expert_user" => $expert_user,
                ], 200);
            } else {
                return Response::Failure( "User balance $user->balance not enough..!",400);
            }
        }
    }


    public function getReservedAppointments($expert_id)
    {
        $expert = Expert::find($expert_id);

        $array_date = array();

        if ($expert) {
            $reserved = $expert->reserved_appointments;

            if ($reserved) {
                foreach ($reserved as $date) {
                    array_push($array_date, array(
                        "day_nate" => $date->day_date,
                        "start_date" => $date->start_date,
                        "end_date" => $date->end_date
                    ));
                }
                return response()->json([
                    "message" => "Success",
                    "data" => $array_date
                ], 200);
            } else {
                return Response::Failure("No reserved dates",400);
            }
        } else {
            return Response::Failure("Expert not found..!!",400);
        }
    }


    public function saveBalance(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            $user->balance =$user->balance+ $request->balance;
        }
        $result = $user->save();
        if ($result) {
            return response()->json([
                "message" => "Success"
            ], 200);
        } else {
            return Response::Failure("Something went wrong",400);
        }
    }

    public function GetBalance($user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            return response()->json([
                "Blance"=>$user->balance
            ], 200);
        }
         else {
             return Response::Failure("Something went wrong",400);
        }
    }

}
