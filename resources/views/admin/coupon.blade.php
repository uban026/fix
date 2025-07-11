@extends('layouts.layout-admin')

@section('title', 'Coupons')

@section('header_title', 'Coupons')
@section('header_subtitle', 'Manage your discount coupons')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Coupons List</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCouponModal">
            <i class="bi bi-plus-circle me-2"></i>Add Coupon
        </button>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{ route('admin.coupons.index') }}" method="GET" class="mb-3 d-flex align-items-center">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Search coupons..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->name }}</td>
                            <td class="text-capitalize">{{ $coupon->type }}</td>
                            <td>
                                {{ $coupon->type === 'percent' ? $coupon->value . '%' : 'Rp ' . number_format($coupon->value, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $coupon->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($coupon->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($coupon->id != 1)
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#editCouponModal{{ $coupon->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-ticket-perforated display-4"></i><br>No coupons found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $coupons->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Coupon Modal -->
    <div class="modal fade" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.coupons.store') }}" method="POST" class="coupon-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Coupon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="amount" {{ old('type') == 'amount' ? 'selected' : '' }}>Amount (Rp)
                                </option>
                                <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percent (%)
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Value <span class="text-danger">*</span></label>
                            <input type="number" name="value" class="form-control" required min="1"
                                value="{{ old('value') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="deactive" {{ old('status') == 'deactive' ? 'selected' : '' }}>Deactive
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save
                            Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Coupon Modals -->
    @foreach ($coupons as $coupon)
    <div class="modal fade" id="editCouponModal{{ $coupon->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" class="coupon-form">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Coupon: {{ $coupon->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" name="name" class="form-control" required
                                value="{{ old('name', $coupon->name) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select" required>
                                <option value="amount" {{ $coupon->type === 'amount' ? 'selected' : '' }}>Amount (Rp)
                                </option>
                                <option value="percent" {{ $coupon->type === 'percent' ? 'selected' : '' }}>Percent (%)
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Value</label>
                            <input type="number" name="value" class="form-control" required min="1"
                                value="{{ old('value', $coupon->value) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ $coupon->status === 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="deactive" {{ $coupon->status === 'deactive' ? 'selected' : '' }}>Deactive
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update
                            Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Show modal if there are validation errors
@if($errors->any())
var modalId = '{{ old('
_modal_id ', '
#addCouponModal ') }}';
var modal = new bootstrap.Modal(document.querySelector(modalId));
modal.show();
@endif

// Show success message
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: "{{ session('success') }}",
    showConfirmButton: false,
    timer: 3000,
    toast: true,
    position: 'top-end'
});
@endif

// Show error message
@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Error!',
    text: "{{ session('error') }}",
    showConfirmButton: true
});
@endif

// Handle form submission
document.querySelectorAll('.coupon-form').forEach(form => {
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Please wait...',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        this.submit();
    });
});

// Delete confirmation
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                this.submit();
            }
        });
    });
});
</script>
@endpush
