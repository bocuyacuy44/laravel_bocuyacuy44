<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$hospitalId = $request->integer('hospital_id');

		$patientsQuery = Patient::query()->with('hospital')->orderBy('name');
		if ($hospitalId) {
			$patientsQuery->where('hospital_id', $hospitalId);
		}

		$hospitals = Hospital::query()->orderBy('name')->get(['id', 'name']);

		if ($request->ajax() || $request->wantsJson() || $request->get('format') === 'json') {
			$allPatients = $patientsQuery->get();
			return response()->json(['patients' => $allPatients]);
		}

		$patients = collect();

		return view('patients.index', [
			'title' => 'Data Pasien',
			'patients' => $patients,
			'hospitals' => $hospitals,
			'selectedHospitalId' => $hospitalId,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$hospitals = Hospital::query()->orderBy('name')->get(['id', 'name']);
		return view('patients.create', [
			'title' => 'Tambah Pasien',
			'hospitals' => $hospitals,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'address' => ['required', 'string'],
			'phone' => ['required', 'string', 'max:30'],
			'hospital_id' => ['required', 'exists:hospitals,id'],
		]);

		Patient::create($validated);

		return redirect()->route('patients.index')->with('success', 'Pasien berhasil ditambahkan.');
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Patient $patient)
	{
		$hospitals = Hospital::query()->orderBy('name')->get(['id', 'name']);
		return view('patients.edit', [
			'title' => 'Edit Pasien',
			'patient' => $patient,
			'hospitals' => $hospitals,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Patient $patient)
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'address' => ['required', 'string'],
			'phone' => ['required', 'string', 'max:30'],
			'hospital_id' => ['required', 'exists:hospitals,id'],
		]);

		$patient->update($validated);

		return redirect()->route('patients.index')->with('success', 'Pasien berhasil diperbarui.');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Patient $patient)
	{
		$patient->delete();

		if (request()->wantsJson()) {
			return response()->json(['message' => 'deleted']);
		}

		return redirect()->route('patients.index')->with('success', 'Pasien dihapus.');
	}
}
