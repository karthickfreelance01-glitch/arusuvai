@extends('layouts.admin')
@section('title', 'Meal Mapping')

@section('content')
<div class="page-header mb-3 d-flex justify-content-between align-items-center">
    <h3 class="page-title mb-0">🍱 Meal Mapping</h3>
    <a href="{{ url('admin/meal-map/create') }}" class="btn btn-primary rounded-pill">
        <i class="mdi mdi-plus"></i> Add Mapping
    </a>
</div>

<div class="card shadow-sm border-0 rounded-4">

    {{-- HEADER --}}
    <div class="card-header bg-primary text-white rounded-top-4">
        <h5 class="mb-0">
            <i class="mdi mdi-table-large me-1"></i> Meal Mapping List
        </h5>
        <small class="opacity-75">Search • Sort • Paginate</small>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        <div class="table-responsive">
            <table id="mealMapTable" class="table table-bordered table-hover align-middle w-100">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Dish</th>
                        <th>Meal Type</th>
                        <th>Day</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($items as $i => $row)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>

                        <td>
                            <strong>🍽️ {{ $row->meal }}</strong>
                        </td>

                        <td class="text-center">
                            <span class="badge bg-info rounded-pill px-3">
                                {{ $row->meal_type }}
                            </span>
                        </td>

                        <td class="text-center">
                            <span class="badge bg-secondary rounded-pill px-3">
                                {{ $row->day_name }}
                            </span>
                        </td>

                        <td class="text-center">
                            <a href="{{ url('admin/meal-map/delete/'.$row->id) }}"
                               onclick="return confirm('Delete this mapping?')"
                               class="btn btn-sm btn-outline-danger rounded-circle">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No meal mappings found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- ================= SCRIPTS ================= --}}

{{-- jQuery (MUST be first) --}}


{{-- DataTables CSS --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

{{-- DataTables JS --}}
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#mealMapTable').DataTable({
        dom: 'lfrtip',
        paging: true,
        ordering: true,
        searching: true,
        info: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        language: {
            search: "🔍 Search",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ mappings",
            paginate: {
                previous: "‹",
                next: "›"
            }
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        @endif

        @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000
        });
        @endif

        @if($errors->any())
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ $errors->first() }}",
            showConfirmButton: false,
            timer: 4000
        });
        @endif

    });
</script>
@endsection
