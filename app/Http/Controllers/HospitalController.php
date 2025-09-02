<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$query = Hospital::query()->orderBy('name');

		if (request()->ajax() || request()->wantsJson() || request()->get('format') === 'json') {
			return response()->json(['hospitals' => $query->get()]);
		}

		$hospitals = collect();

		return view('hospitals.index', [
			'title' => 'Data Rumah Sakit',
			'hospitals' => $hospitals,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('hospitals.create', [
			'title' => 'Tambah Rumah Sakit',
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
			'email' => ['nullable', 'email', 'max:255'],
			'phone' => ['nullable', 'string', 'max:30'],
		]);

		Hospital::create($validated);

		return redirect()
			->route('hospitals.index')
			->with('success', 'Rumah Sakit berhasil ditambahkan.');
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Hospital $hospital)
	{
		return view('hospitals.edit', [
			'title' => 'Edit Rumah Sakit',
			'hospital' => $hospital,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Hospital $hospital)
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'address' => ['required', 'string'],
			'email' => ['nullable', 'email', 'max:255'],
			'phone' => ['nullable', 'string', 'max:30'],
		]);

		$hospital->update($validated);

		return redirect()
			->route('hospitals.index')
			->with('success', 'Rumah Sakit berhasil diperbarui.');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Hospital $hospital)
	{
		$hospital->delete();

		if (request()->wantsJson()) {
			return response()->json(['message' => 'deleted']);
		}

		return redirect()->route('hospitals.index')->with('success', 'Rumah Sakit dihapus.');
	}
}
