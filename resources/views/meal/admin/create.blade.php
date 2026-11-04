  @extends('layouts.admin')
  @section('title', 'Meal Mapping')

  @section('content')

  <div class="page-header mb-3">
      <h3 class="page-title">Meal Mapping</h3>
  </div>

  <form method="POST" action="{{url('admin/meal-map/store')}}">
  @csrf

  <div class="card shadow-sm border-0 rounded-4">

      {{-- HEADER --}}
      <div class="card-header bg-gradient bg-primary text-white rounded-top-4">
          <h5 class="mb-0">
              <i class="mdi mdi-link-variant me-1"></i>
              Map Meal to Days & Types
          </h5>
          <small class="opacity-75">
              Same dish can be reused for multiple days & meal types
          </small>
      </div>

      <div class="card-body">

          {{-- MEAL --}}
          <div class="mb-4">
              <label class="fw-semibold mb-1">🍽️ Select Dish</label>
              <select name="meal_id" class="form-select form-select-lg" required>
                  @foreach($meals as $m)
                  <option value="{{ $m->id }}">{{ $m->name }}</option>
                  @endforeach
              </select>
          </div>

          <div class="row g-4">

              {{-- MEAL TYPES --}}
              <div class="col-md-6">
                  <label class="fw-semibold mb-2 d-block">
                      ⏰ Select Meal Types
                  </label>

                  <div class="border rounded-3 p-3">
                      @foreach($mealTypes as $t)
                      <div class="form-check mb-2">
                          <input class="form-check-input"
                                type="checkbox"
                                name="meal_type_ids[]"
                                value="{{ $t->id }}"
                                id="mealType{{ $t->id }}">
                          <label class="form-check-label fw-semibold"
                                for="mealType{{ $t->id }}">
                              {{ $t->meal_type }}
                          </label>
                      </div>
                      @endforeach
                  </div>
              </div>

              {{-- DAYS --}}
              <div class="col-md-6">
                  <label class="fw-semibold mb-2 d-block">
                      📅 Select Days
                  </label>

                  <div class="border rounded-3 p-3">
                      @foreach($days as $d)
                      <div class="form-check mb-2">
                          <input class="form-check-input"
                                type="checkbox"
                                name="day_ids[]"
                                value="{{ $d->id }}"
                                id="day{{ $d->id }}">
                          <label class="form-check-label fw-semibold"
                                for="day{{ $d->id }}">
                              {{ $d->day_name }}
                          </label>
                      </div>
                      @endforeach
                  </div>
              </div>

          </div>

          {{-- ACTION --}}
          <div class="mt-4 d-flex justify-content-end gap-2">
              <a href="/admin/meal-map" class="btn btn-light">Cancel</a>
              <button class="btn btn-success px-4">
                  <i class="mdi mdi-check-circle-outline me-1"></i>
                  Save Mapping
              </button>
          </div>

      </div>
  </div>
  </form>

  {{-- STYLE --}}
  <style>
  .bg-gradient{
      background: linear-gradient(135deg,#4f46e5,#3b82f6);
  }
  .form-check-input{
      cursor:pointer;
  }
  </style>

  @endsection
