@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h4 class="mb-0">{{ $title ?? 'Data Pasien' }}</h4>
  <a href="{{ route('patients.create') }}" class="btn btn-primary">Tambah</a>
</div>

<div class="mb-3 small">
  <a href="{{ route('dashboard') }}">Dashboard</a> → <strong>Patients</strong>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mb-3">
  <div class="card-body">
    <div class="row g-2 align-items-end">
      <div class="col-sm-6 col-md-4">
        <label class="form-label">Filter Rumah Sakit</label>
        <select id="filter-hospital" class="form-select">
          <option value="">Semua Rumah Sakit</option>
          @foreach($hospitals as $h)
            <option value="{{ $h->id }}" @selected($selectedHospitalId==$h->id)>{{ $h->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  </div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Pasien</th>
          <th>Alamat</th>
          <th>No Telpon</th>
          <th>Rumah Sakit</th>
          <th style="width: 140px">Aksi</th>
        </tr>
      </thead>
      <tbody id="patients-body">
        @foreach($patients as $p)
          <tr data-id="{{ $p->id }}">
            <td>{{ $p->id }}</td>
            <td>{{ $p->name }}</td>
            <td>{{ $p->address }}</td>
            <td>{{ $p->phone }}</td>
            <td>{{ $p->hospital->name ?? '-' }}</td>
            <td>
              <a href="{{ route('patients.edit', $p) }}" class="btn btn-sm btn-warning">Edit</a>
              <button class="btn btn-sm btn-danger btn-delete" data-url="{{ route('patients.destroy', $p) }}">Hapus</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@push('scripts')
<script>
  function withParams(baseUrl, params) {
    if (!baseUrl) return null;
    try {
      const u = new URL(baseUrl, window.location.origin);
      Object.entries(params || {}).forEach(([k, v]) => {
        if (v === undefined || v === null || v === '') return;
        u.searchParams.set(k, v);
      });
      return u.toString();
    } catch (_) {
      return baseUrl;
    }
  }

  function fetchPatients(hospitalId, pageUrl) {
    const url = pageUrl || `{{ route('patients.index') }}`;
    $.ajax({
      url: url,
      method: 'GET',
      data: { hospital_id: hospitalId, format: 'json' },
      headers: { 'Accept': 'application/json' },
      success: function (res) {
        const tbody = $('#patients-body');
        tbody.empty();
        if (res.patients && res.patients.length) {
          res.patients.forEach(function (p) {
            const tr = `<tr data-id="${p.id}">
                <td>${p.id}</td>
                <td>${p.name}</td>
                <td>${p.address}</td>
                <td>${p.phone}</td>
                <td>${p.hospital ? p.hospital.name : '-'}</td>
                <td>
                  <a href="/patients/${p.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                  <button class="btn btn-sm btn-danger btn-delete" data-url="/patients/${p.id}">Hapus</button>
                </td>
              </tr>`;
            tbody.append(tr);
          });
        } else {
          tbody.append('<tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>');
        }
      },
      error: function () {
        alert('Gagal memuat data pasien.');
      }
    });
  }

  $('#filter-hospital').on('change', function () {
    const hospitalId = $(this).val();
    fetchPatients(hospitalId, null);
  });

  $(document).on('click', '.page-link', function (e) {
    e.preventDefault();
    const pageUrl = $(this).data('url');
    if (!pageUrl) return;
    const hospitalId = $('#filter-hospital').val();
    fetchPatients(hospitalId, pageUrl);
  });

  $(document).on('click', '.btn-delete', function () {
    const url = $(this).data('url');
    const row = $(this).closest('tr');
    if (!confirm('Yakin hapus data ini?')) return;

    $.ajax({
      url: url,
      type: 'POST',
      data: { _method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content') },
      success: function () { row.remove(); },
      error: function () { alert('Gagal menghapus data.'); }
    });
  });

  $(function () {
    const hospitalId = $('#filter-hospital').val();
    fetchPatients(hospitalId, null);
  });
</script>
@endpush
@endsection


