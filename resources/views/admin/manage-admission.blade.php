@extends('adminlte::page')

@section('title', 'Blesserd Trinity Academy')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
  <h1>Manage Admission</h1>
  <div class="btn-group">
    <button type="button" class="btn bg-gradient-success dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Admission
    </button>
    <div class="dropdown-menu">
      <a class="dropdown-item add-student-btn" href="#" data-bs-toggle="modal" data-bs-target="#newAdmissionModal" data-admission-type="New"><i class="fas fa-user-plus mr-2"></i>New</a>
      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createParentModal" data-admission-type="Continuing"><i class="fas fa-arrow-up mr-2"></i>Continuing</a>
    </div>
  </div>
</div>
@endsection


@section('content')
<!-- Modal -->
<div class="modal fade" id="newAdmissionModal" tabindex="-1" aria-labelledby="newAdmissionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header bg-gradient-success">
        <h5 class="modal-title" id="newAdmissionModalLabel"></h5>
      </div>

      <!-- Modal Body -->
      <form id="admissionForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <!-- Step 1 - Student Details -->
          <div id="step1" class="modal-step">
            <h3 class="text-center mt-1 mb-3">NEW STUDENT FORM</h3>
            <div class="m-3 rounded">
              <div class="p-3 mb-3" style="border: 1px solid #4CAF50;">
                <div class="mb-3 mt-1">
                  <h4><b>Student Details</b></h4>
                </div>
                <!-- Your Student Details Form -->
                <div id="lastNameWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="lastName" class="form-label">Last Name <span style="color: red;">*</span></label>
                  <input type="text" class="p-0 bg-light form-control input-line mb-2" name="lastName">
                  <span id="lastNameError" class="text-danger"></span>
                </div>

                <div id="firstNameWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="firstName" class="form-label">First Name <span style="color: red;">*</span></label>
                  <input type="text" class="p-0 bg-light form-control input-line mb-2" name="firstName">
                  <span id="firstNameError" class="text-danger"></span>
                </div>

                <div id="middleNameWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="middleName" class="form-label">Middle Name</label>
                  <input type="text" class="p-0 bg-light form-control input-line mb-2" name="middleName" placeholder="">
                  <span id="middleNameError" class="text-danger"></span>
                </div>

                <div id="nickNameWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="nickName" class="form-label">Nickname</label>
                  <input type="text" class="p-0 bg-light form-control input-line mb-2" name="nickName" placeholder="">
                  <span id="nickNameError" class="text-danger"></span>
                </div>

                <div id="genderWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="gedner" class="form-label">Gender <span style="color: red;">*</span></label>
                  <select class="p-0 bg-light form-control input-line mb-2" name="gender">
                    <option value="" disabled selected>--Select Gender--</option>
                    <option value="MALE">MALE</option>
                    <option value="FEMALE">FEMALE</option>
                  </select>
                  <span id="genderError" class="text-danger"></span>
                </div>

                <div id="religionWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="religion" class="form-label">Religion</label>
                  <input type="text" class="p-0 bg-light form-control input-line mb-2" name="religion" placeholder="">
                  <span id="religionError" class="text-danger"></span>
                </div>

                <div id="dobWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="dob" class="form-label">Date of Birth <span style="color: red;">*</span></label>
                  <input type="date" class="p-0 bg-light form-control input-line mb-2" name="dob">
                  <span id="dobError" class="text-danger"></span>
                </div>

                <div id="placeOfBirthWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="placeOfBirth" class="form-label">Place of Birth</label>
                  <input type="text" class="p-0 bg-light form-control input-line mb-2" name="placeOfBirth">
                  <span id="placeOfBirthError" class="text-danger"></span>
                </div>

                <div id="birthCertificateFileWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="birthCertificate" class="form-label">Cerificate of Birth</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input input-line" id="birthCertificateFile mb-2" onchange="updateFileName(this)" name="birthCertificateFile">
                      <label class="custom-file-label" for="birthCertificateFile">Choose file</label>
                      <span id="birthCertificateFileError" class="text-danger"></span>
                      <button>Upload</button>
                    </div>
                  </div>
                </div>

                <div id="parentIdWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="parentId" class="form-label">Parent <span style="color: red;">*</span></label>
                  <select class="p-0 bg-light form-control input-line mb-2" name="parentId">
                    <option value="" disabled selected>--Select Parent--</option>
                    @foreach ($allParents as $parent)
                    <option value="{{ $parent->parentId }}">{{ $parent->salutation }} {{ $parent->firstName }} {{ $parent->lastName }}</option>
                    @endforeach
                  </select>
                  <span id="parentIdError" class="text-danger"></span>
                </div>

              </div>
            </div>
          </div>

          <!-- Step 2 - Medical Details -->
          <div id="step2" class="modal-step d-none">
            <h3 class="text-center mt-1 mb-3">NEW STUDENT FORM</h3>
            <div class="m-3 rounded">
              <div class="p-3 mb-3" style="border: 1px solid #4CAF50;">
                <div class="mb-3 mt-1">
                  <h4><b>Medical Details</b></h4>
                </div>

                <div id="illnessWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="illness" class="form-label">What is the common illness of your child?</label>
                  <input type="text" class="p-0 bg-light form-control input-line mb-2" name="illness">
                  <span id="illnessError" class="text-danger"></span>
                </div>
                <div id="allergiesWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="allergies" class="form-label">Does your child has many allergies or health problems?</label>
                  <input type="text" class="p-0 bg-light form-control input-line mb-2" name="allergies">
                  <span id="allergiesError" class="text-danger"></span>
                </div>
                <div id="dentalWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="dental" class="form-label">Does your child has frequent dental problem?</label>
                  <input type="text" class="p-0 bg-light form-control input-line mb-2" name="dental">
                  <span id="dentalError" class="text-danger"></span>
                </div>
                <div id="attitudesWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="attitudes" class="form-label">Does your child has any favorable attitudes?</label>
                  <div class="col-sm-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="Bad Temper" name="attitudes[]" id="badTemper">
                      <label class="form-check-label" for="badTemper">
                        Bad Temper
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="Wetting the pants" name="attitudes[]" id="wettingThePants">
                      <label class="form-check-label" for="wettingThePants">
                        Wetting the pants
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="Running Away" name="attitudes[]" id="runningAway">
                      <label class="form-check-label" for="runningAway">
                        Running Away
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="Swearing/bad words" name="attitudes[]" id="swearingBadWords">
                      <label class="form-check-label" for="swearingBadWords">
                        Swearing/bad words
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="Over shyness" name="attitudes[]" id="overShyness">
                      <label class="form-check-label" for="overShyness">
                        Over shyness
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="Thumb sucking" name="attitudes[]" id="thumbSucking">
                      <label class="form-check-label" for="thumbSucking">
                        Thumb sucking
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="Over active" name="attitudes[]" id="overActive">
                      <label class="form-check-label" for="overActive">
                        Over active
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="Talkative" name="attitudes[]" id="talkative">
                      <label class="form-check-label" for="talkative">
                        Talkative
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="Fighter" name="attitudes[]" id="fighter">
                      <label class="form-check-label" for="fighter">
                        Fighter
                      </label>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <!-- Step 3 - Enrollment Details -->
          <div id="step3" class="modal-step d-none">
            <h3 class="text-center mt-1 mb-3">NEW STUDENT FORM</h3>
            <div class="m-3 rounded">
              <div class="p-3 mb-3" style="border: 1px solid #4CAF50;">
                <div class="mb-3 mt-1">
                  <h4><b>Enrollment Details</b></h4>
                </div>
                <div id="lrnWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="lrn" class="form-label">LRN</label>
                  <input type="text" class="p-0 bg-light form-control input-line mb-2" name="lrn">
                  <span id="lrnError" class="text-danger"></span>
                </div>

                <div id="schoolYearWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="schoolYear" class="form-label">School Year <span style="color: red;">*</span></label>
                  <input type="text" class="p-0 bg-light form-control input-line mb-2" readonly value="{{ $activeSchoolYear->schoolYearName ?? '' }}">
                  <input type="hidden" name="schoolYearId" value="{{ $activeSchoolYear->schoolYearId ?? '' }}">
                  <span id="schoolYearIdError" class="text-danger"></span>
                </div>

                <div id="yearLevelIdWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="yearLevelId" class="form-label">Year Level <span style="color: red;">*</span></label>
                  <select class="p-0 bg-light form-control input-line mb-2" id="yearLevelId" name="yearLevelId">
                    <option value="" disabled selected>--Select Year Level--</option>
                    @foreach ($allYearLevels as $allYearLevel)
                    <option value="{{ $allYearLevel->yearLevelId }}">{{ $allYearLevel->yearLevelName }}</option>
                    @endforeach
                  </select>
                  <span id="yearLevelIdError" class="text-danger"></span>
                </div>

                <div id="sectionWrapper" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <label for="sectionId" class="form-label">Section</label>
                  <select class="p-0 bg-light form-control input-line mb-2" name="sectionId" id="sectionId">
                    <option value="" disabled selected>--Select Section--</option>
                  </select>
                  <span id="sectionIdError" class="text-danger"></span>
                </div>
              </div>
            </div>

            <div class="m-3 rounded">
              <div class="p-3 mb-3" style="border: 1px solid #4CAF50;">
                <div class="mb-3 mt-1">
                  <h4><b>Billing Details</b></h4>
                </div>
                <div id="billingTable" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <p>Select Year Level and Section to view billing details.</p>
                </div>
              </div>
            </div>

            <div class="m-3 rounded">
              <div class="p-3 mb-3" style="border: 1px solid #4CAF50;">
                <div class="mb-3 mt-1">
                  <h4><b>Schedule Details</b></h4>
                </div>
                <div id="scheduleTable" class="mb-3 p-3 bg-light rounded border shadow-sm">
                  <p>Select Year Level and Section to view schedule details.</p>
                </div>
              </div>
            </div>

          </div>

          <!-- Modal Footer -->
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary" id="prevBtn" disabled>Previous</button>
            <button type="button" class="btn bg-gradient-primary" id="nextBtn">Next</button>
            <button type="submit" class="btn bg-gradient-success d-none" id="submitBtn">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="row shadow">
  <div class="col-12">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presenta1tion">
        <button class="nav-link active" id="new-student-tab" data-bs-toggle="tab" data-bs-target="#new-student" type="button" role="tab" aria-controls="student" aria-selected="true">
          New Admission
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
          Continuing Admission
        </button>
      </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade m-3 show active" id="new-student" role="tabpanel" aria-labelledby="new-student-tab">
        <div class="row">
          <div class="col-12">
            <!-- Check if the active school year is null -->
            @if ($activeSchoolYear)
            <div class="card mb-4">
              <div class="card-header bg-gradient-primary">
                <h3 class="card-title">Student List</h3>
              </div> <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Date Added</th>
                        <th>Admission #</th>
                        <th>School Year</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($allAdmission as $index => $admission)
                      <tr>
                        <td>{{ date('j-M-Y', strtotime($admission->created_at)) }}</td>
                        <td>{{ $admission->admissionNo }}</td>
                        <td>{{ $admission->schoolYear->schoolYearName ?? 'Not Assigned' }}</td>
                        <td>
                          @if ($admission->status === 'Pending')
                          <span class="badge badge-warning">Pending</span>
                          @elseif ($admission->status === 'Admitted')
                          <span class="badge badge-success">Admitted</span>
                          @else
                          {{ $admission->status }}
                          @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>



              <div class="card-footer clearfix">
              </div>
            </div> <!-- /.card -->
            @else
            <div class="alert alert-warning" role="alert">
              No school year is active. <a href="{{ route('manage.school.year') }}" class="alert-link">Activate Now</a>
            </div>
            @endif
          </div> <!-- /.col -->
        </div>
      </div>

      <!-- Other Tab Content (profile, contact) -->
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <!-- Profile Content -->
      </div>

      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <!-- Contact Content -->
      </div>
    </div>
  </div>
</div>



@endsection

@push('css')
<style>
  .border-danger {
    border-color: red !important;
  }

  .table-responsive {
    overflow: visible !important;
    /* Allow overflow for dropdowns */
    position: relative;
    /* Ensure proper dropdown alignment */
  }

  .input-line {
    border: none;
    border-bottom: 1px solid #ced4da;
    /* Bootstrap default border color */
    border-radius: 0;
    /* Remove rounded corners */
    box-shadow: none;
    /* Remove shadow */
  }

  .input-line:focus {
    outline: none;
    /* Remove outline */
    border-bottom: 2px solid #0d6efd;
    /* Highlight color on focus (Bootstrap primary color) */
  }

  .input-line {
    transition: border-bottom-color 0.3s ease-in-out;
  }
</style>
@endpush

@push('js')
<!-- For section dropdown, billing and schedule details -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const yearLevelDropdown = document.getElementById('yearLevelId');
    const sectionDropdown = document.getElementById('sectionId');
    const billingTable = document.getElementById('billingTable');
    const scheduleTable = document.getElementById('scheduleTable');

    yearLevelDropdown.addEventListener('change', updateSections);
    sectionDropdown.addEventListener('change', fetchDetails);

    function updateSections() {
      const yearLevelId = this.value;

      // Reset dropdowns and tables
      sectionDropdown.innerHTML = '<option value="" disabled selected>--Select Section--</option>';
      billingTable.innerHTML = '<p>Select Year Level and Section to view billing details.</p>';
      scheduleTable.innerHTML = '<p>Select Year Level and Section to view schedule details.</p>';

      if (yearLevelId) {
        fetch(`/get-sections/${yearLevelId}`)
          .then(response => response.json())
          .then(data => {
            if (data.sections && data.sections.length > 0) {
              data.sections.forEach(section => {
                const option = document.createElement('option');
                option.value = section.sectionId;
                option.textContent = section.sectionName;
                sectionDropdown.appendChild(option);
              });
            }
          })
          .catch(error => console.error('Error fetching sections:', error));
      }
    }

    function fetchDetails() {
      const yearLevelId = yearLevelDropdown.value;
      const sectionId = this.value;

      if (yearLevelId && sectionId) {
        fetch(`/get-details/${yearLevelId}/${sectionId}`)
          .then(response => response.json())
          .then(data => {
            // Update Billing Details
            billingTable.innerHTML = data.billings.length ?
              `<table class="table">
                   <thead>
                     <tr>
                       <th>Description</th>
                       <th>Amount</th>
                     </tr>
                   </thead>
                   <tbody>
                     ${data.billings.map(billing => `
                       <tr>
                         <td>${billing.description}</td>
                         <td>&#x20B1; ${billing.amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                       </tr>
                     `).join('')}
                     <tr>
                       <td><strong>Total</strong></td>
                       <td>&#x20B1; ${data.billings.reduce((sum, billing) => sum + billing.amount, 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                     </tr>
                   </tbody>
                 </table>` :
              '<p>No billing details available.</p>';

            // Update Schedule Details
            scheduleTable.innerHTML = data.schedules.length ?
              `<table class="table">
                   <thead>
                     <tr>
                       <th>Subject Name</th>
                       <th>Day</th>
                       <th>Time</th>
                       <th>Teacher</th>
                     </tr>
                   </thead>
                   <tbody>
                     ${data.schedules.map(schedule => `
                       <tr>
                         <td>${schedule.subjectName}</td>
                         <td>${schedule.day}</td>
                         <td>${schedule.startTime} - ${schedule.endTime}</td>
                         <td>${schedule.teacherName}</td>
                       </tr>
                     `).join('')}
                   </tbody>
                 </table>` :
              '<p>No schedule details available.</p>';
          })
          .catch(error => console.error('Error fetching details:', error));
      }
    }
  });
</script>

<script>
  // Add event listener for the "View" button
  document.querySelectorAll('.view-btn').forEach(function(button) {
    button.addEventListener('click', function() {
      const studentId = this.getAttribute('data-id');

      // Fetch student details using AJAX or similar method
      fetch(`/get-student-details/${studentId}`)
        .then(response => response.json())
        .then(data => {
          // Fill in the modal with student information
          document.getElementById('studentPhoto').src = data.student.photo || 'default-photo.jpg'; // Default if photo is not available
          document.getElementById('studentName').innerText = `${data.student.firstName} ${data.student.lastName}`;
          document.getElementById('studentDOB').innerText = data.student.dob;
          document.getElementById('studentPlaceOfBirth').innerText = data.student.placeOfBirth;

          // Medical Info
          document.getElementById('studentIllness').innerText = data.medical.illness || 'N/A';
          document.getElementById('studentAllergies').innerText = data.medical.allergies || 'N/A';
          document.getElementById('studentDental').innerText = data.medical.dental || 'N/A';

          // Parent Info
          document.getElementById('parentSalutation').innerText = data.parent.salutation;
          document.getElementById('parentName').innerText = `${data.parent.firstName} ${data.parent.lastName}`;
          document.getElementById('parentContactNo').innerText = data.parent.contactNo;
          document.getElementById('parentAddress').innerText = data.parent.address;

          // Payment Info
          document.getElementById('paymentMethod').innerText = data.payment.method || 'N/A';
          document.getElementById('receiptPhoto').src = data.payment.receiptPhoto || 'default-receipt.jpg'; // Default if no receipt
        })
        .catch(error => console.error('Error fetching student details:', error));
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Attach click event listeners to evaluate buttons
    document.querySelectorAll('.evaluate-btn').forEach(button => {
      button.addEventListener('click', function() {
        // Retrieve data attributes from the button
        const lrn = this.getAttribute('data-lrn');
        const lastName = this.getAttribute('data-lastName');
        const firstName = this.getAttribute('data-firstName');
        const middleName = this.getAttribute('data-middleName');
        const nickName = this.getAttribute('data-nickName');
        const gender = this.getAttribute('data-gender');
        const religion = this.getAttribute('data-religion');
        const dob = this.getAttribute('data-dob');
        const placeOfBirth = this.getAttribute('data-placeOfBirth');
        const birthCertificateFile = this.getAttribute('data-birthCertificateFile'); // Get directly from the button

        // Update birth certificate container
        const container = document.getElementById('birthCertificateContainer');
        if (birthCertificateFile && birthCertificateFile !== 'null' && birthCertificateFile !== '') {
          container.innerHTML = `
            <div class="text-center">
              <img src="/storage/${birthCertificateFile}" alt="Certificate of Birth" class="img-fluid rounded border mb-3">
              <button type="button" class="btn btn-outline-secondary" onclick="viewFile('${birthCertificateFile}')">View Full Image</button>
            </div>
          `;
        } else {
          container.innerHTML = `
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="editBirthCertificateFile" onchange="updateFileName(this)" name="birthCertificateFile">
                <label class="custom-file-label" for="editBirthCertificateFile">Choose file</label>
              </div>
              <button type="button" class="btn btn-primary" onclick="uploadFile()">Upload</button>
            </div>
          `;
        }

        const medicalIllness = this.getAttribute('data-medicalIllness');
        const medicalAllergies = this.getAttribute('data-medicalAllergies');
        const medicalDental = this.getAttribute('data-medicalDental');
        const medicalAttitudes = this.getAttribute('data-medicalAttitudes');

        const parentsName = this.getAttribute('data-parentsName');
        const parentsNo = this.getAttribute('data-parentsNo');
        const parentsAddress = this.getAttribute('data-parentsAddress');

        const schoolYear = this.getAttribute('data-schoolYear');
        const yearLevel = this.getAttribute('data-yearLevel');
        const sectionAssigned = this.getAttribute('data-sectionAssigned');

        // Populate modal fields
        const fields = {
          editLrn: lrn,
          editLastName: lastName,
          editFirstName: firstName,
          editMiddleName: middleName,
          editNickname: nickName,
          editGender: gender,
          editReligion: religion,
          editDOB: dob,
          editPlaceOfBirth: placeOfBirth,
          editBirthCertificateFile: birthCertificateFile,
          editMedicalIllness: medicalIllness,
          editMedicalAllergies: medicalAllergies,
          editMedicalDental: medicalDental,
          editMedicalAttitudes: medicalAttitudes,
          editParentsName: parentsName,
          editParentsNo: parentsNo,
          editParentsAddress: parentsAddress,
          editSchoolYear: schoolYear,
          editYearLevel: yearLevel,
          editSection: sectionAssigned,

        };

        for (const [fieldId, value] of Object.entries(fields)) {
          const field = document.getElementById(fieldId);
          if (field) {
            field.value = value || ''; // Set value or default to empty
          }
        }
      });
    });
  });

  // Helper function to view the file in a new tab
  function viewFile(fileName) {
    if (!fileName || fileName === 'null') {
      alert('No file available to view.');
      return;
    }
    window.open(`/storage/${fileName}`, '_blank');
  }
</script>

<!-- For age requirements per year level -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const yearLevelDropdown = document.getElementById('yearLevelId');
    const dobInput = document.querySelector('input[name="dob"]');
    const dobError = document.getElementById('dobError');

    yearLevelDropdown.addEventListener('change', function() {
      dobInput.dispatchEvent(new Event('change')); // Trigger age validation on year level change
    });

    dobInput.addEventListener('change', function() {
      const selectedYearLevel = yearLevelDropdown.options[yearLevelDropdown.selectedIndex]?.text || '';
      const dob = new Date(dobInput.value);
      const june30ThisYear = new Date(new Date().getFullYear(), 5, 30);

      dobError.textContent = ''; // Reset error

      if (!dob || isNaN(dob)) {
        dobError.textContent = '';
        return;
      }

      const age = Math.floor((june30ThisYear - dob) / (1000 * 60 * 60 * 24 * 365.25));

      // Validate based on year level
      if (selectedYearLevel === 'NURSERY' && age < 3) {
        dobError.textContent = 'Student must be at least 3 years old as of June 30.';
      } else if (selectedYearLevel === 'K1' && age < 4) {
        dobError.textContent = 'Student must be at least 4 years old as of June 30.';
      } else if (selectedYearLevel === 'K2' && age < 5) {
        dobError.textContent = 'Student must be at least 5 years old as of June 30.';
      } else if (selectedYearLevel.startsWith('GRADE') && age < 7) {
        dobError.textContent = 'Student must be at least 7 years old for this grade level.';
      }
    });
  });
</script>

<script>
  document.getElementById('admissionForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Clear all previous errors and reset borders
    document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');
    document.querySelectorAll('.border-danger').forEach(el => el.classList.remove('border-danger'));

    // Collect form data
    const formData = new FormData(this);

    // Send AJAX request
    fetch('{{ route("storeStudentWithMedical") }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
        },
        body: formData,
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          location.reload();
        } else if (data.errors) {
          // Dynamically display validation errors
          Object.entries(data.errors).forEach(([key, messages]) => {
            const errorElement = document.getElementById(`${key}Error`);
            const wrapperElement = document.getElementById(`${key}Wrapper`);
            if (errorElement) {
              errorElement.textContent = messages[0]; // Display the first error message
              if (wrapperElement) {
                wrapperElement.classList.add('border-danger'); // Highlight the wrapper with a red border
              }
            } else {
              console.warn(`Error key "${key}" does not match any error element.`);
            }
          });
        }
      })
      .catch(error => {
        console.error('Unexpected error:', error); // Log full error details for debugging
        alert('An unexpected error occurred. Please try again later.');
      });
  });
</script>

<!-- Photo preview -->
<script>
  function uploadFile() {
    // Implement file upload logic here if needed
    alert('File upload functionality is not implemented yet.');
  }

  function updateFileName(input) {
    const fileName = input.files[0]?.name || 'Choose file';
    input.nextElementSibling.innerText = fileName;
  }
</script>

<!-- Step progress in form -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.modal-step');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    let currentStep = 0;

    function showStep(stepIndex) {
      steps.forEach((step, index) => {
        step.classList.toggle('d-none', index !== stepIndex);
      });

      // Update button states
      prevBtn.disabled = stepIndex === 0;
      nextBtn.hidden = stepIndex === steps.length - 1;
      submitBtn.classList.toggle('d-none', stepIndex !== steps.length - 1);
    }

    nextBtn.addEventListener('click', () => {
      if (currentStep < steps.length - 1) {
        currentStep++;
        showStep(currentStep);
      }
    });

    prevBtn.addEventListener('click', () => {
      if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
      }
    });

    // Initialize the first step
    showStep(currentStep);
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
@endpush