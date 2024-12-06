@extends('adminlte::page')

@section('title', 'Blessed Trinity Academy')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Manage Sections</h1>
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card card-primary mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0" style="flex-grow: 1; text-align: left;">Section List</h3>
                <button class="btn btn-sm btn-default" style="text-align: right;" data-bs-toggle="modal" data-bs-target="#createSectionModal">
                    <i class="fas fa-plus mr-2"></i>Create Section
                </button>
            </div> <!-- /.card-header -->
            <div class="card-body">
                <!-- Table wrapped in .table-responsive -->
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th>Year Level</th>
                                <th>Section</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allYearLevels as $allYearLevel)
                            <tr>
                                <td>{{ $allYearLevel->yearLevelName }}</td>
                                <td>
                                    @php
                                    // Filter sections based on the active school year
                                    $activeSections = $allYearLevel->sections->filter(function ($section) {
                                    return $section->schoolYear->isActive == 1;
                                    });
                                    @endphp

                                    @if($activeSections->isEmpty())
                                    <p class="text-muted text-sm"><em>No sections available</em></p>
                                    @else
                                    <table class="table table-sm table-hover text-nowrap mb-3">
                                        <tbody>
                                            @foreach ($activeSections as $index => $section)
                                            <tr class="custom-row">
                                                <td class="d-flex justify-content-between align-items-center">
                                                    <span>{{ $section->sectionName }}</span>

                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-circle btn-sm"
                                                            type="button"
                                                            id="dropdownMenuButton{{ $section->sectionId }}"
                                                            data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $section->sectionId }}">
                                                            <!-- Menu items -->
                                                            <li>
                                                                <button
                                                                    class="dropdown-item edit-btn"
                                                                    data-id="{{ $section->sectionId }}"
                                                                    data-name="{{ $section->sectionName }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editSectionModal">
                                                                    <i class="fas fa-edit mr-2"></i>Edit
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('deleteSection', $section->sectionId) }}" method="POST" class="d-inline">
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
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div> <!-- /.card-body -->
            <div class="card-footer clearfix">
            </div>
        </div> <!-- /.card -->

    </div> <!-- /.col -->
</div>

<!-- Create Modal -->
<div class="modal fade" id="createSectionModal" tabindex="-1" aria-labelledby="createSectionModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title" id="createYearLevelModalLabel">Create Section</h5>
                <button type="button" class="fas fa-times" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="createSectionForm" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="schoolYear" class="form-label">School Year <span class="text-danger">*</span></label>
                        <select class="form-control" name="schoolYearId" id="schoolYearId">
                            <!-- First, display the school year with status 1 -->
                            @foreach ($allSchoolYears as $schoolYear)
                            @if ($schoolYear->isActive == 1)
                            <option value="{{ $schoolYear->schoolYearId }}" selected>{{ $schoolYear->schoolYearName }}</option>
                            @endif
                            @endforeach

                            <!-- Then, display the rest with status 2, but disable them -->
                            @foreach ($allSchoolYears as $schoolYear)
                            @if ($schoolYear->isActive !== 1)
                            <option value="{{ $schoolYear->schoolYearId }}" disabled>{{ $schoolYear->schoolYearName }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Year Level Dropdown -->
                    <div class="mb-3">
                        <label for="yearLevelId" class="form-label">Year Level <span class="text-danger">*</span></label>
                        <select class="form-control" id="yearLevelId" name="yearLevelId">
                            <option value="" disabled selected>--Select Year Level--</option>
                            @foreach ($allYearLevels as $yearLevel)
                            <option value="{{ $yearLevel->yearLevelId }}">{{ $yearLevel->yearLevelName }}</option>
                            @endforeach
                        </select>
                        <span id="yearLevelIdError" class="text-danger"></span>
                    </div>

                    <!-- Section Name Input -->
                    <div class="mb-3">
                        <label for="sectionName" class="form-label">Section <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control"
                            id="sectionName"
                            name="sectionName"
                            placeholder="Enter section name"
                            value="{{ old('sectionName') }}">
                        <span id="sectionNameError" class="text-danger"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Section Modal -->
<div class="modal fade" id="editSectionModal" tabindex="-1" aria-labelledby="editSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info text-white">
                <h5 class="modal-title" id="editSectionModalLabel">Edit Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSectionForm" action="{{ route('updateSection') }}" method="POST">
                @csrf
                @method('PUT') <!-- Use PUT for updates -->
                <div class="modal-body">
                    <input type="hidden" name="sectionId" id="editSectionId">
                    <div class="mb-3">
                        <label for="editSectionName" class="form-label">Section <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control"
                            id="editSectionName"
                            name="sectionName"
                            placeholder="Enter section name"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-gradient-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

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

    .custom-row td span {
        padding-left: 10px;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('createSectionForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default submission

        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(el => el.textContent = ''); // Clear only text content

        const formData = new FormData(this);
        const input = event.target;
        const value = input.value;

        fetch('{{ route("storeSection") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else if (data.errors) {
                    Object.entries(data.errors).forEach(([key, messages]) => {
                        const errorElement = document.getElementById(`${key}Error`);
                        if (errorElement) {
                            errorElement.textContent = messages[0]; // Only update text, don't overwrite element
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Unexpected error:', error);
                alert('An unexpected error occurred. Please try again.');
            });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event delegation to handle dynamic content
        document.querySelectorAll('.edit-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const sectionId = this.getAttribute('data-id');
                const sectionName = this.getAttribute('data-name');

                // Populate modal fields
                document.getElementById('editSectionId').value = sectionId;
                document.getElementById('editSectionName').value = sectionName;
            });
        });
    });
</script>
@endpush