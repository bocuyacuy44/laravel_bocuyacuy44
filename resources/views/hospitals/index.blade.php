@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <h4 class="mb-0">{{ $title ?? 'Data Rumah Sakit' }}</h4>
    <a href="{{ route('hospitals.create') }}" class="btn btn-primary">Tambah</a>
  </div>

<div class="mb-3 small">
  <a href="{{ route('dashboard') }}">Dashboard</a> → <strong>Hospitals</strong>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Rumah Sakit</th>
          <th>Alamat</th>
          <th>Email</th>
          <th>Telepon</th>
          <th style="width: 140px">Aksi</th>
        </tr>
      </thead>
      <tbody id="hospitals-body">
        @forelse($hospitals as $hospital)
          <tr data-id="{{ $hospital->id }}">
            <td>{{ $hospital->id }}</td>
            <td>{{ $hospital->name }}</td>
            <td>{{ $hospital->address }}</td>
            <td>{{ $hospital->email }}</td>
            <td>{{ $hospital->phone }}</td>
            <td>
              <a href="{{ route('hospitals.edit', $hospital) }}" class="btn btn-sm btn-warning">Edit</a>
              <button class="btn btn-sm btn-danger btn-delete" data-url="{{ route('hospitals.destroy', $hospital) }}">Hapus</button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center">Tidak ada data.</td>
          </tr>
        @endforelse
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

  function fetchHospitals(pageUrl) {
    const url = pageUrl || `{{ route('hospitals.index') }}`;
    $.ajax({
      url: url,
      method: 'GET',
      data: { format: 'json' },
      headers: { 'Accept': 'application/json' },
      success: function (res) {
        const tbody = $('#hospitals-body');
        tbody.empty();
        if (Array.isArray(res.hospitals) && res.hospitals.length) {
          res.hospitals.forEach(function (h) {
            const tr = `<tr data-id="${h.id}">
                <td>${h.id}</td>
                <td>${h.name}</td>
                <td>${h.address}</td>
                <td>${h.email ?? ''}</td>
                <td>${h.phone ?? ''}</td>
                <td>
                  <a href="/hospitals/${h.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                  <button class="btn btn-sm btn-danger btn-delete" data-url="/hospitals/${h.id}">Hapus</button>
                </td>
              </tr>`;
            tbody.append(tr);
          });
        } else {
          tbody.append('<tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>');
        }
      },
      error: function () { alert('Gagal memuat data rumah sakit.'); }
    });
  }
  $(document).on('click', '.btn-delete', function () {
    const url = $(this).data('url');
    const row = $(this).closest('tr');
    if (!confirm('Yakin hapus data ini?')) return;

    $.ajax({
      url: url,
      type: 'POST',
      data: { _method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content') },
      success: function () {
        row.remove();
      },
      error: function () {
        alert('Gagal menghapus data.');
      }
    });
  });

  $(function () { fetchHospitals(null); });
</script>
@endpush
@endsection


