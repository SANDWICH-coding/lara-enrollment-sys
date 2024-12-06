@extends('adminlte::page')

@section('title', 'Blesserd Trinity Academy')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
  <h1>Manage Enrollment</h1>
  <!-- <a href="#" class="btn btn-primary">
    New Admission
  </a> -->
</div>
@endsection

@section('content')
<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Enrollment List</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body table-responsive p-0">
    <?php
    function generateRandomData($count = 20)
    {
      $yearLevels = ['Nursery', 'Kinder 1', 'Kinder 2', 'Grade 1', 'Grade 2', 'Grade 3'];
      $sections = ['Section A', 'Section B', 'Section C'];
      $data = [];

      for ($i = 1; $i <= $count; $i++) {
        $data[] = [
          'admission_number' => '2024-1-' . str_pad($i, 4, '0', STR_PAD_LEFT),
          'date_admission' => date('M-d-Y', strtotime('2024-07-' . rand(1, 30))),
          'fullname' => 'New Student ' . $i,
          'year_level' => $yearLevels[array_rand($yearLevels)],
          'section' => $sections[array_rand($sections)],
        ];
      }

      return $data;
    }

    $rows = generateRandomData();
    ?>

    <table class="table text-nowrap table-striped">
      <thead>
        <tr>
          <th>Admission #</th>
          <th>Date of Admission</th>
          <th>LRN</th>
          <th>Fullname</th>
          <th>Year Level</th>
          <th>Section</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td><?= $row['admission_number']; ?></td>
            <td><?= $row['date_admission']; ?></td>
            <td></td>
            <td><?= $row['fullname']; ?></td>
            <td><?= $row['year_level']; ?></td>
            <td><?= $row['section']; ?></td>
            <td>
              <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</button>
              <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
  <!-- /.card-body -->
</div>
@endsection

@push('js')
@endpush