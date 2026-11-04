@extends('layouts.web')
@section('title','Meal Change')

@section('content')
@include('includes.web.header')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css"/>

<style>
.page-contain{padding-top:90px;background:#f6f8fb;}
.form-wrapper{
    max-width:950px;margin:auto;background:#fff;
    padding:50px 25px;border-radius:28px;
    box-shadow:0 25px 50px rgba(0,0,0,.08);
}
.page-title{text-align:center;font-size:38px;font-weight:800;color:#0d3b66;margin-bottom:40px}

.search-row{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:30px}
@media(max-width:768px){.search-row{grid-template-columns:1fr}}

.search-row input{
    font-size:18px;padding:14px 16px;border-radius:16px;
    border:1.5px solid #d1d5db;
}

.section-title{font-size:20px;font-weight:700;color:#0d3b66;margin:25px 0 10px}
.req{color:#e11d48}

.checkbox-group{display:flex;flex-direction:column;gap:14px}
.checkbox-group label{
    display:flex;align-items:center;gap:14px;
    font-weight:700;font-size:17px;
}
.checkbox-group input{transform:scale(1.4)}

.meal-section{display:none;margin-top:20px}
.meal-section.active{display:block}

.meal-grid{margin-bottom:20px}
.meal-grid h4{margin:15px 0;font-weight:700;color:#e79e11}

.meal-option{
    border:2px solid #e5e7eb;padding:14px 18px;
    border-radius:16px;display:flex;gap:14px;
    align-items:center;background:#f9fafb;
    cursor:pointer;font-weight:700;margin-bottom:10px
}
.meal-option:hover{border-color:#0aa3cf;background:#e0f7ff}
.meal-option input{transform:scale(1.4)}

.update-btn{
    margin-top:40px;width:100%;padding:18px;
    font-size:20px;font-weight:800;
    border-radius:24px;border:none;
    background:#0aa3cf;color:#fff
}

.summary-box{
    margin-top:30px;padding:20px;
    border-radius:18px;background:#f1f5f9;
}
</style>

<div class="page-contain">
<div class="form-wrapper">

<div class="page-title">🍱 Change Your Meal Plan</div>

<form method="POST" action="{{ url('meal-change/store') }}">
@csrf

{{-- CUSTOMER DETAILS --}}
<div class="search-row">
    <input type="text" name="cusid" placeholder="Customer Id" >
    <input type="text" name="name" id="name" placeholder="Registered Name" required>
    <input type="tel" id="phone" placeholder="Mobile Number" required>
</div>

<input type="hidden" name="phone_full" id="phone_full">

{{-- STEP 1 --}}
<div class="section-title">
    Select Required Meal Service <span class="req">*</span>
</div>

<div class="checkbox-group">
@foreach($mealTypes as $type)
<label>
    <input type="checkbox" name="meal_type_selected[]" value="{{ $type->id }}">
    {{ $type->meal_type }}
</label>
@endforeach
</div>

{{-- STEP 2 --}}
<div id="mealSections">
@foreach($mealTypes as $type)
<div class="meal-section" id="section-{{ $type->id }}">
    <div class="section-title">{{ $type->meal_type }}</div>

    @foreach($days as $day)
        @if(isset($mealMappings[$type->id][$day->id]))
        <div class="meal-grid">
            <h4>{{ $day->day_name }}</h4>

            @foreach($mealMappings[$type->id][$day->id] as $meal)
            <label class="meal-option">
                <input type="radio"
                       class="meal-radio"
                       name="meals[{{ $type->id }}][{{ $day->id }}]"
                       value="{{ $meal->meal_id }}"
                       data-type="{{ $type->meal_type }}"
                       data-day="{{ $day->day_name }}"
                       data-meal="{{ $meal->meal }}">
                {{ $meal->meal }}
            </label>
            @endforeach
        </div>
        @endif
    @endforeach
</div>
@endforeach
</div>

{{-- SUMMARY --}}
<div class="summary-box">
<strong>Selected Meals</strong>
<ul id="summaryList"></ul>
</div>

<button class="update-btn">Submit Meal Change</button>
</form>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

<script>
const phoneInput = document.getElementById('phone');
const phoneFull  = document.getElementById('phone_full');
const summaryList= document.getElementById('summaryList');

const iti = intlTelInput(phoneInput,{
    initialCountry:"in",
    separateDialCode:true,
    utilsScript:"https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
});

phoneInput.addEventListener('input',()=>{
    phoneInput.value = phoneInput.value.replace(/\D/g,'');
});

/* Meal Type Toggle */
document.querySelectorAll('input[name="meal_type_selected[]"]').forEach(chk=>{
    chk.addEventListener('change',()=>{
        const sec=document.getElementById('section-'+chk.value);
        if(chk.checked){
            sec.classList.add('active');
        }else{
            sec.classList.remove('active');
            sec.querySelectorAll('input[type=radio]').forEach(r=>r.checked=false);
            updateSummary();
        }
    });
});

/* Summary */
document.querySelectorAll('.meal-radio').forEach(r=>{
    r.addEventListener('change',updateSummary);
});

function updateSummary(){
    summaryList.innerHTML='';
    const selected=document.querySelectorAll('.meal-radio:checked');

    if(!selected.length){
        summaryList.innerHTML='<li>No meals selected</li>';
        return;
    }

    selected.forEach(r=>{
        const li=document.createElement('li');
        li.textContent=`${r.dataset.type} → ${r.dataset.day} : ${r.dataset.meal}`;
        summaryList.appendChild(li);
    });
}

/* Submit Validation */
document.querySelector('form').addEventListener('submit',e=>{
    phoneFull.value = iti.getNumber();

    const types=document.querySelectorAll('input[name="meal_type_selected[]"]:checked');
    const meals=document.querySelectorAll('.meal-radio:checked');

    if(!types.length || !meals.length){
        e.preventDefault();
        alert('Please select meal service and meals');
    }
});
</script>

@include('includes.web.footer')
@endsection
