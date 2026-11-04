@extends('layouts.admin')
@section('title','Reports')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<div class="card p-4">
    <h3 class="mb-3">📊 Dynamic Meal Report</h3>

    {{-- Filter Section --}}
    <div class="row g-3 align-items-end mb-4">

        <div class="col-md-3">
            <label class="form-label fw-semibold">Report Type</label>
            <select id="type" class="form-select">
                <option value="booking">Booking Report</option>
                <option value="meal_change">Meal Change Report</option>
                <option value="customer">Customer Wise Report</option>
            </select>
        </div>

        <div class="col-md-3" id="customerFilter" style="display: none;">
            <label class="form-label fw-semibold">Customer ID</label>
            <input type="text" id="customer_id" class="form-control" placeholder="Enter Customer ID">
        </div>

        <div class="col-md-2">
            <label class="form-label fw-semibold">From Date</label>
            <input type="date" id="from_date" class="form-control">
        </div>

        <div class="col-md-2">
            <label class="form-label fw-semibold">To Date</label>
            <input type="date" id="to_date" class="form-control">
        </div>

        <div class="col-md-2 d-grid gap-2">
            <button class="btn btn-primary" id="filterBtn">🔍 Apply</button>
            <button class="btn btn-outline-secondary" id="resetBtn">♻️ Reset</button>
        </div>
    </div>

    {{-- Table --}}
    <table id="reportTable" class="table table-bordered w-100">
        <thead></thead>
    </table>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
let table;

function loadTable(filters = {}) {
    $.get("{{ url('admin/reports/data') }}", filters, function(res){

        if ($.fn.DataTable.isDataTable('#reportTable')) {
            table.destroy();
            $('#reportTable').empty();
        }

        table = $('#reportTable').DataTable({
            data: res.data,
            columns: res.columns,
            ordering: false,
            scrollX: true,
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'print'
            ],
            columnDefs: [
                {
                    targets: '_all',
                    render: function(data) { return data ? data : '-'; }
                }
            ]
        });
    });
}

$(document).ready(function(){

    $('#type').on('change', function(){
        if ($(this).val() === 'customer') {
            $('#customerFilter').show();
        } else {
            $('#customerFilter').hide();
            $('#customer_id').val('');
        }
    });

    loadTable();

    $('#filterBtn').on('click', function(){
        loadTable({
            type: $('#type').val(),
            from_date: $('#from_date').val(),
            to_date: $('#to_date').val(),
            customer_id: $('#customer_id').val()
        });
    });

    $('#resetBtn').on('click', function(){
        $('#type').val('booking').trigger('change');
        $('#from_date').val('');
        $('#to_date').val('');
        $('#customer_id').val('');
        loadTable();
    });
});
</script>
@endpush
