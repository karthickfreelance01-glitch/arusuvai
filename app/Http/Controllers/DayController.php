<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DayController extends Controller
{
    public function index()
    {
        $days = DB::table('days')
                    ->orderBy('id', 'desc')
                    ->get();

        return view('meal.days.index', compact('days'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'day_name' => 'required|string|max:50',
        ]);

        DB::table('days')->insert([
            'day_name'   => $request->day_name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success','Day Added Successfully');
    }

    public function destroy($id)
    {
        DB::table('days')->where('id', $id)->delete();

        return redirect()->back()->with('success','Day Deleted');
    }
}
