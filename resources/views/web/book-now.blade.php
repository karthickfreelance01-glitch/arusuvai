@extends('layouts.web')
@section('title','Book Now')

@section('content')
@include('includes.web.header')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css"/>
<style>
/* ================= PAGE ================= */
.page-contain{padding-top: 90px; background:#f6f8fb; }

/* ================= FORM CARD ================= */
.form-wrapper{ 
    max-width:950px; margin:auto; background:#fff; 
    padding:50px 25px; border-radius:28px; 
    box-shadow:0 25px 50px rgba(0,0,0,.08); 
}
.page-title{ 
    text-align:center; font-size:38px; font-weight:800; color:#0d3b66; margin-bottom:50px; 
}

/* ================= GRID ================= */
.form-row{ display:grid; grid-template-columns:repeat(2,1fr); gap:30px; margin-bottom:25px; }
@media(max-width:768px){ .form-row{grid-template-columns:1fr;} }

/* ================= LABEL ================= */
.label-title{ font-size:18px; font-weight:700; margin-bottom:10px; color:#374151; }
.req{color:#e11d48; font-size:18px;}

/* ================= INPUTS ================= */
input, textarea, select{
    font-size:18px; padding:12px 14px;
    border-radius:16px; border:1.5px solid #d1d5db; outline:none; transition:0.3s;
}
input:focus, textarea:focus, select:focus{ border-color:#0aa3cf; box-shadow:0 0 8px rgba(10,163,207,0.3); }
textarea{ resize:none; height:100px; }

/* ================= CHECKBOX / RADIO CLEAN UI ================= */
.checkbox-group, .radio-group{
    display:flex; flex-direction:column; gap:15px;
}
.checkbox-group label, .radio-group label{
    display:flex; align-items:center; gap:15px; font-weight:700; font-size:17px; cursor:pointer;
}
.checkbox-group input, .radio-group input{
    transform:scale(1.4); margin-right:0; flex-shrink:0;
}

/* ================= MEAL SELECTION ================= */
.meal-section{ display:none; margin-top:35px; }
.meal-section.active{ display:block; }
.meal-section .section-title{ font-size:20px; font-weight:700; margin-bottom:16px; color:#0d3b66; }

/* Meal grid */
.meal-grid{ display:grid; grid-template-columns:1fr; gap:14px; }
.meal-grid h2{ font-size:18px; font-weight:700; margin-bottom:8px;color: #e79e11;margin-top: 11px; }
.meal-grid label{
    border:2px solid #e5e7eb; padding:14px 18px; border-radius:16px;
    display:flex; align-items:center; justify-content:flex-start; cursor:pointer;
    background:#f9fafb; transition:0.3s; font-weight:700; font-size:16px;
}
.meal-grid label:hover{ border-color:#0aa3cf; background:#e0f7ff; }

/* ================= SUMMARY ================= */
.summary-box{ margin-top:35px; padding:18px; background:#d1fae5; border-radius:16px; font-size:17px; min-height:50px; }

/* ================= BUTTON ================= */
.next-btn{ margin-top:30px; width:100%; padding:18px; font-size:20px; font-weight:800; border-radius:24px; border:none; background:#0aa3cf; color:#fff; cursor:pointer; }
.next-btn:hover{ background:#078cb2; }
.meals_check{ width: 30px; transform: scale(1.6); }

/* ================= FLATPICKR CUSTOM ================= */
/* ================= FLATPICKR FIX ================= */
.flatpickr-calendar {
    border-radius: 18px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    font-family: inherit;
}

.flatpickr-day {
    height: 44px;
    line-height: 44px;
    font-size: 16px;
    border-radius: 10px;
}

.flatpickr-day.selected,
.flatpickr-day.startRange,
.flatpickr-day.endRange {
    background: #0aa3cf;
    border-color: #0aa3cf;
    color: #fff;
}

.flatpickr-day.today {
    border: 2px solid #0aa3cf;
}

.flatpickr-input {
    height: 56px;
    font-size: 18px;
    padding: 14px 16px;
    border-radius: 16px;
    border: 1.5px solid #d1d5db;
}
.form-control{
   font-size: 19px;
}
.meal-option{
    border:2px solid #e5e7eb;
    padding:14px 18px;
    border-radius:16px;
    display:flex;
    align-items:center;
    gap:14px;
    cursor:pointer;
    background:#f9fafb;
    transition:0.3s;
}
.meal-option:hover{
    border-color:#0aa3cf;
    background:#e0f7ff;
}
.meal-option input{
    transform:scale(1.4);
}

</style>

<div class="page-contain">
<div class="form-wrapper">
@if(session('success'))
    <div style="
        background:#dcfce7;
        color:#166534;
        padding:16px 20px;
        border-radius:16px;
        font-weight:700;
        margin-bottom:25px;
        box-shadow:0 10px 20px rgba(0,0,0,0.08);
    ">
        ✅ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="
        background:#fee2e2;
        color:#991b1b;
        padding:16px 20px;
        border-radius:16px;
        font-weight:700;
        margin-bottom:25px;
        box-shadow:0 10px 20px rgba(0,0,0,0.08);
    ">
        ❌ {{ session('error') }}
    </div>
@endif

<div class="page-title " >🍽 Book Your Meal Service</div>

<form method="POST" action="{{ url('book-now/confirm') }}">
@csrf

{{-- LANGUAGE & PAYMENT --}}
<div class="form-row">
    <div>
        <div class="label-title">Preferred language <span class="req">*</span></div>
        <div class="radio-group">
            <label><input type="radio" name="language" value="English" required> English</label>
            <label><input type="radio" name="language" value="Tamil"> Tamil</label>
            <label><input type="radio" name="language" value="Malayalam"> Malayalam</label>
            <label><input type="radio" name="language" value="Hindi"> Hindi</label>
        </div>
    </div>
    <div>
        <div class="label-title">Payment mode <span class="req">*</span></div>
        <div class="radio-group">
            <label><input type="radio" name="payment_mode" value="Bank" required> Bank</label>
            <label><input type="radio" name="payment_mode" value="Cash"> Cash</label>
        </div>
        {{-- BANK DETAILS --}}
        <div id="bankDetails" style="display:none; margin-top:25px;">
            <div class="section-title">🏦 Bank Details</div>

            <div style="
                background:#f0f9ff;
                border:2px dashed #0aa3cf;
                border-radius:18px;
                padding:20px;
                font-size:16px;
                line-height:1.8;
                color:#0d3b66;
                font-weight:600;
            ">
                <div><strong>Account Number:</strong> 0333589112001</div>
                <div><strong>Account Holder:</strong> ARUSUVAI RESTAURANTS MANAGEMENT CO. L.L.C</div>
                <div><strong>Bank Name:</strong> RAK BANK</div>
                <div><strong>IBAN:</strong> AE690400000333589112001</div>
            </div>
        </div>
    </div>
</div>

<br>

{{-- BASIC DETAILS --}}
<div class="form-row">
    <div>
        <div class="label-title">Start Service Date <span class="req">*</span></div>
        <input type="text" id="start_date" name="start_date" >
    </div>
     <!-- <div>
        <div class="label-title">Customer Id <span class="req">*</span></div>
        <input type="text" name="cus_id" required>
    </div> -->
    <div> 
        <div class="label-title">Name <span class="req">*</span></div>
        <input type="text" name="name" required>
    </div>
</div>

<br>

<div class="form-row">
    <div>
        <div class="label-title">Phone <span class="req">*</span></div>
        <input type="tel" id="phone" name="phone" required>
        <input type="hidden" name="phone_full" id="phone_full">

    </div>
    

    <div>
        <div class="label-title">Whatsapp Number <span class="req">*</span></div>
        <input type="tel" id="whatsapp" name="whatsapp" >        
        <input type="hidden" name="whatsapp_full" id="whatsapp_full">
    </div>
</div>

<br>

{{-- ROOM & LOCATION --}}
<div class="form-row">
    <div>
        <div class="label-title">Room Number <span class="req">*</span></div>
        <input type="text" name="room_no" >
    </div>
    <div>
        <div class="label-title">Building Name <span class="req">*</span></div>
        <input type="text" name="building_name" >
    </div>
</div>

<br>

<div class="form-row">
    <div>
        <div class="label-title">Area / City <span class="req">*</span></div>
        <input type="text" name="area" >
    </div>
    <div>
        <div class="label-title">Morning Location <span class="req">*</span></div>
        <input type="text" name="morning_location" >
    </div>
</div>

<br>

<div class="form-row">
    <div>
        <div class="label-title">Dinner Location <span class="req">*</span></div>
        <input type="text" name="dinner_location" >
    </div>
    <div>
        <div class="label-title">Sunday Location <span class="req">*</span></div>
        <input type="text" name="sunday_location" >
    </div>
</div>

<br>

{{-- STEP 1: MULTI-SELECT MEAL SERVICE TYPE --}}
<div class="meal-section active" id="meal-service-select">
    <div class="section-title">Select Required Meal Service <span class="req">*</span></div>
    <div class="checkbox-group">
        @foreach($mealTypes as $type)
            <label>
                <input type="checkbox" name="meal_type_selected[]" value="{{ $type->id }}">
                {{ $type->meal_type }}
            </label>
        @endforeach
    </div>
</div>

{{-- STEP 2: DAY-WISE MEALS --}}
@foreach($mealTypes as $type)
<div class="meal-section" id="section-{{ $type->id }}">
    <div class="section-title">{{ $type->meal_type }} - Select Day-wise Meals</div>
    @foreach($days as $day)
        @if(isset($mealMappings[$type->id][$day->id]))
        <div class="meal-grid">
            <h2>{{ $day->day_name }}</h2>
            @foreach($mealMappings[$type->id][$day->id] as $meal)
            
           <label class="meal-option">
                <input type="radio"
                    name="meals[{{ $type->id }}][{{ $day->id }}]"
                    value="{{ $meal->meal_id }}"
                    data-day="{{ $day->day_name }}"
                    data-meal="{{ $meal->meal }}"
                    data-type="{{ $type->meal_type }}"
                    class="meal-radio">

                <span>{{ $meal->meal }}</span>
            </label>

            @endforeach
        </div>
        @endif
    @endforeach
</div>
@endforeach

{{-- SUMMARY --}}
<div class="summary-box" id="summaryBox">
    <strong>Selected Meals</strong>
    <ul id="summaryList" style="margin-top:10px;padding-left:18px;"></ul>
</div>


<button class="next-btn">Confirm & Continue</button>

</form>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
<script>
flatpickr("#start_date", {
    minDate: "today",
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "F j, Y",
    allowInput: false,
    disableMobile: true
});
</script>


<script>
const phoneInput = document.querySelector("#phone");
const whatsappInput = document.querySelector("#whatsapp");

const phoneFull = document.querySelector("#phone_full");
const whatsappFull = document.querySelector("#whatsapp_full");

const itiPhone = intlTelInput(phoneInput, {
    initialCountry: "in",
    separateDialCode: true,
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
});

const itiWhatsapp = intlTelInput(whatsappInput, {
    initialCountry: "in",
    separateDialCode: true,
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
});

document.querySelector('form').addEventListener('submit', function () {

    // PHONE (required)
    if (itiPhone.isValidNumber()) {
        phoneFull.value = itiPhone.getNumber(); // +91XXXXXXXXXX
    } else {
        alert('Please enter a valid phone number');
        event.preventDefault();
        return;
    }

    // WHATSAPP (optional)
    if (whatsappInput.value.trim() !== '') {
        if (itiWhatsapp.isValidNumber()) {
            whatsappFull.value = itiWhatsapp.getNumber();
        } else {
            alert('Please enter a valid WhatsApp number');
            event.preventDefault();
            return;
        }
    } else {
        whatsappFull.value = null;
    }
});
</script>


<script>
const summaryList = document.getElementById('summaryList');

document.querySelectorAll('.meal-radio').forEach(radio => {
    radio.addEventListener('change', updateSummary);
});

function updateSummary(){
    summaryList.innerHTML = '';
    const selected = document.querySelectorAll('.meal-radio:checked');

    selected.forEach(r => {
        const li = document.createElement('li');
        li.textContent = `${r.dataset.type} → ${r.dataset.day} : ${r.dataset.meal}`;
        summaryList.appendChild(li);
    });

    if(selected.length === 0){
        summaryList.innerHTML = '<li>No meals selected</li>';
    }
}
</script>
<script>
document.querySelectorAll('input[name="meal_type_selected[]"]').forEach(chk => {
    chk.addEventListener('change', function () {
        const section = document.getElementById('section-' + this.value);

        if (this.checked) {
            section.classList.add('active');
            section.scrollIntoView({ behavior: 'smooth' });
        } else {
            section.classList.remove('active');
            section.querySelectorAll('input[type=radio]').forEach(r => r.checked = false);
            updateSummary();
        }
    });
});
</script>

<script>
const paymentRadios = document.querySelectorAll('input[name="payment_mode"]');
const bankDetails = document.getElementById('bankDetails');

paymentRadios.forEach(radio => {
    radio.addEventListener('change', function () {
        if (this.value === 'Bank') {
            bankDetails.style.display = 'block';
            bankDetails.scrollIntoView({ behavior: 'smooth' });
        } else {
            bankDetails.style.display = 'none';
        }
    });
});
</script>
<script>
document.querySelector('form').addEventListener('submit', function(e){
    const checkedTypes = document.querySelectorAll('input[name="meal_type_selected[]"]:checked');
    const checkedMeals = document.querySelectorAll('.meal-radio:checked');

    if (checkedTypes.length > 0 && checkedMeals.length === 0) {
        e.preventDefault();
        alert('Please select meals for chosen meal service');
    }
});
</script>



@include('includes.web.footer')
@endsection
