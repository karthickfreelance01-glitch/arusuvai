@extends('layouts.admin')
@section('content')

<div class="card">
<div class="card-header bg-primary text-white">Meal Master</div>
<div class="card-body">

<form method="POST" action="{{url('admin/meals/store')}}">
@csrf
<input name="name" class="form-control mb-2" placeholder="IDLI / SAMBAR">
<button class="btn btn-success">Add Meal</button>
</form>

<hr>

<ul class="list-group">
@foreach($meals as $m)
<li class="list-group-item">{{ $m->name }}</li>
@endforeach
</ul>

</div>
</div>

@endsection
