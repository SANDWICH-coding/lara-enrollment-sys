@extends('adminlte::page')

@section('title', 'Blesserd Trinity Academy')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
  <h1>Manage School Year</h1>
</div>
@endsection

@section('content')

<!-- Table -->
<div class="row">
  <div class="col-12">
    <div class="card card-primary mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0" style="flex-grow: 1; text-align: left;">School Year List</h3>
        <button class="btn btn-sm btn-default" style="text-align: right;" data-bs-toggle="modal" data-bs-target="#createSchoolYearModal">
          <i class="fas fa-plus mr-2"></i>Create School Year
        </button>
      </div>
      <div class="card-body">
        <!-- Table wrapped in .table-responsive -->
        <div class="table-responsive">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>School Year</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($allSchoolYears as $allSchoolYear)
              <tr>
                <td>{{ $allSchoolYear->schoolYearName }}</td>
                <td>
                  <span class="badge {{ $allSchoolYear->isActive == 1 ? 'bg-success' : 'bg-secondary' }}">
                    {{ $allSchoolYear->isActive == 1 ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="d-flex justify-content-end">
                  <!-- Three-dot menu -->
                  <div class="dropdown">
                    <button
                      class="btn btn-circle btn-sm"
                      type="button"
                      id="dropdownMenuButton{{ $allSchoolYear->schoolYearId }}"
                      data-bs-toggle="dropdown">
                      <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $allSchoolYear->schoolYearId }}">
                      <!-- Activate/Deactivate Menu Item -->
                      <li>
                        <form
                          action="{{ route('toggleStatus', ['id' => $allSchoolYear->schoolYearId]) }}"
                          method="POST"
                          class="d-inline">
                          @csrf
                          @method('PATCH')
                          <input type="hidden" name="isActive" value="{{ $allSchoolYear->isActive == 1 ? 2 : 1 }}">
                          <button
                            class="dropdown-item {{ $allSchoolYear->isActive == 1 ? 'text-danger' : 'text-success' }}">
                            <i class="fas fa-toggle-{{ $allSchoolYear->isActive == 1 ? 'off' : 'on' }} mr-2"></i>
                            {{ $allSchoolYear->isActive == 1 ? 'Deactivate' : 'Activate' }}
                          </button>
                        </form>
                      </li>
                    </ul>
                  </div>
                </td>

                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div> <!-- /.table-responsive -->
      </div> <!-- /.card-body -->
      <div class="card-footer clearfix">
      </div>
    </div> <!-- /.card -->
  </div> <!-- /.col -->

</div>

<!-- Modal for Creating -->
<div class="modal fade" id="createSchoolYearModal" tabindex="-1" aria-labelledby="createSchoolYearModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header bg-gradient-success text-white">
        <h5 class="modal-title" id="createSchoolYearModalLabel">Create School Year</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <form id="schoolYearForm" method="POST">
          @csrf
          <div class="mb-3">
            <label for="schoolYearName" class="form-label">School Year <span class="text-danger">*</span></label>
            <input type="text"
              class="form-control"
              id="schoolYearName"
              name="schoolYearName"
              placeholder="YYYY-YYYY"
              value="{{ old('schoolYearName') }}">
            <span id="schoolYearNameError" class="text-danger"></span>
          </div>
          <div class="mb-3">
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value="1"
                id="isActive"
                name="isActive"
                onchange="this.checked ? this.value = 1 : this.value = 2;">
              <label class="form-check-label" for="isActive">
                Activate
              </label> <br>
              <!-- Error message here -->
              <span id="isActiveError" class="text-danger"></span>
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn bg-gradient-success">Save</button>
          </div>
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
<script>
  $(document).ready(function() {
    // Apply input mask for school year format (YYYY-YYYY)
    $('#schoolYearName').inputmask({
      mask: "9999-9999",
      placeholder: "YYYY-YYYY",
      showMaskOnHover: false
    });
  });

  document.getElementById('schoolYearForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default submission

    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = ''); // Clear only text content

    const formData = new FormData(this);
    const input = event.target;
    const value = input.value;

    // Validate input format
    const isValid = /^\d{4}-\d{4}$/.test(value);

    // Show error message if invalid
    const errorElement = document.getElementById('schoolYearNameError');
    if (!isValid && value) {
      errorElement.textContent = 'School year must be in the format YYYY-YYYY (e.g., 2024-2025)';
    } else {
      errorElement.textContent = '';
    }

    fetch('{{ route("storeSchoolYear") }}', {
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Inputmask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
@endpush