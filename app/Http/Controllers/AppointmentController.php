<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\NotificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
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

        return view('appointments.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $notificationTypes = NotificationType::all();

        return view('appointments.create', ['notificationTypes' => $notificationTypes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $validatedData = $request->validated();

        $appointmentData = array_filter($validatedData);

        $appointment = new Appointment($appointmentData);

        $res = $appointment->save();

        $redirect = redirect()->back();

        if (!$res) {
            $redirect->withErrors('Creating appointment failed');
        } else {
            $redirect = redirect()->route('appointments.show', [
                'appointment' => $appointment->id,
            ]);
            $redirect->with('status',
                'Appointment created successfully! The client will be notified via ' . $appointment->notificationType->name . '.');
        }

        return $redirect;
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

        return view('appointments.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $data = [
            "appointment" => $appointment,
            "notificationTypes" => NotificationType::all(),
        ];

        return view('appointments.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData = array_filter($validatedData);

        $appointment = Appointment::find($validatedData['id']);

        $appointment->fill($validatedData);

        $res = $appointment->save();

        $redirect = redirect()->back();

        if (!$res) {
            $redirect->withErrors('Saving appointment failed');
        } else {
            $redirect->with('status',
                'Appointment updated successfully! The client will be notified via ' . $appointment->notificationType->name . '.');
        }

        return $redirect;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyAppointmentRequest $request)
    {
        $request->validated();

        $id = $request->id;
        $res = Appointment::destroy($id);

        $redirect = redirect()->route('appointments.index');

        if (!$res) {
            $redirect->withErrors('Deleting appointment ' . $id . ' failed');
        } else {
            $redirect->with('status', 'Appointment ' . $id . ' deleted');
        }

        return $redirect;
    }
}
