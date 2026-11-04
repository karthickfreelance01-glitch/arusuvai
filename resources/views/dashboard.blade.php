@extends('layouts.admin')
@section('title','Dashboard')

@section('content')

<div class="page-header mb-4">
    <h3 class="fw-bold">📊 Dashboard</h3>
    <p class="text-muted mb-1">Auto refreshed every 1 minute</p>
    <small class="text-muted">
        Last updated: <span id="lastUpdated">--</span>
    </small>
</div>

{{-- ================= BOOKINGS ================= --}}
<div class="card mb-4 shadow-sm rounded-4">
    <div class="card-header fw-semibold">
        📌 Booking Reports
    </div>

    <div class="table-responsive">
        <table class="table table-bordered mb-0" id="bookingTable">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Total Meals</th>
                    <th width="120">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="text-center text-muted">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ================= MEAL CHANGES ================= --}}
<div class="card shadow-sm rounded-4">
    <div class="card-header fw-semibold">
        🔁 Meal Change Reports
    </div>

    <div class="table-responsive">
        <table class="table table-bordered mb-0" id="mealChangeTable">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Total Meals</th>
                    <th width="120">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="text-center text-muted">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ================= MODAL ================= --}}
<div class="modal fade" id="mealModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTitle">🍽 Meal Details</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Meal Type</th>
                                <th>Day</th>
                                <th>Meal</th>
                            </tr>
                        </thead>
                        <tbody id="mealBody">
                            <tr>
                                <td colspan="4" class="text-center text-muted">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    // ================= LOAD DASHBOARD =================
    function loadDashboardData() {
        $.get("{{ url('admin/dashboard/data') }}", function (res) {

            // BOOKINGS
            let bookingHtml = '';
            if (res.bookings.length === 0) {
                bookingHtml = `<tr><td colspan="4" class="text-center text-muted">No bookings found</td></tr>`;
            } else {
                res.bookings.forEach(row => {
                    bookingHtml += `
                        <tr>
                            <td>${row.name}</td>
                            <td>${row.phone}</td>
                            <td><span class="badge bg-success">${row.total_meals}</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary viewBooking"
                                    data-id="${row.booking_id}">
                                    View
                                </button>
                            </td>
                        </tr>`;
                });
            }
            $('#bookingTable tbody').html(bookingHtml);

            // MEAL CHANGES
            let mealHtml = '';
            if (res.meal_changes.length === 0) {
                mealHtml = `<tr><td colspan="4" class="text-center text-muted">No meal changes found</td></tr>`;
            } else {
                res.meal_changes.forEach(row => {
                    mealHtml += `
                        <tr>
                            <td>${row.name}</td>
                            <td>${row.phone}</td>
                            <td><span class="badge bg-warning text-dark">${row.total_meals}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning viewMealChange"
                                    data-id="${row.meal_change_id}">
                                    View
                                </button>
                            </td>
                        </tr>`;
                });
            }
            $('#mealChangeTable tbody').html(mealHtml);

            $('#lastUpdated').text(res.updated_at);
        });
    }

    loadDashboardData();
    setInterval(loadDashboardData, 60000);

    // ================= VIEW BOOKING =================
    $(document).on('click', '.viewBooking', function () {
        viewMeals(
            "{{ url('admin/customer/meals') }}",
            { booking_id: $(this).data('id') },
            '🍽 Booking Meal Details'
        );
    });

    // ================= VIEW MEAL CHANGE =================
    $(document).on('click', '.viewMealChange', function () {
        viewMeals(
            "{{ url('admin/meal-change/meals') }}",
            { meal_change_id: $(this).data('id') },
            '🔁 Changed Meal Details'
        );
    });

    // ================= COMMON VIEW FUNCTION =================
    function viewMeals(url, data, title) {

        $('#modalTitle').text(title);
        $('#mealBody').html(`<tr><td colspan="4" class="text-center text-muted">Loading...</td></tr>`);
        $('#mealModal').modal('show');

        $.get(url, data, function (res) {

            let html = '';
            let currentMealType = '';

            if (res.length === 0) {
                html = `<tr><td colspan="4" class="text-center text-muted">No meals found</td></tr>`;
            } else {

                res.forEach(row => {

                    if (currentMealType !== row.meal_type) {
                        currentMealType = row.meal_type;
                        html += `
                            <tr class="table-secondary">
                                <td colspan="4" class="fw-bold text-uppercase">
                                    🍽 ${currentMealType}
                                </td>
                            </tr>`;
                    }

                    html += `
                        <tr>
                            <td>${row.date}</td>
                            <td>${row.meal_type}</td>
                            <td>${row.day_name ?? '-'}</td>
                            <td>${row.meal ?? '-'}</td>
                        </tr>`;
                });
            }

            $('#mealBody').html(html);
        });
    }

});
</script>
@endpush
