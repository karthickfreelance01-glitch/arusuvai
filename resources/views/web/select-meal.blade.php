@extends('layouts.web')
@section('title','Select Meal')

@section('content')
@include('includes.web.header')

<style>
/* ===== PAGE CONTAINER (TOP FIX SAME AS BOOK NOW) ===== */
.page-contain{
    padding-top:60px;
    padding-bottom:60px;
}

/* ===== MAIN CARD (SAME AS BOOK NOW) ===== */
.booking-wrapper{
    max-width:1100px;
    margin:0 auto;
    background:#fff;
    border-radius:26px;
    padding:45px 40px;
    box-shadow:0 25px 50px rgba(0,0,0,.08);
}

/* ===== TITLE ===== */
.main-title{
    text-align:center;
    font-size:32px;
    font-weight:800;
    color:#0d3b66;
    margin-bottom:35px;
}

/* ===== TABS ===== */
.meal-tabs{
    display:flex;
    gap:16px;
    overflow-x:auto;
    margin-bottom:30px
}
.meal-tab{
    padding:4px 26px;
    border-radius:18px;
    border:2px solid #e5e7eb;
    background:#f9fafb;
    font-size:18px;
    font-weight:700;
    cursor:pointer;
    white-space:nowrap
}
.meal-tab.active{
    background:#007acc;
    color:#fff;
    border-color:#007acc
}

/* ===== DAY CARD ===== */
.day-card{
    border:2px solid #e5e7eb;
    border-radius:22px;
    padding:26px;
    margin-bottom:26px
}
.day-title{
    font-size:22px;
    font-weight:800;
    margin-bottom:18px;
}

/* ===== MEAL GRID ===== */
.meal-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(190px,1fr));
    gap:18px
}
.meal-option input{display:none}

/* ===== MEAL CARD ===== */
.meal-card{
    padding:7px;
    border-radius:20px;
    border:2px solid #e5e7eb;
    cursor:pointer;
    transition:.2s;
}
.meal-option input:checked + .meal-card{
    background:#28a745;
    color:#fff;
    border-color:#28a745
}

/* ===== BADGES ===== */
.meal-badge{
    padding:6px 14px;
    border-radius:30px;
    font-size:10px;
    font-weight:700;
    display:inline-block;
    margin-bottom:8px
}
.badge-breakfast{background:#fff3cd;color:#856404}
.badge-lunch{background:#d4edda;color:#155724}
.badge-dinner{background:#d1ecf1;color:#0c5460}

.meal-name{
    font-size:13px;
    font-weight:700;
}

/* ===== SUMMARY ===== */
.summary-box{
    margin-top:35px;
    padding:24px;
    border-radius:22px;
    background:#f0f9ff;
    border:2px dashed #007acc
}
.summary-title{
    font-size:20px;
    font-weight:800;
}

/* ===== BUTTON (SAME STYLE AS BOOK NOW) ===== */
.next-btn{
    margin-top:40px;
    width:100%;
    padding:18px;
    font-size:20px;
    font-weight:800;
    border-radius:22px;
    border:none;
    background:#007acc;
    color:#fff;
}
.next-btn:hover{
    background:#005fa3;
}

/* ===== MOBILE ===== */
@media(max-width:600px){
    .booking-wrapper{
        padding:35px 22px;
    }
    .main-title{
        font-size:26px;
    }
}
</style>

<div class="page-contain">
<div class="booking-wrapper">

    <div class="main-title">🍽 Choose Your Meals</div>

    <form method="POST" action="{{ url('book-now/confirm') }}">
    @csrf

    {{-- ===== TABS ===== --}}
    <div class="meal-tabs">
        @foreach($mealTypes as $i=>$type)
        <div class="meal-tab {{ $i==0?'active':'' }}" data-type="{{ $type->id }}">
            {{ $type->meal_type }}
        </div>
        @endforeach
    </div>

    {{-- ===== DAYS ===== --}}
    @foreach($days as $day)
    <div class="day-card">

        <div class="day-title">{{ $day->day_name }}</div>

        @foreach($mealTypes as $type)
        <div class="meal-type-block" data-type="{{ $type->id }}" style="{{ $loop->first?'':'display:none' }}">

            <div class="meal-grid">
                @if(isset($mealMappings[$type->id][$day->id]))
                @foreach($mealMappings[$type->id][$day->id] as $meal)

                <label class="meal-option">
                    <input type="checkbox"
                           name="meals[{{ $day->id }}][{{ $type->id }}][]"
                           value="{{ $meal->id }}">

                    <div class="meal-card">
                        @if($meal->meal_type=='Breakfast')
                        <span class="meal-badge badge-breakfast">🍳 Breakfast</span>
                        @elseif($meal->meal_type=='Lunch')
                        <span class="meal-badge badge-lunch">🍛 Lunch</span>
                        @else
                        <span class="meal-badge badge-dinner">🍽 Dinner</span>
                        @endif

                        <div class="meal-name">{{ $meal->meal }}</div>
                    </div>
                </label>

                @endforeach
                @endif
            </div>

        </div>
        @endforeach

    </div>
    @endforeach

    {{-- ===== SUMMARY ===== --}}
    <div class="summary-box">
        <div class="summary-title">✅ Your Selection</div>
        <div id="summaryText">Select meals to continue</div>
    </div>

    <button class="next-btn">Confirm & Continue</button>

    </form>
</div>
</div>

<script>
const tabs=document.querySelectorAll('.meal-tab');
const blocks=document.querySelectorAll('.meal-type-block');
const summary=document.getElementById('summaryText');

tabs.forEach(tab=>{
    tab.onclick=()=>{
        tabs.forEach(t=>t.classList.remove('active'));
        tab.classList.add('active');
        blocks.forEach(b=>{
            b.style.display = b.dataset.type === tab.dataset.type ? 'block' : 'none';
        });
    };
});

document.addEventListener('change',()=>{
    let data={};
    document.querySelectorAll('.meal-option input:checked').forEach(i=>{
        let day=i.closest('.day-card').querySelector('.day-title').innerText;
        let badge=i.nextElementSibling.querySelector('.meal-badge').innerText;
        let name=i.nextElementSibling.querySelector('.meal-name').innerText;
        if(!data[day]) data[day]=[];
        data[day].push(`${badge} - ${name}`);
    });

    if(!Object.keys(data).length){
        summary.innerHTML="Select meals to continue";
        return;
    }

    let html='';
    for(let d in data){
        html+=`<b>${d}</b><br>`;
        data[d].forEach(m=>html+=`• ${m}<br>`);
        html+='<br>';
    }
    summary.innerHTML=html;
});
</script>

@include('includes.web.footer')
@endsection
