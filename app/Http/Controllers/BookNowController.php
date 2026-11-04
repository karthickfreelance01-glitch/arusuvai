<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
   use Illuminate\Support\Facades\DB;

class BookNowController extends Controller
{


public function create()
{
    $mealTypes = DB::table('meal_types')->get();
    $days      = DB::table('days')->get();

    $mealMappings = DB::table('meal_mappings')
        ->join('meal_masters', 'meal_masters.id', '=', 'meal_mappings.meal_id')
        ->join('meal_types', 'meal_types.id', '=', 'meal_mappings.meal_type_id')
        ->join('days', 'days.id', '=', 'meal_mappings.day_id')
        ->select(
            'meal_mappings.id',
            'meal_mappings.day_id',
            'meal_mappings.meal_type_id',
            'meal_masters.name as meal',
            'meal_masters.id as meal_id',
            'meal_types.meal_type',
            'days.day_name'
        )
        ->get()
        ->groupBy([
            'meal_type_id',
            'day_id'
        ]);

    return view('web.book-now', compact('mealTypes', 'days', 'mealMappings'));
}



    /* ================= STORE STEP 1 ================= */
   public function storeStep1(Request $request)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'phone' => 'required|string|max:20',
    ]);

    // Store in session
    session()->put('booking.customer', $request->all());

    return redirect('/book-now/select-meal');
}


    /* ================= STEP 2 VIEW ================= */
   

    /* ================= STORE FINAL ================= */
public function storeMeals(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone_full' => 'required|string',
        'language' => 'required',
        'payment_mode' => 'required',
        'start_date' => 'required|date',
    ]);

    $bookingId = DB::table('bookings')->insertGetId([
        'name' => $request->name,
       
        'phone' => $request->phone_full,
        'whatsapp' => $request->whatsapp_full,
        'preferred_language' => $request->language,
        'preferred_payment_mode' => $request->payment_mode,
        'start_date' => $request->start_date,
        'room_no' => $request->room_no,
        'building' => $request->building_name,
        'area' => $request->area,
        'morning_location' => $request->morning_location,
        'dinner_location' => $request->dinner_location,
        'sunday_location' => $request->sunday_location,
        'created_at' => now(),
    ]);

    if ($request->has('meals')) {
        foreach ($request->meals as $mealTypeId => $days) {
            foreach ($days as $dayId => $mealId) {
                if (!$mealId) continue;

                DB::table('booking_meals')->insert([
                    'booking_id' => $bookingId,
                    'meal_type_id' => $mealTypeId,
                    'day_id' => $dayId,
                    'meal_id' => $mealId,
                    'created_at' => now(),
                ]);
            }
        }
    }

    return redirect('book-now/success')
        ->with('success', '🎉 Thank you! Your meal service has been booked successfully.');
}

public function success()
{
    return view('web.book-now-success');
}



}
