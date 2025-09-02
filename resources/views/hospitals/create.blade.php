@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">Tambah Rumah Sakit</div>
  <div class="card-body">
    <form method="POST" action="{{ route('hospitals.store') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Nama Rumah Sakit</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Telepon</label>
        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">
        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection


