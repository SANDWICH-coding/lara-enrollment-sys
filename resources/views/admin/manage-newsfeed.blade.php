@extends('adminlte::page')

@section('title', 'Blesserd Trinity Academy')

@section('content_header')
<h1>Manage News Feed</h1>
@endsection

@section('content')
<div class="card card-success card-default">
  <div class="card-header">
    <h3 class="card-title">Update Feed</h3>
  </div>
  <div class="card-body">
    <form action="" class="dropzone" id="my-awesome-dropzone">
      <div id="actions" class="col">
        <div class="mb-3">
          <label for="" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
        </div>
        <div class="mb-3">
          <label for="" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" placeholder="Enter description" required></textarea>
        </div>
        <div class="col-lg-6">
          <label for="" class="form-label">Upload Banner <small><em>(Choose jpeg, jpg or png file.)</em></small></label>
          <div class="input-group">
            <button type="" class="btn btn-secondary mb-3">
              <i class="fas fa-upload"></i>
              <span>Upload photo</span>
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="card-footer">
    <button type="submit" class="btn btn-success float-right">Post</button>
  </div>
  <!-- /.card-body -->
  <!-- <div class="card-footer">
    Visit <a href="https://www.dropzonejs.com">dropzone.js documentation</a> for more examples and information about the plugin.
  </div> -->
</div>


<div class="card shadow-sm">
  <!-- Card Header -->
  <div class="card-header bg-primary text-white">
    <h3 class="card-title mb-0">Current Feed</h3>
  </div>

  <!-- Card Body -->
  <div class="card-body">
    <img src="vendor/adminlte/dist/img/enrollment.jpg" alt="Photo 1" class="img-fluid rounded" style="max-height: 300px; width: auto; object-fit: cover;">
    &nbsp;
    <img src="vendor/adminlte/dist/img/enrollment.jpg" alt="Photo 1" class="img-fluid rounded" style="max-height: 300px; width: auto; object-fit: cover;">
    <!-- Post Title -->
    <h2 class="mb-2 mt-2"><strong>Enrollment for the New Academic Year</strong></h2>

    <!-- Post Meta Info -->
    <p class="post-meta">
      <i class="fas fa-calendar-alt me-2 pr-2"></i>Published on: <strong>November 15, 2024</strong>
      <span class="mx-2">|</span>
      <i class="fas fa-user me-2 pr-2"></i>By: <strong>Administrator</strong>
    </p>

    <!-- Post Content -->
    <p class="mb-3">
      We are excited to announce the opening of enrollments for the upcoming academic year!
      Make sure to register early to secure your spot. Check out the updated curriculum and
      new programs available this year.
    </p>

  <!-- Card Footer -->
  <div class="card-footer text-muted">
    <i class="fas fa-clock pr-2"></i>Posted <strong>3 hours ago</strong>
  </div>
</div>


@endsection

@push('js')

@endpush