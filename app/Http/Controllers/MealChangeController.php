<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealChangeController extends Controller
{
    public function index()
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
            return view('web.meal-change', compact('mealTypes', 'days', 'mealMappings'));
        }

   public function ajaxSearch(Request $request)
    {
        // ✅ VALIDATION
        if (!$request->name || !$request->phone) {
            return response()->json([
                'status' => false,
                'message' => 'Name and phone required'
            ]);
        }

        // ✅ BOOKING CHECK
        $booking = DB::table('bookings')
            ->where('name', $request->name)
            ->where('phone', $request->phone)
            ->first();

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found'
            ]);
        }

        // ✅ MASTER DATA
        $mealTypes = DB::table('meal_types')->get();
        $days      = DB::table('days')->get();

        // ✅ MEAL MAPPINGS
        $rawMeals = DB::table('meal_mappings')
            ->join('meal_masters','meal_masters.id','=','meal_mappings.meal_id')
            ->join('meal_types','meal_types.id','=','meal_mappings.meal_type_id')
            ->select(
                'meal_mappings.day_id',
                'meal_mappings.meal_type_id',
                'meal_masters.id as meal_id',
                'meal_masters.name as meal',
                'meal_types.meal_type'
            )
            ->get();

        // 🔄 MANUAL GROUPING (JSON SAFE)
        $mealMappings = [];
        foreach ($rawMeals as $row) {
            $mealMappings[$row->meal_type_id][$row->day_id][] = [
                'meal_id'   => $row->meal_id,
                'meal'      => $row->meal,
                'meal_type' => $row->meal_type
            ];
        }

        // ✅ EXISTING SELECTED MEALS
        $rawExisting = DB::table('booking_meals')
            ->where('booking_id', $booking->id)
            ->get();

        $existingMeals = [];
        foreach ($rawExisting as $row) {
            $existingMeals[$row->day_id][$row->meal_type_id][] = [
                'meal_id' => $row->meal_id
            ];
        }

        return response()->json([
            'status'        => true,
            'booking'       => $booking,
            'mealTypes'     => $mealTypes,
            'days'          => $days,
            'mealMappings'  => $mealMappings,
            'existingMeals' => $existingMeals
        ]);
    }




   public function update(Request $request)
{
    $request->validate([
        'booking_id' => 'required|integer|exists:bookings,id',
        'meals'      => 'required|array',
    ]);

    $bookingId = $request->booking_id;

    DB::transaction(function () use ($request, $bookingId) {

        // Delete existing meals
        DB::table('booking_meals')
            ->where('booking_id', $bookingId)
            ->delete();

        // Insert updated meals
        foreach ($request->meals as $mealTypeId => $days) {
            foreach ($days as $dayId => $mealId) {

                if (!$mealId || !is_numeric($mealId)) {
                    continue;
                }

                DB::table('booking_meals')->insert([
                    'booking_id'   => $bookingId,
                    'meal_type_id'=> $mealTypeId,
                    'day_id'       => $dayId,
                    'meal_id'      => $mealId,
                    'created_at'   => now(),
                ]);
            }
        }
    });

    return redirect()->back()->with('success', '🍱 Meals updated successfully!');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'phone_full' => 'required',
        'meal_type_selected' => 'required|array',
        'meals' => 'required|array'
    ]);

    $mealChangeId = DB::table('meal_changes')->insertGetId([
       
        'name' => $request->name,
        'phone' => $request->phone_full,
        'created_at' => now(),
    ]);

    foreach ($request->meals as $mealTypeId => $days) {
        foreach ($days as $dayId => $mealId) {
            if(!$mealId) continue;

            DB::table('meal_change_items')->insert([
                'meal_change_id' => $mealChangeId,
                'meal_type_id' => $mealTypeId,
                'day_id' => $dayId,
                'meal_id' => $mealId,
                'created_at' => now(),
            ]);
        }
    }

    return redirect()->back()
        ->with('success','🍱 Meal change request submitted successfully');
}

}
