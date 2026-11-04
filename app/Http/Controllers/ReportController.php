<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
public function reports()
{
   
    return view('reports.book_now');
}

    /* ================= BASE QUERY ================= */
public function data(Request $request)
{
    $type       = $request->type ?? 'booking';
    $from       = $request->from_date;
    $to         = $request->to_date;
    $customerId = $request->customer_id;

    $days = DB::table('days')->orderBy('id')->get();

    $normalMeals = ['Breakfast', 'Lunch', 'Dinner'];

    /* ================= BASE QUERY ================= */
    if ($type === 'meal_change') {
        $rows = DB::table('meal_changes as b')
            ->leftJoin('meal_change_items as bm','b.id','=','bm.meal_change_id');
    } else {
        $rows = DB::table('bookings as b')
            ->leftJoin('booking_meals as bm','b.id','=','bm.booking_id');
    }

    $rows = $rows
        ->leftJoin('days as d','d.id','=','bm.day_id')
        ->leftJoin('meal_types as mt','mt.id','=','bm.meal_type_id')
        ->leftJoin('meal_masters as m','m.id','=','bm.meal_id')
        ->select(
            'b.customer_id',
            'b.name',
            'b.phone',
            'b.room_no',
            'b.building',
            'b.area',
            'b.morning_location',
            'b.dinner_location',
            'b.sunday_location',
            'd.day_name',
            'mt.meal_type',
            'm.name as meal',
            DB::raw("DATE_FORMAT(b.created_at,'%Y-%m-%d %H:%i:%s') as created_at")
        );

    if ($from && $to) {
        $rows->whereBetween(DB::raw('DATE(b.created_at)'), [$from, $to]);
    }

    if ($customerId) {
        $rows->where('b.customer_id', $customerId);
    }

    $rows = $rows->get();

    /* ================= BUILD DATA ================= */
    $data = [];

    foreach ($rows as $row) {
        $key = ($row->customer_id ?? 'NA').'_'.$row->created_at;

        if (!isset($data[$key])) {

           $addressParts = [
    '<strong>Room No:</strong> '          . ($row->room_no ?? '-'),
    '<strong>Building:</strong> '         . ($row->building ?? '-'),
    '<strong>Area:</strong> '             . ($row->area ?? '-'),
    '<strong>Morning Location:</strong> ' . ($row->morning_location ?? '-'),
    '<strong>Dinner Location:</strong> '  . ($row->dinner_location ?? '-'),
    '<strong>Sunday Location:</strong> '  . ($row->sunday_location ?? '-'),
];

// Join with <br> for line breaks
$address = implode(',', $addressParts);

$data[$key] = [
    'customer_id' => $row->customer_id ?? '-',
    'name'        => $row->name,
    'phone'       => $row->phone,
    'address'     => $address,
    'created_at'  => $row->created_at,
];


            // Initialize day columns
            foreach ($days as $day) {
                if ($day->day_name !== 'Monday'
                    && $day->day_name !== 'Tuesday'
                    && $day->day_name !== 'Wednesday'
                    && $day->day_name !== 'Thursday'
                    && $day->day_name !== 'Friday'
                    && $day->day_name !== 'Saturday') {
                    $data[$key][$day->day_name] = '-';
                } else {
                    foreach ($normalMeals as $meal) {
                        $data[$key][$day->day_name.'_'.strtolower($meal)] = '-';
                    }
                }
            }
        }

        /* ================= FILL VALUES ================= */
        if (!$row->day_name || !$row->meal_type) {
            continue;
        }

        // Sunday Optional
        if ($row->meal_type === 'Sunday Optional') {
            $data[$key][$row->day_name] = $row->meal;
        } else {
            if (in_array($row->meal_type, $normalMeals)) {
                $data[$key][$row->day_name.'_'.strtolower($row->meal_type)] = $row->meal;
            }
        }
    }

    /* ================= COLUMNS ================= */
    $columns = [
        ['data'=>'customer_id','title'=>'Customer ID'],
        ['data'=>'name','title'=>'Name'],
        ['data'=>'phone','title'=>'Phone'],
        ['data'=>'address','title'=>'Address'], // <-- NEW COLUMN
    ];

    foreach ($days as $day) {
        if ($day->day_name !== 'Monday'
            && $day->day_name !== 'Tuesday'
            && $day->day_name !== 'Wednesday'
            && $day->day_name !== 'Thursday'
            && $day->day_name !== 'Friday'
            && $day->day_name !== 'Saturday') {

            $columns[] = [
                'data'  => $day->day_name,
                'title' => $day->day_name
            ];

        } else {
            foreach ($normalMeals as $meal) {
                $columns[] = [
                    'data'  => $day->day_name.'_'.strtolower($meal),
                    'title' => $day->day_name.' ('.$meal.')'
                ];
            }
        }
    }

    $columns[] = ['data'=>'created_at','title'=>'Date & Time'];

    return response()->json([
        'columns' => $columns,
        'data'    => array_values($data),
    ]);
}




}
