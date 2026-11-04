<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MealController extends Controller
{
    public function index()
    {
        $items = DB::table('meal_items')
            ->join('meal_types','meal_types.id','=','meal_items.meal_type_id')
            ->join('days','days.id','=','meal_items.day_id')
            ->select(
                'meal_items.*',
                'meal_types.name as meal_type',
                'days.name as day_name'
            )
            ->orderBy('meal_type_id')
            ->orderBy('day_id')
            ->get();

        return view('meal.index', compact('items'));
    }

    public function create()
    {
        return view('meal.create', [
            'mealTypes' => DB::table('meal_types')->get(),
            'days' => DB::table('days')->get()
        ]);
    }

    public function store(Request $r)
    {
        DB::table('meal_items')->insert([
            'meal_type_id' => $r->meal_type_id,
            'day_id'       => $r->day_id,
            'name'         => $r->name,
            'category'     => $r->category,
            'active'       => 1,
            'created_at'   => now()
        ]);

        return redirect()back()->with('success','Menu Added');
    }

    public function edit($id)
    {
        return view('meal.edit', [
            'item' => DB::table('meal_items')->where('id',$id)->first(),
            'mealTypes' => DB::table('meal_types')->get(),
            'days' => DB::table('days')->get()
        ]);
    }

    public function update(Request $r, $id)
    {
        DB::table('meal_items')->where('id',$id)->update([
            'meal_type_id'=>$r->meal_type_id,
            'day_id'=>$r->day_id,
            'name'=>$r->name,
            'category'=>$r->category,
            'updated_at'=>now()
        ]);

        return back()->with('success','Updated');
    }

    public function delete($id)
    {
        DB::table('meal_items')->delete($id);
        return back()->with('success','Deleted');
    }
}

