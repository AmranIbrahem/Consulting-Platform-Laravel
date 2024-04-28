<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\ExpertSubConsController;
use App\Http\Controllers\ExpertUserController;
use App\Http\Controllers\Get_Experts;
use App\Http\Controllers\GetprofileController;
use App\Http\Controllers\Re_ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// APIS for backend admins
Route::post('store', [ConsultationController::class, 'store']);
Route::post('store_cons', [ConsultationController::class, 'store_cons']);

// Authentication
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

// Experts Auth Routes
Route::middleware(['assign.guard:experts'])->group(function () {

    // Experts APIs
    Route::post('profile', [ExpertController::class, 'update']);

    // Appointment APIs
    Route::post('appointment', [AppointmentController::class, 'store']);

    // Experience APIs
    Route::post('experience', [ExperienceController::class, 'experience']);

    // APIs to store subconsultation
    Route::post('store_sub', [ExpertSubConsController::class, 'store_sub']);

    // APIs to get information expert
    Route::get('profile/{id}', [Re_ProfileController::class, 'profileInfo']);

    // APIS to update information expert
    Route::post('profile/{id}', [Re_ProfileController::class, 'updateProfileInfo']);

    // APIS to delete an Experience
    Route::delete('deleteExp/{expert_id}/{experience_id}', [ExperienceController::class, 'deleteExperience']);

    // APIS to delete image
    Route::delete('deleteImage/{expert_id}', [Re_ProfileController::class, 'deleteImage']);
});

// Users Auth Routes
Route::middleware(['assign.guard:users'])->group(function () {

    // APIS to get experts according to subconsultation_id
    Route::get('Getexperts/{id}', [Get_Experts::class, 'getExperts']);

    // APIS to show all expert
    Route::get('Getexperts', [Get_Experts::class, 'allExperts']);

    // APIS to show Consultation expert
    Route::get('getExpertscon/{id}', [Get_Experts::class, 'getExpertscon']);

    // APIs to return consultation
    Route::get('get_Cons', [ConsultationController::class, 'get_Cons']);

    // APIs to return sub_cons
    Route::get('get_Sub/{consultation_id}', [ConsultationController::class, 'get_Sub']);

    // Searching APIs
    Route::get("search-by-expert/{name}", [SearchController::class, 'searchByExpertName']);
    Route::get("search-by-subcons/{name}", [SearchController::class, 'searchBySubConsName']);

    // Get another Profile
    Route::get('get_profile/{expert_id}', [GetprofileController::class, 'getProfile']);

    // Save Balance_user
    Route::post('saveBalance/{user_id}', [ExpertUserController::class, 'saveBalance']);

    // Get Balance_user
    Route::get('GetBalance/{user_id}', [ExpertUserController::class, 'GetBalance']);

    // Get reserved appointments
    Route::get('reserved/{id}', [ExpertUserController::class, 'getReservedAppointments']);

    // Get Days
    Route::get('getDaysInAWeek/{expert_id}', [ExpertUserController::class, 'getDaysInAWeek']);

    // Get Hours
    Route::post("free-hours-by-day", [ExpertUserController::class, 'getFreeAppointments']);

    // Reserve Appointment APIs
    Route::post("reserveAppointment", [ExpertUserController::class, 'reserveAppointment']);
});
