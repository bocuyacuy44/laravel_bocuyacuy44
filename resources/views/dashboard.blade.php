@extends('layouts.app')

@section('content')
<div class="p-4 bg-light rounded-3">
    <h1 class="display-6 mb-0">Dashboard</h1>
    <p class="text-muted mb-0">Login berhasil. CRUD klik tombol di bawah ini.</p>
    <div class="mt-3">
        <a href="{{ route('hospitals.index') }}" class="btn btn-outline-secondary btn-sm">Data Rumah Sakit</a>
        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary btn-sm">Data Pasien</a>
    </div>
</div>
@endsection


