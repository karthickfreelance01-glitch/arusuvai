<?php

namespace App\Http\Controllers;

use App\Models\User;          // ✅ REQUIRED
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;

class AuthController extends Controller
{
    public function registerForm() {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'required|unique:users',
            'password'=>'required|min:6'
        ]);

        $emailOtp = rand(100000,999999);
        $phoneOtp = rand(100000,999999);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>bcrypt($request->password),
            'email_otp'=>$emailOtp,
            'phone_otp'=>$phoneOtp,
        ]);

        // 📧 Send email OTP
        Mail::raw("Your Email OTP is: $emailOtp", function ($mail) use ($user) {
            $mail->to($user->email)->subject('Email Verification OTP');
        });

        // 📱 Phone OTP (use SMS API like Twilio)
        // sendSms($user->phone, $phoneOtp);

        session(['verify_user_id'=>$user->id]);

        return redirect('verify')->with('success','OTP sent to Email & Phone');
    }

    public function verifyForm() {
        return view('auth.verify');
    }

    public function verifyOtp(Request $request)
    {
        $user = User::find(session('verify_user_id'));

        if(
            $request->email_otp == $user->email_otp &&
            $request->phone_otp == $user->phone_otp
        ){
            $user->update([
                'email_verified'=>true,
                'phone_verified'=>true,
                'email_otp'=>null,
                'phone_otp'=>null
            ]);

            auth()->login($user);
            return redirect('auth.dashboard');
        }

        return back()->with('error','Invalid OTP');
    }

    public function loginForm() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if(auth()->attempt($request->only('email','password'))){
            if(!auth()->user()->email_verified){
                auth()->logout();
                return back()->with('error','Email not verified');
            }
            return redirect('/dashboard');
        }

        return back()->with('error','Invalid login');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('mess');
    }

      public function dashboard()
    {
        return view('dashboard');
    }

    // Dashboard data (AJAX – auto refresh)
 public function dashboardData()
{
    // BOOKINGS - ONE ROW = ONE BOOKING
    $bookings = DB::table('bookings as b')
        ->leftJoin('booking_meals as bm','b.id','=','bm.booking_id')
        ->select(
            'b.id as booking_id',   // ✅ IMPORTANT
            'b.name',
            'b.phone',
            DB::raw('COUNT(bm.id) as total_meals')
        )
        ->groupBy('b.id','b.name','b.phone')
        ->orderBy('b.id','desc')
        ->get();

    // MEAL CHANGES
    $mealChanges = DB::table('meal_changes as mc')
        ->leftJoin('meal_change_items as mci','mc.id','=','mci.meal_change_id')
        ->select(
            'mc.id as meal_change_id',
            'mc.name',
            'mc.phone',
            DB::raw('COUNT(mci.id) as total_meals')
        )
        ->groupBy('mc.id','mc.name','mc.phone')
        ->orderBy('mc.id','desc')
        ->get();

    return response()->json([
        'bookings' => $bookings,
        'meal_changes' => $mealChanges,
        'updated_at' => now()->format('d-m-Y h:i A')
    ]);
}



public function customerMeals(Request $request)
{
    return DB::table('booking_meals as bm')
        ->leftJoin('bookings as b','b.id','=','bm.booking_id')
        ->leftJoin('meal_types as mt','mt.id','=','bm.meal_type_id')
        ->leftJoin('days as d','d.id','=','bm.day_id')
        ->leftJoin('meal_masters as m','m.id','=','bm.meal_id')
        ->where('bm.booking_id', $request->booking_id) // ✅ FIX
        ->select(
            DB::raw("DATE_FORMAT(b.created_at,'%d-%m-%Y') as date"),
            'mt.meal_type',
            'd.day_name',
            'm.name as meal'
        )
        ->orderByRaw("
            CASE 
                WHEN mt.meal_type = 'Breakfast' THEN 1
                WHEN mt.meal_type = 'Lunch' THEN 2
                WHEN mt.meal_type = 'Dinner' THEN 3
                WHEN mt.meal_type = 'Sunday Optional' THEN 4
                ELSE 5
            END
        ")
        ->get();
}

public function mealChangeMeals(Request $request)
{
    return DB::table('meal_change_items as mci')
        ->leftJoin('meal_changes as mc','mc.id','=','mci.meal_change_id')
        ->leftJoin('meal_types as mt','mt.id','=','mci.meal_type_id')
        ->leftJoin('days as d','d.id','=','mci.day_id')
        ->leftJoin('meal_masters as m','m.id','=','mci.meal_id')
        ->where('mci.meal_change_id', $request->meal_change_id)
        ->select(
            DB::raw("DATE_FORMAT(mc.created_at,'%d-%m-%Y') as date"),
            'mt.meal_type',
            'd.day_name',
            'm.name as meal'
        )
        ->orderByRaw("
            CASE 
                WHEN mt.meal_type = 'Breakfast' THEN 1
                WHEN mt.meal_type = 'Lunch' THEN 2
                WHEN mt.meal_type = 'Dinner' THEN 3
                WHEN mt.meal_type = 'Sunday Optional' THEN 4
                ELSE 5
            END
        ")
        ->get();
}



}

