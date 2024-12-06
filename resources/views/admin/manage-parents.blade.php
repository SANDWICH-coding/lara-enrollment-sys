@extends('adminlte::page')

@section('title', 'Blesserd Trinity Academy')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
  <h1>Manage Parents</h1>
</div>
@endsection

@section('content')
<!-- Modal for Creating -->
<div class="modal fade" id="createParentModal" tabindex="-1" aria-labelledby="createSectionModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gradient-success text-white">
        <h5 class="modal-title" id="createYearLevelModalLabel">Add Parent Information</h5>
        <button type="button" class="fas fa-times" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="m-3">
          <form id="creatParentForm" method="POST">
            @csrf
            <h3 class="mt-2 mb-3" style="font-weight: bold;">Personal Details</h3>
            <div class="row">
              <div class="mb-3 col-4">
                <label for="salutation" class="form-label" style="font-weight: normal;">Salutation <span style="color: red">*</span></label>
                <select class="form-control" id="salutation" name="salutation">
                  <option value="" disabled selected>--Select Salutation--</option>
                  <option value="Mr.">Mr.</option>
                  <option value="Mrs.">Mrs.</option>
                  <option value="Ms.">Ms.</option>
                </select>
                <span id="salutationError" class="text-danger"></span>
              </div>
              <div class="mb-3 col-4">
                <label for="firstName" class="form-label" style="font-weight: normal;">First Name <span style="color: red">*</span></label>
                <input type="text" class="form-control" name="firstName" value="{{ old('firstName') }}">
                <span id="firstNameError" class="text-danger"></span>
              </div>
              <div class="mb-3 col-4">
                <label for="lastName" class="form-label" style="font-weight: normal;">Last Name <span style="color: red">*</span></label>
                <input type="text" class="form-control" name="lastName" value="{{ old('lastName') }}">
                <span id="lastNameError" class="text-danger"></span>
              </div>
            </div>

            <div class="row">
              <div class="mb-3 col-6">
                <label for="dob" class="form-label" style="font-weight: normal;">Date of Birth <span style="color: red">*</span></label>
                <input type="date" class="form-control" name="dob">
                <span id="dobError" class="text-danger"></span>
              </div>
              <div class="mb-3 col-6">
                <label for="contactNo" class="form-label" style="font-weight: normal;">Contact No. <span style="color: red">*</span></label>
                <input type="text" class="form-control" name="contactNo">
                <span id="contactNoError" class="text-danger"></span>
              </div>
            </div>

            <div class="mb-3">
              <label for="address" class="form-label" style="font-weight: normal;">Address <span style="color: red">*</span></label>
              <input type="text" class="form-control" name="address">
              <span id="addressError" class="text-danger"></span>
            </div>

            <h3 class="mt-3 mb-3" style="font-weight: bold;">Account Details</h3>
            <div class="row">
              <div class="mb-3 col-6">
                <label for="email" class="form-label" style="font-weight: normal;">Email <span style="color: red">*</span></label>
                <input type="email" class="form-control" id="email" name="email">
                <span id="emailError" class="text-danger"></span>
              </div>
              <div class="mb-3 col-6">
                <label for="password" class="form-label" style="font-weight: normal;">Password <span style="color: red">*</span></label>
                <div class="input-group">
                  <input type="password" class="form-control" id="password" name="password" readonly required>
                  <button type="button" class="btn btn-outline-secondary" id="generatePasswordBtn"><span><i class="fas fa-key mr-2"></i></span>Generate</button>
                </div>
                <span id="passwordError" class="text-danger"></span>
              </div>
            </div>

            <!-- Save Button -->
            <div class="modal-footer">
              <button type="submit" class="btn bg-gradient-success">Save</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editParentModal" tabindex="-1" aria-labelledby="editParentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gradient-info text-white">
        <h5 class="modal-title" id="editParentModalLabel">Edit Parent Information</h5>
        <button type="button" class="fas fa-times" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="editParentForm">
          @csrf
          @method('PUT')
          <input type="hidden" name="parent_id" id="editParentId">
          <div class="mb-3">
            <label for="editSalutation" class="form-label">Salutation <span class="text-danger">*</span></label>
            <select class="form-control" id="editSalutation" name="salutation">
              <option value="" disabled selected>--Select Salutation--</option>
              <option value="Mr.">Mr.</option>
              <option value="Mrs.">Mrs.</option>
              <option value="Ms.">Ms.</option>
            </select>
            <span id="salutationError" class="text-danger"></span>
          </div>
          <div class="row">
            <div class="mb-3 col-6">
              <label for="editFirstName" class="form-label">First Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="firstName" id="editFirstName" readonly>
              <span id="editFirstNameError" class="text-danger"></span>
            </div>
            <div class="mb-3 col-6">
              <label for="editLastName" class="form-label">Last Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="lastName" id="editLastName">
              <span id="editLastNameError" class="text-danger"></span>
            </div>
          </div>
          <div class="row">
            <div class="mb-3 col-6">
              <label for="editDOB" class="form-label">Date of Birth <span class="text-danger">*</span></label>
              <input type="date" class="form-control" name="dob" id="editDOB">
              <span id="editDOBError" class="text-danger"></span>
            </div>
            <div class="mb-3 col-6">
              <label for="editContactNumber" class="form-label">Contact No. <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="contactNo" id="editContactNo">
              <span id="editContactNumberError" class="text-danger"></span>
            </div>
          </div>
          <div class="mb-3">
            <label for="editAddress" class="form-label">Address <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="editAddress" id="editAddress">
            <span id="editAddressError" class="text-danger"></span>
          </div>
          <div class="mb-3">
            <label for="editEmail" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" id="editEmail">
            <span id="editEmailError" class="text-danger"></span>
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
        <h3 class="card-title mb-0" style="flex-grow: 1; text-align: left;">Parents List</h3>
        <button class="btn btn-sm btn-default" style="text-align: right;" data-bs-toggle="modal" data-bs-target="#createParentModal">
          <i class="fas fa-plus mr-2"></i>Add Parent
        </button>
      </div> <!-- /.card-header -->
      <div class="card-body">
        <!-- Table wrapped in .table-responsive -->
        <div class="table-responsive">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>Fullname</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($allParents as $allParent)
              <tr>
                <td>{{ $allParent-> firstName}} {{ $allParent-> lastName}}</td>
                <td>
                  <div class="dropdown">
                    <button
                      class="btn btn-circle btn-sm"
                      type="button"
                      id="dropdownMenuButton{{ $allParent->parentId }}"
                      data-bs-toggle="dropdown">
                      <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $allParent->parentId }}">
                      <li>
                        <button class="dropdown-item view-btn" data-id="{{ $allParent->parentId }}">
                          <i class="fas fa-eye mr-2"></i>View
                        </button>
                      </li>
                      <li>
                        <button
                          class="dropdown-item edit-btn"
                          data-id="{{ $allParent->parentId }}"
                          data-salutation="{{ $allParent->salutation }}"
                          data-firstName="{{ $allParent->firstName }}"
                          data-lastName="{{ $allParent->lastName }}"
                          data-dob="{{ $allParent->dob }}"
                          data-contactNo="{{ $allParent->contactNo }}"
                          data-address="{{ $allParent->address }}"
                          data-email="{{ optional($allParent->users)->email ?? '' }}"
                          data-bs-toggle="modal"
                          data-bs-target="#editParentModal">
                          <i class="fas fa-edit mr-2"></i>Edit
                        </button>
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
      </div>
    </div> <!-- /.card -->
  </div> <!-- /.col -->
</div>
@endsection

@push('js')
<script>
document.getElementById('creatParentForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default submission

    // Clear previous error messages
    document.querySelectorAll('.text-danger').forEach(el => el.textContent = ''); // Clear text in all error elements

    const formData = new FormData(this);

    // AJAX request using Fetch API
    fetch('{{ route("storeParentWithUsername") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
        },
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload the page on success
            } else if (data.errors) {
                // Display validation errors
                Object.entries(data.errors).forEach(([key, messages]) => {
                    const errorElement = document.getElementById(`${key}Error`);
                    if (errorElement) {
                        errorElement.textContent = messages[0]; // Display the first error message
                    }
                });
            }
        })
        .catch(error => {
            console.error('Unexpected error:', error);
            alert('An unexpected error occurred. Please try again.');
        });
});

// Generate Password Button Functionality
document.getElementById('generatePasswordBtn').addEventListener('click', function () {
    const password = Math.random().toString(36).slice(-8); // Generate random 8-character password
    document.getElementById('password').value = password; // Set the generated password
});

</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
      button.addEventListener('click', function() {
        const parentId = this.getAttribute('data-id');
        const salutation = this.getAttribute('data-salutation');
        const firstName = this.getAttribute('data-firstName');
        const lastName = this.getAttribute('data-lastName');
        const dob = this.getAttribute('data-dob');
        const contactNo = this.getAttribute('data-contactNo');
        const address = this.getAttribute('data-address');
        const email = this.getAttribute('data-email');

        // Populate fields for updating
        document.getElementById('editParentId').value = parentId;
        document.getElementById('editSalutation').value = salutation;
        document.getElementById('editFirstName').value = firstName;
        document.getElementById('editLastName').value = lastName;

        if (document.getElementById('editSalutation').value === 'Ms.') {
          document.getElementById('editLastName').disabled = false;
        } else {
          document.getElementById('editLastName').disabled = true;
        }
        document.getElementById('editDOB').value = dob;
        document.getElementById('editContactNo').value = contactNo;
        document.getElementById('editAddress').value = address;
        document.getElementById('editEmail').value = email;

      });
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
@endpush