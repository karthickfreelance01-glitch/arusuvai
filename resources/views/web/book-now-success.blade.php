@extends('layouts.web')
@section('title','Booking Confirmed')

@section('content')
@include('includes.web.header')

<style>
.success-wrap{
    min-height:80vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#e0f7ff,#f6f8fb);
}
.success-card{
    background:#fff;
    max-width:520px;
    width:100%;
    padding:50px 35px;
    border-radius:30px;
    text-align:center;
    box-shadow:0 30px 60px rgba(0,0,0,.15);
}
.success-icon{
    width:90px;
    height:90px;
    background:#dcfce7;
    color:#166534;
    font-size:44px;
    font-weight:900;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto 25px;
}
.success-card h1{
    font-size:30px;
    font-weight:900;
    color:#0d3b66;
    margin-bottom:15px;
}
.success-card p{
    font-size:18px;
    color:#374151;
    line-height:1.7;
}
.success-btn{
    margin-top:30px;
    display:inline-block;
    padding:14px 36px;
    border-radius:999px;
    background:#0aa3cf;
    color:#fff;
    font-size:18px;
    font-weight:800;
    text-decoration:none;
}
.success-btn:hover{
    background:#078cb2;
}
.brand{
    margin-top:25px;
    font-weight:700;
    color:#e79e11;
    letter-spacing:1px;
}
</style>

<div class="success-wrap" style="padding-top:90px;">
    <div class="success-card">
        <div class="success-icon">✓</div>

        <h1>Booking Confirmed!</h1>

        <p>
            Thank you for choosing <strong>Arusuvai</strong> ❤️<br>
            Your meal service booking has been successfully confirmed.<br>
            Our team will contact you shortly to assist you further.
        </p>

        <a href="{{ url('/') }}" class="success-btn">Back to Home</a>

        <div class="brand">ARUSUVAI</div>
    </div>
</div>

@include('includes.web.footer')
@endsection
