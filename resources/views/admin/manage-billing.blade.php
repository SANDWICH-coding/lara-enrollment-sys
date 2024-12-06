@extends('adminlte::page')

@section('title', 'Blesserd Trinity Academy')


@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Manage Billing Assessment</h1>

</div>
@endsection

@section('content')

<!-- Create Modal -->
<div class="modal fade" id="createBillingModal" tabindex="-1" aria-labelledby="createBillingModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title" id="createBillingModalLabel">Create Billing</h5>
                <button type="button" class="fas fa-times" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form action="{{ route('storeBilling') }}" method="POST">
                    @csrf
                    <!-- Year Level Dropdown -->
                    <div class="mb-3">
                        <label for="yearLevelId" class="form-label">Year Level <span class="text-danger">*</span></label>
                        <select class="form-control" id="yearLevelId" name="yearLevelId">
                            <option value="" disabled selected>--Select Year Level--</option>
                            @foreach ($allYearLevels as $yearLevel)
                            <option value="{{ $yearLevel->yearLevelId }}">{{ $yearLevel->yearLevelName }}</option>
                            @endforeach
                        </select>
                        @error('yearLevelId')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control"
                            id="description"
                            name="description"
                            placeholder="Enter description"
                            value="{{ old('description') }}">
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                        <input
                            type="number"
                            class="form-control"
                            id="amount"
                            name="amount"
                            placeholder="Enter amount"
                            value="{{ old('amount') }}">
                        @error('amount')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editBillingModal" tabindex="-1" aria-labelledby="editBillingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info text-white">
                <h5 class="modal-title" id="editBillingModalLabel">Edit Billing</h5>
                <button type="button" class="fas fa-times" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateBilling') }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Use PUT for updating records -->
                    <input type="hidden" name="billingId" id="editBillingId">
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control"
                            id="editDescription"
                            name="description"
                            placeholder="Enter description"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="editAmount" class="form-label">Amount <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control"
                            id="editAmount"
                            name="amount"
                            placeholder="Enter amount"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-primary mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0" style="flex-grow: 1; text-align: left;">Billing List</h3>
            </div> <!-- /.card-header -->
            <div class="card-body">
                <!-- Table wrapped in .table-responsive -->
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th>Year Level</th>
                                <th></th>
                                <th>Billing</th>
                                <th>Total Payable</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allYearLevels as $allYearLevel)
                            <tr>
                                <td>{{ $allYearLevel->yearLevelName }}</td>
                                <td>
                                    <button
                                        class="btn bg-gradient-success btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#createBillingModal"
                                        data-yearLevelId="{{ $allYearLevel->yearLevelId }}"
                                        data-yearLevelName="{{ $allYearLevel->yearLevelName }}">
                                        <i class="fas fw fa-plus"></i>
                                    </button>
                                </td>
                                <td>
                                    @if($allYearLevel->billings->isEmpty())
                                    <p class="text-muted text-sm"><em>No billing assessment available</em></p>
                                    @else
                                    <table class="table table-sm table-hover text-nowrap mb-3">
                                        <tbody>
                                            @foreach ($allYearLevel->billings as $index => $billing)
                                            <tr class="custom-row">
                                                <td>
                                                    {{ $billing->description }}
                                                </td>
                                                <td><span class="badge bg-success">₱{{ number_format($billing->amount, 2) }}</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-circle btn-sm"
                                                            type="button"
                                                            id="dropdownMenuButton{{ $billing->billingId }}"
                                                            data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $billing->billingId }}">
                                                            <!-- Menu items -->
                                                            <li>
                                                                <button
                                                                    class="dropdown-item edit-btn"
                                                                    data-id="{{ $billing->billingId }}"
                                                                    data-name="{{ $billing->description }}"
                                                                    data-amount="{{ $billing->amount }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editBillingModal">
                                                                    <i class="fas fa-edit mr-2"></i>Edit
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('deleteBilling', $billing->billingId) }}" method="POST" class="d-inline delete-form">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="dropdown-item text-danger delete-button">
                                                                        <i class="fas fa-trash mr-2"></i>Remove
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endif
                                </td>
                                <td style="font-size: 25px;">@if($allYearLevel->billings->sum('amount') != 0) <span>₱{{ number_format($allYearLevel->billings->sum('amount'), 2) }}</span> @endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $allYearLevels->links() }}
            </div>
        </div> <!-- /.card -->

    </div> <!-- /.col -->
</div>


@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Attach event listener to all delete buttons
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Show confirmation dialog
                const confirmDelete = confirm('Are you sure you want to delete this billing entry? This action cannot be undone.');

                if (confirmDelete) {
                    // Find the closest form and submit it
                    const form = this.closest('.delete-form');
                    form.submit();
                }
            });
        });
    });
</script>

<script>
    // JavaScript to handle setting the yearLevelId when the "Create Billing" button is clicked
    document.addEventListener('DOMContentLoaded', function() {
        const createBillingButtons = document.querySelectorAll('[data-bs-target="#createBillingModal"]');

        createBillingButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get the selected year level id from the button's data attribute
                const yearLevelId = this.getAttribute('data-yearLevelId');

                // Set the selected value in the dropdown
                document.getElementById('yearLevelId').value = yearLevelId;
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Attach event listener to dynamically populate the Edit modal
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const billingId = this.getAttribute('data-id');
                const description = this.getAttribute('data-name');
                const amount = this.getAttribute('data-amount');

                // Populate modal fields
                document.getElementById('editBillingId').value = billingId;
                document.getElementById('editDescription').value = description;
                document.getElementById('editAmount').value = amount;
            });
        });
    });
</script>
@endpush

@push('css')
<style>
    /* Add light gray background color for table rows */
    .custom-row {
        background-color: #f5f5f5;
    }

    /* Only show top and bottom borders of each row */
    .custom-row td {
        border-left: none;
        border-right: none;
        border-top: 5px solid white;
        border-bottom: 5px solid white;
    }

    /* Optionally, you can add some hover effect for row hover */
    .custom-row:hover {
        background-color: #e0e0e0;
    }
</style>
@endpush