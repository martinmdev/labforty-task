<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ApiAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->integer('pp');
        if (!in_array($perPage, [5, 15])) {
            $perPage = 5;
        }

        $queryBuilder = DB::table('appointment')
            ->select('appointment.*', 'notification_type.name as notification_type')
            ->join('notification_type', 'appointment.notification_type_id', '=', 'notification_type.id');

        $dateFrom = $request->input('date_from');
        if ($dateFrom) {
            $dateFrom2 = date('Y-m-d H:i', strtotime($dateFrom));
            $queryBuilder->where('timestamp', '>', $dateFrom2);
        }

        $dateTo = $request->input('date_to');
        if ($dateTo) {
            $dateTo2 = date('Y-m-d H:i', strtotime($dateTo));
            $queryBuilder->where('timestamp', '<', $dateTo2);
        }

        $ucn = $request->input('ucn');
        if ($ucn) {
            $queryBuilder->where('ucn', '=', $ucn);
        }

        $queryBuilder->orderBy('id', 'asc');

        $appointments = $queryBuilder->paginate($perPage)->withQueryString();

        $data = [
            'appointments' => $appointments,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'ucn' => $ucn,
        ];

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $rules = Appointment::getInsertValidationRules();
        $validator = Validator::make($input, $rules);
        try {
            $validatedData = $validator->validate();
        } catch (ValidationException $exception) {
            $response = response()->json([
                'errors' => $exception->errors(),
            ], 422);

            return $response;
        }

        $appointmentData = array_filter($validatedData);

        $appointment = new Appointment($appointmentData);

        $res = $appointment->save();

        if (!$res) {
            $response = response()->json([
                'errors' => ['Creating appointment failed'],
            ], 422);

            return $response;
        } else {
            return $appointment;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $upcomingAppointments = DB::table('appointment')
            ->select('appointment.*', 'notification_type.name as notification_type')
            ->join('notification_type', 'appointment.notification_type_id', '=', 'notification_type.id')
            ->where('names', '=', $appointment->names)
            ->where('timestamp', '>', date('Y-m-d H:i'))
            ->orderBy('id', 'asc')
            ->get();

        $data = [
            "appointment" => $appointment,
            "upcomingAppointments" => $upcomingAppointments,
        ];

        return $data;
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $appointment)
    {
        $input = $request->all();
        $input['id'] = $appointment;
        $rules = Appointment::getUpdateValidationRules();
        $validator = Validator::make($input, $rules);
        try {
            $validatedData = $validator->validate();
        } catch (ValidationException $exception) {
            $response = response()->json([
                'errors' => $exception->errors(),
            ], 422);

            return $response;
        }

        $validatedData = array_filter($validatedData);

        $appointment = Appointment::find($validatedData['id']);

        $appointment->fill($validatedData);

        $res = $appointment->save();

        if (!$res) {
            $response = response()->json([
                'errors' => ['Updating appointment failed'],
            ], 422);

            return $response;
        } else {
            return $appointment;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $appointment)
    {
        $input = $request->all();
        $input['id'] = $appointment;
        $rules = Appointment::getIdValidationRules();
        $validator = Validator::make($input, $rules);
        try {
            $validatedData = $validator->validate();
        } catch (ValidationException $exception) {
            $response = response()->json([
                'errors' => $exception->errors(),
            ], 422);

            return $response;
        }

        $id = $input['id'];
        $res = Appointment::destroy($id);

        if (!$res) {
            $response = response()->json([
                'errors' => ['Deleting appointment failed'],
            ], 422);

            return $response;
        } else {
            $response = response()->json([
                'message' => 'appointment deleted',
            ]);

            return $response;
        }
    }
}
