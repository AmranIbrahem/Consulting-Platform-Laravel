<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class Response
{
    public static function registerSuccess($message, $data, $token,$stateCode): JsonResponse
    {
        return response()->json([
            "message" => $message,
            'data' => $data,
            'token' => $token
        ], $stateCode);
    }

    public static function loginSuccess($message, $user,$type, $userId,$token,$stateCode): JsonResponse
    {
        return response()->json([
            "message" => $message,
            "data" => $user,
            "id"=>$userId,
            "type"=>$type,
            "token" => $token
        ], $stateCode);

    }

    public static function logoutSuccess($message,$stateCode): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Logout successfully'
        ], $stateCode);

    }

    public static function updateSuccess($message,$expert,$stateCode): JsonResponse
    {
        return response()->json([
            "massage" => "Data is updated",
            "data" => $expert
        ], $stateCode);

    }

    public static function storeAppointment($message,$times,$stateCode): JsonResponse
    {
        return response()->json([
            "message" => $message,
            "times" => $times
        ], $stateCode);

    }

    public static function experience($message,$expert,$exp,$stateCode): JsonResponse
    {
        return response()->json([
            "message"=>$message,
            "data"=>[
                "expert"=>$expert,
                "experience"=>$exp]
        ], $stateCode);

    }

    public static function Failure($message,$stateCode): JsonResponse
    {
        return response()->json([
            "message" => $message,
        ], $stateCode);
    }


}
