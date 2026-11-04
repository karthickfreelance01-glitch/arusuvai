<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealTypeController extends Controller
{
    public function index()
    {
        $mealTypes = DB::table('meal_types')
                        ->orderBy('id', 'desc')
                        ->get();

        return view('meal.type.index', compact('mealTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'meal_type' => 'required|string|max:100',
        ]);

        DB::table('meal_types')->insert([
            'meal_type' => $request->meal_type,
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        return redirect()->back()->with('success','Meal Type Added Successfully');
    }

    public function destroy($id)
    {
        DB::table('meal_types')->where('id', $id)->delete();

        return redirect()->back()->with('success','Meal Type Deleted Successfully');
    }
}
