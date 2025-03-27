<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $patient = $user->patient;
        $appointments = $patient->appointments;

        return view('patient.appointments.index',compact('appointments','user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::find(auth()->id());
        $doctors = Doctor::paginate(9);
        $departments = Department::all();
        return view('patient.appointments.create',compact('doctors','departments','user'));
    }

    /**
     * Get available time slots for the specified doctor and date.
     */

    public function getAvailableTimeSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date'
        ]);

        $doctor = Doctor::findOrFail($request->doctor_id);
        $date = $request->date;
        
        $allTimeSlots = [
            '09:00 AM - 10:00 AM', 
            '10:00 AM - 11:00 AM', 
            '11:00 AM - 12:00 PM', 
            '02:00 PM - 03:00 PM', 
            '03:00 PM - 04:00 PM', 
            '04:00 PM - 05:00 PM'
        ];
        
        $bookedAppointments = $doctor->appointments()
            ->where('appointment_date', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('appointment_time')
            ->toArray();
        
        $availableTimeSlots = array_values(array_diff($allTimeSlots, $bookedAppointments));
        
        return response()->json([
            'available_slots' => $availableTimeSlots,
            'doctor_name' => $doctor->user->name,
            'date' => $date
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $user = auth()->user();
        $patient = $user->patient;
        $appointment = new Appointment();
        $appointment->patient_id = $patient->id;
        $appointment->doctor_id = $request->doctor_id;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->time_slot;
        $appointment->reason = $request->reason;
        $appointment->status = 'pending';
        $appointment->save();

        return redirect()->route('patient.appointments')->with('success','Appointment created successfully');
    }

    /** 
     * Cancel the specified resource.
     */
    public function cancel(Appointment $appointment)
    {
        $appointment->status = 'cancelled';
        $appointment->save();
        return redirect()->route('patient.appointments')->with('success','Appointment cancelled successfully');
    }   

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {

        $user = auth()->user();
        return view('patient.appointments.details',compact('appointment','user'));
    }

}
