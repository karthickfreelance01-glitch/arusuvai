@extends('layouts.admin')
@section('title', 'Days')

@section('content')
<div class="page-header mb-3">
    <h3 class="page-title">Day Management</h3>
</div>

<div class="row">

    {{-- LEFT TABS --}}
    <div class="col-lg-3">
        <div class="card shadow-sm">
            <div class="card-body p-2">
                <div class="product-tabs">

                    <div class="tab-item active" data-tab="list">
                        <div class="icon bg-primary">
                            <i class="mdi mdi-calendar"></i>
                        </div>
                        <div>
                            <h6>Day List</h6>
                            <small>View & manage</small>
                        </div>
                    </div>

                    <div class="tab-item" data-tab="add">
                        <div class="icon bg-success">
                            <i class="mdi mdi-plus-box"></i>
                        </div>
                        <div>
                            <h6>Add Day</h6>
                            <small>Create new</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT CONTENT --}}
    <div class="col-lg-9">
        <div class="tab-content">

            {{-- LIST --}}
            <div class="tab-pane active" id="list">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Days</h4>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Day Name</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($days as $i => $d)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td><strong>{{ $d->day_name }}</strong></td>
                                    <td>
                                        <form method="POST" action="{{ route('days.destroy',$d->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No Days Found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            {{-- ADD --}}
            <div class="tab-pane" id="add">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add Day</h4>

                        <form method="POST" action="{{ route('days.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label>Day Name</label>
                                <input type="text" name="day_name" class="form-control" placeholder="Monday" required>
                            </div>

                            

                            <button class="btn btn-primary w-100">
                                Save Day
                            </button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- JS --}}
<script>
document.querySelectorAll('.tab-item').forEach(tab => {
    tab.addEventListener('click', function () {
        document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));

        this.classList.add('active');
        document.getElementById(this.dataset.tab).classList.add('active');
    });
});
</script>

{{-- STYLES --}}
<style>
.product-tabs{display:flex;flex-direction:column;gap:14px}
.tab-item{display:flex;gap:14px;padding:14px;border-radius:14px;cursor:pointer;background:#f8f9fa;transition:.3s;border-left:5px solid transparent}
.tab-item:hover{background:#eef2ff;transform:translateX(6px)}
.tab-item.active{background:#eef2ff;border-left-color:#4f46e5}
.tab-item .icon{width:44px;height:44px;border-radius:12px;color:#fff;display:flex;align-items:center;justify-content:center}
.tab-pane{display:none}
.tab-pane.active{display:block;animation:fade .3s ease}
@keyframes fade{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
</style>

@endsection
