@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">Tambah Pasien</div>
  <div class="card-body">
    <form method="POST" action="{{ route('patients.store') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Nama Pasien</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">No Telpon</label>
        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" required>
        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Rumah Sakit</label>
        <select name="hospital_id" class="form-select @error('hospital_id') is-invalid @enderror" required>
          <option value="">Pilih Rumah Sakit</option>
          @foreach($hospitals as $h)
            <option value="{{ $h->id }}" @selected(old('hospital_id')==$h->id)>{{ $h->name }}</option>
          @endforeach
        </select>
        @error('hospital_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection


