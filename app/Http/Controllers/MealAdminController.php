<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class MealAdminController extends Controller
{
    /* ================= MEAL MASTER ================= */

    public function meals()
    {
        $meals = DB::table('meal_masters')->orderBy('id','desc')->get();
        return view('meal.admin.index', compact('meals'));
    }

    public function storeMeal(Request $r)
    {
        DB::table('meal_masters')->insert([
            'name' => strtoupper($r->name),
            'created_at' => now()
        ]);

        return back()->with('success','Meal Added');
    }

    /* ================= MEAL MAPPING ================= */

    public function index()
    {
        $items = DB::table('meal_mappings')
            ->join('meal_masters','meal_masters.id','=','meal_mappings.meal_id')
            ->join('meal_types','meal_types.id','=','meal_mappings.meal_type_id')
            ->join('days','days.id','=','meal_mappings.day_id')
            ->select(
                'meal_mappings.*',
                'meal_masters.name as meal',
                'meal_types.meal_type',
                'days.day_name'
            )
            ->orderBy('day_id')
            ->get();

        return view('meal.admin.map_index', compact('items'));
    }

    public function create()
    {
        return view('meal.admin.create',[
            'meals'     => DB::table('meal_masters')->get(),
            'mealTypes' => DB::table('meal_types')->get(),
            'days'      => DB::table('days')->get(),
        ]);
    }

  public function store(Request $r)
{
    $r->validate([
        'meal_id'        => 'required',
        'meal_type_ids'  => 'required|array',
        'day_ids'        => 'required|array',
    ]);

    $inserted = 0;
    $skipped  = 0;

    foreach ($r->meal_type_ids as $mealType) {
        foreach ($r->day_ids as $day) {

            // 🔍 Check duplicate
            $exists = DB::table('meal_mappings')
                ->where('meal_id', $r->meal_id)
                ->where('meal_type_id', $mealType)
                ->where('day_id', $day)
                ->exists();

            if (!$exists) {
                DB::table('meal_mappings')->insert([
                    'meal_id'      => $r->meal_id,
                    'meal_type_id'=> $mealType,
                    'day_id'       => $day,
                    'created_at'   => now(),
                ]);
                $inserted++;
            } else {
                $skipped++;
            }
        }
    }

    return redirect('/admin/meal-map')->with([
    'success' => $inserted > 0 ? "Saved: $inserted" : null,
    'error' => $skipped > 0 ? "Already Maped: $skipped" : null,
    ]);

}

public function reports()
{
    return view('reports.book_now');
}

public function data(Request $request)
{
    $type = $request->type;
    $customerId = $request->customer_id;

    // ---------------- BOOKING REPORT ----------------
    if ($type === 'booking') {

        $query = DB::table('bookings as b')
            ->leftJoin('booking_meals as bm','b.id','=','bm.booking_id')
            ->leftJoin('meal_types as mt','mt.id','=','bm.meal_type_id')
            ->leftJoin('days as d','d.id','=','bm.day_id')
            ->leftJoin('meals as m','m.id','=','bm.meal_id')
            ->select(
                'b.customer_id',
                'b.name',
                'b.phone',
                'mt.meal_type',
                'd.day_name',
                'm.meal',
                'b.created_at'
            );
    }

    // ---------------- MEAL CHANGE REPORT ----------------
    elseif ($type === 'meal_change') {

        $query = DB::table('meal_changes as mc')
            ->leftJoin('meal_change_items as mci','mc.id','=','mci.meal_change_id')
            ->leftJoin('meal_types as mt','mt.id','=','mci.meal_type_id')
            ->leftJoin('days as d','d.id','=','mci.day_id')
            ->leftJoin('meals as m','m.id','=','mci.meal_id')
            ->select(
                'mc.customer_id',
                'mc.name',
                'mc.phone',
                'mt.meal_type',
                'd.day_name',
                'm.meal',
                'mc.created_at'
            );
    }

    // ---------------- CUSTOMER WISE REPORT ----------------
    else {

        $query = DB::table('bookings as b')
            ->leftJoin('booking_meals as bm','b.id','=','bm.booking_id')
            ->leftJoin('meal_types as mt','mt.id','=','bm.meal_type_id')
            ->leftJoin('days as d','d.id','=','bm.day_id')
            ->leftJoin('meals as m','m.id','=','bm.meal_id')
            ->select(
                'b.customer_id',
                'b.name',
                'b.phone',
                'mt.meal_type',
                'd.day_name',
                'm.meal',
                'b.created_at'
            );

        if ($customerId) {
            $query->where('b.customer_id', $customerId);
        }
    }

    // DATE FILTER
    if ($request->from_date) {
        $query->whereDate('created_at','>=',$request->from_date);
    }

    if ($request->to_date) {
        $query->whereDate('created_at','<=',$request->to_date);
    }

    return response()->json(
        $query->orderBy('created_at','desc')->get()
    );
}



    public function delete($id)
    {
        DB::table('meal_mappings')->where('id',$id)->delete();
        return back()->with('success','Deleted');
    }
}


