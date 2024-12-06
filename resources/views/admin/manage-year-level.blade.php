@extends('adminlte::page')

@section('title', 'Blesserd Trinity Academy')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Manage Year Levels</h1>
</div>
@endsection


@section('content')

<div class="row">
    <div class="col-12">
        <div class="card card-primary mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0" style="flex-grow: 1; text-align: left;">Year Level List</h3>
                <button class="btn btn-sm btn-default" style="text-align: right;" data-bs-toggle="modal" data-bs-target="#createYearLevelModal">
                    <i class="fas fa-plus mr-2"></i>Create Year Level
                </button>
            </div>
            <div class="card-body">
                <!-- Table wrapped in .table-responsive -->
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Year Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allYearLevels as $allYearLevel)
                            <tr>
                                <td class="d-flex justify-content-between align-items-center">
                                    <!-- Year Level Name -->
                                    <span>{{ $allYearLevel->yearLevelName }}</span>

                                    <!-- Three-dot menu -->
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-circle btn-sm"
                                            type="button"
                                            id="dropdownMenuButton{{ $allYearLevel->yearLevelId }}"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $allYearLevel->yearLevelId }}">
                                            <!-- Menu items -->
                                            <li>
                                                <button
                                                    class="dropdown-item edit-btn"
                                                    data-id="{{ $allYearLevel->yearLevelId }}"
                                                    data-name="{{ $allYearLevel->yearLevelName }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editYearLevelModal">
                                                    <i class="fas fa-edit mr-2"></i>Edit
                                                </button>
                                            </li>
                                            <li>
                                                <form action="{{ route('deleteYearLevel', $allYearLevel->yearLevelId) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger"><i class="fas fa-trash mr-2"></i>Remove</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- /.table-responsive -->
            </div> <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $allYearLevels->links() }}
            </div>
        </div> <!-- /.card -->
    </div> <!-- /.col -->

</div>

<!-- Modal for Creating -->
<div class="modal fade" id="createYearLevelModal" tabindex="-1" aria-labelledby="createYearLevelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title" id="createYearLevelModalLabel">Create Year Level</h5>
                <button type="button" class="fas fa-times" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form action="{{ route('storeYearLevel') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="yearLevelName" class="form-label">Year Level <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="yearLevelName" name="yearLevelName" placeholder="Enter year level" value="{{ old('yearLevelName') }}">
                        @error('yearLevelName') <span class="text-danger"> {{ $message }} </span> @enderror
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
<div class="modal fade" id="editYearLevelModal" tabindex="-1" aria-labelledby="editYearLevelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="editYearLevelModalLabel">Edit Year Level</h5>
                <button type="button" class="fas fa-times" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Updating Year Level -->
                <form id="updateYearLevelForm" action="{{ route('updateYearLevel') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="yearLevelId" id="editYearLevelId">
                    <div class="mb-3">
                        <label for="editYearLevelName" class="form-label">Year Level <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control"
                            id="editYearLevelName"
                            name="yearLevelName"
                            placeholder="Enter year level"
                            required>
                    </div>
            </div>
            <div class="modal-footer">
                <!-- Save Changes Button -->
                <button type="submit" class="btn bg-gradient-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<style>
    .btn-circle {
        width: 25px;
        /* Set width */
        height: 25px;
        /* Set height */
        padding: 0;
        /* Remove padding */
        border-radius: 50%;
        /* Make it circular */
        display: flex;
        /* To center the icon inside */
        justify-content: center;
        align-items: center;
        background: #e6e6e6;
        color: #4a4a4a;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const yearLevelId = this.getAttribute('data-id');
                const yearLevelName = this.getAttribute('data-name');

                // Populate fields for updating
                document.getElementById('editYearLevelId').value = yearLevelId;
                document.getElementById('editYearLevelName').value = yearLevelName;

                // Set the action URL dynamically for the delete form
                const deleteForm = document.getElementById('deleteYearLevelForm');
                deleteForm.action = `{{ url('manage-year-level') }}/${yearLevelId}`;
            });
        });
    });
</script>
@endpush