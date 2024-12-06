@extends('adminlte::page')

@section('title', 'Blessed Trinity Academy')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
  <h1>Manage Schedules</h1>
</div>
@endsection

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card card-primary mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0" style="flex-grow: 1; text-align: left;">Schedule List</h3>
      </div> <!-- /.card-header -->
      <div class="card-body">
        <!-- Table wrapped in .table-responsive -->
        <div class="table-responsive">
          <table class="table text-nowrap">
            <thead>
              <tr>
                <th>Year Level</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($allYearLevels as $allYearLevel)
              <tr>
                <td>{{ $allYearLevel->yearLevelName }}</td>
                <td>
                  @if($allYearLevel->sections->isEmpty())
                  <p class="text-muted text-sm"><em>No sections available</em></p>
                  @else
                  <table class="table table-sm text-nowrap mb-3">
                    <thead>
                      <tr>
                        <th>Section</th>
                        <th></th>
                        <th>Schedule</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($allYearLevel->sections as $section)
                      @php
                      // Filter sections based on the active school year
                      $activeSections = $section->schoolYear->isActive == 1;
                      @endphp

                      @if($activeSections)
                      <tr>
                        <td>{{ $section->sectionName }}</td>
                        <td>
                          <button
                            class="btn btn-xs bg-gradient-success add-schedule-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#createScheduleModal"
                            data-year-level-id="{{ $allYearLevel->yearLevelId }}"
                            data-section-id="{{ $section->sectionId }}">
                            <i class="fas fw fa-plus"></i>
                          </button>
                        </td>
                        <td>
                          @if($section->schedules->isEmpty())
                          <p class="text-muted text-sm"><em>No schedules available</em></p>
                          @else
                          <table class="table table-sm table-hover text-nowrap mb-3">
                            <tbody>
                              @php
                              // Define the custom order for days of the week
                              $dayOrder = [
                              'Monday' => 1,
                              'Tuesday' => 2,
                              'Wednesday' => 3,
                              'Thursday' => 4,
                              'Friday' => 5,
                              'Saturday' => 6,
                              'Sunday' => 7
                              ];

                              // Sort schedules by day and then by start time in ascending order
                              $sortedSchedules = $section->schedules->sortBy(function ($schedule) use ($dayOrder) {
                              return [$dayOrder[$schedule->day] ?? 0, \Carbon\Carbon::parse($schedule->startTime)];
                              });
                              @endphp

                              @foreach ($sortedSchedules as $schedule)
                              <tr class="custom-row">
                                <td>{{ $schedule->subjectName }}</td>
                                <td>{{ $schedule->day }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->startTime)->format('g:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->endTime)->format('g:i A') }}</td>
                                <td>{{ $schedule->teacherName }}</td>
                                <td>
                                  <div class="dropdown">
                                    <button
                                      class="btn btn-circle btn-sm"
                                      type="button"
                                      id="dropdownMenuButton{{ $schedule->scheduleId }}"
                                      data-bs-toggle="dropdown">
                                      <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $schedule->scheduleId }}">
                                      <li>
                                        <button
                                          class="dropdown-item edit-btn"
                                          data-id="{{ $schedule->scheduleId }}"
                                          data-subjectName="{{ $schedule->subjectName }}"
                                          data-teacherName="{{ $schedule->teacherName }}"
                                          data-day="{{ $schedule->day }}"
                                          data-startTime="{{ $schedule->startTime }}"
                                          data-endTime="{{ $schedule->endTime }}"
                                          data-bs-toggle="modal"
                                          data-bs-target="#editScheduleModal">
                                          <i class="fas fa-edit mr-2"></i>Edit
                                        </button>
                                      </li>
                                      <li>
                                        <form action="{{ route('deleteSchedule', $schedule->scheduleId) }}" method="POST" class="d-inline">
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
                      @endif
                      @endforeach
                    </tbody>
                  </table>
                  @endif
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


<!-- Create Modal -->
<div class="modal fade" id="createScheduleModal" tabindex="-1" aria-labelledby="createScheduleModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header bg-gradient-success text-white">
        <h5 class="modal-title" id="createScheduleModalLabel">Create Schedule</h5>
        <button type="button" class="fas fa-times" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <form id="createScheduleForm" method="POST">
          @csrf
          <!-- Year Level Dropdown -->
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label for="yearLevelId" class="form-label">Year Level <span class="text-danger">*</span></label>
                <select class="form-control" name="yearLevelId" id="yearLevelId">
                  <option value="" disabled selected>--Select Year Level--</option>
                  @foreach ($allYearLevels as $allYearLevel)
                  <option value="{{ $allYearLevel->yearLevelId }}" hidden>{{ $allYearLevel->yearLevelName }}</option>
                  @endforeach
                </select>
                <span id="yearLevelIdError" class="text-danger"></span>
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label for="sectionId" class="form-label">Section <span class="text-danger">*</span></label>
                <select class="form-control" name="sectionId" id="sectionId">
                  <option value="" disabled selected>--Select Section--</option>
                </select>
                <span id="sectionIdError" class="text-danger"></span>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="subjectName" class="form-label">Subject <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="subjectName" name="subjectName" value="{{ old('subjectName') }}">
            <span id="subjectNameError" class="text-danger"></span>
          </div>

          <div class="mb-3">
            <label for="day" class="form-label">Day <span class="text-danger">*</span></label>
            <select class="form-control" name="day" id="day">
              <option value="" disabled selected>--Select Day--</option>
              <option value="Monday">Monday</option>
              <option value="Tuesday">Tuesday</option>
              <option value="Wednesday">Wednesday</option>
              <option value="Thursday">Thursday</option>
              <option value="Friday">Friday</option>
            </select>
            <span id="dayError" class="text-danger"></span>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label for="startTime" class="form-label">Start Time <span class="text-danger">*</span></label>
                <input type="time" class="form-control" id="startTime" name="startTime">
                <span id="startTimeError" class="text-danger"></span>
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label for="endTime" class="form-label">End Time <span class="text-danger">*</span></label>
                <input type="time" class="form-control" id="endTime" name="endTime">
                <span id="endTimeError" class="text-danger"></span>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="teacherName" class="form-label">Teacher <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="teacherName" name="teacherName">
            <span id="teacherName" class="text-danger"></span>
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
<div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gradient-info text-white">
        <h5 class="modal-title" id="editScheduleModalLabel">Edit Schedule</h5>
        <button type="button" class="fas fa-times" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('updateSchedule') }}" method="POST">
          @csrf
          @method('PUT') <!-- Use PUT for updating records -->
          <input type="hidden" name="scheduleId" id="editScheduleId">
          <div class="mb-3">
            <label for="editSubjectName" class="form-label">Subject <span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control"
              id="editSubjectName"
              name="subjectName"
              placeholder="Enter subject"
              required>
          </div>
          <div class="mb-3">
            <label for="editDay" class="form-label">Day <span class="text-danger">*</span"></label>
            <select class="form-control" name="day" id="editDay">
              <option value="" disabled selected>--Select Day--</option>
              <option value="Monday">Monday</option>
              <option value="Tuesday">Tuesday</option>
              <option value="Wednesday">Wednesday</option>
              <option value="Thursday">Thursday</option>
              <option value="Friday">Friday</option>
            </select>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label for="editStartTime" class="form-label">Start Time <span class="text-danger">*</span></label>
                <input type="time" class="form-control" id="editStartTime" name="startTime">
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label for="editEndTime" class="form-label">End Time <span class="text-danger">*</span></label>
                <input type="time" class="form-control" id="editEndTime" name="endTime">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="editTeacherName" class="form-label">Teacher <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="editTeacherName" name="teacherName">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-gradient-primary">Save Changes</button>
          </div>
        </form>
      </div>
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
</style>
<style>
  .btn-xs {
    padding: 0.25rem 0.5rem;
    /* Adjust padding for smaller size */
    font-size: 0.75rem;
    /* Smaller font size */
    line-height: 1.5;
    /* Adjust line height */
    border-radius: 0.2rem;
    /* Optional: smaller border radius */
  }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const yearLevelDropdown = document.getElementById('yearLevelId');
    const sectionDropdown = document.getElementById('sectionId');
    const scheduleButtons = document.querySelectorAll('.add-schedule-btn');

    scheduleButtons.forEach(button => {
      button.addEventListener('click', function() {
        const yearLevelId = this.dataset.yearLevelId;
        const sectionId = this.dataset.sectionId;

        // Set the year level dropdown
        yearLevelDropdown.value = yearLevelId;

        // Fetch and populate the section dropdown
        fetch(`/api/get-sections/${yearLevelId}`)
          .then(response => response.json())
          .then(data => {
            sectionDropdown.innerHTML = '<option value="" disabled selected>--Select Section--</option>';

            data.sections.forEach(section => {
              const option = document.createElement('option');
              option.value = section.sectionId;
              option.textContent = section.sectionName;

              // Disable and hide inactive sections
              if (!section.isActive) {
                option.style.display = 'none'; // Hide the option
              }

              sectionDropdown.appendChild(option);
            });

            // Pre-select the section ID if provided
            sectionDropdown.value = sectionId;
          })
          .catch(error => console.error('Error fetching sections:', error));
      });
    });
  });
</script>

<script>
  // Handle form submission
  document.getElementById('createScheduleForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Clear error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = ''); // Clear only text content

    const formData = new FormData(this);

    fetch('{{ route("storeSchedule") }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData,
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          location.reload(); // Reload the page on success
        } else if (data.errors) {
          Object.entries(data.errors).forEach(([key, messages]) => {
            const errorElement = document.getElementById(`${key}Error`);
            if (errorElement) {
              errorElement.textContent = messages[0];
            } else if (key === 'scheduleConflict') {
              alert(messages[0]); // Show a conflict alert if no dedicated element exists
            }
          });
        }
      })
      .catch(error => {
        console.error('Unexpected error:', error);
        alert('An unexpected error occurred. Please try again.');
      });
  });

  document.addEventListener('DOMContentLoaded', function() {
    // Attach event listener to dynamically populate the Edit modal
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
      button.addEventListener('click', function() {
        const scheduleId = this.getAttribute('data-id');
        const subjectName = this.getAttribute('data-subjectName');
        const teacherName = this.getAttribute('data-teacherName');
        const day = this.getAttribute('data-day');
        const startTime = this.getAttribute('data-startTime');
        const endTime = this.getAttribute('data-endTime');


        // Populate modal fields
        document.getElementById('editScheduleId').value = scheduleId;
        document.getElementById('editSubjectName').value = subjectName;
        document.getElementById('editDay').value = day;
        document.getElementById('editStartTime').value = startTime;
        document.getElementById('editEndTime').value = endTime;
        document.getElementById('editTeacherName').value = teacherName;
      });
    });
  });
</script>
@endpush