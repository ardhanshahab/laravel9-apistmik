<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nilai;
use App\Http\Resources\NilaiResource;
use Illuminate\Support\Facades\Validator;
class NilaiController extends Controller
{
    public function index()
    {
        // Get all nilais with related mahasiswa and matakuliah
        $nilais = nilai::with('mahasiswa', 'matakuliah')->get();

        return new NilaiResource(true, 'List of Nilai', $nilais);
    }

    public function getNilaiByNim($nim){
        if ($nim) {
            # code...
            $nilai = nilai::where('nim','=',$nim)->firstOrFail();
            return new NilaiResource(true,'Detail of Mahasiswa',$nilai);
            }else{
                return response()->json([
                    "status" => false,"message"=>'Mahasiswa not found'],404);
        }
    }

    public function show($id)
    {
        // Get a single nilai with related mahasiswa and matakuliah
        $nilai = nilai::with('mahasiswa', 'matakuliah')->find($id);

        if (!$nilai) {
            return response()->json(['message' => 'Nilai not found'], 404);
        }

        return new NilaiResource(true, 'Nilai Detail', $nilai);
    }

    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'nim' => 'required|exists:mahasiswas,nim',
            'kd_mk' => 'required|exists:matakuliahs,kd_mk',
            'nilai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create a new nilai
        $nilai = nilai::create([
            'nim' => $request->nim,
            'kd_mk' => $request->kd_mk,
            'nilai' => $request->nilai,
        ]);

        return new NilaiResource(true, 'Nilai Created Successfully', $nilai);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'nim' => 'exists:mahasiswas,nim',
            'kd_mk' => 'exists:matakuliahs,kd_mk',
            'nilai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find the nilai
        $nilai = nilai::find($id);

        if (!$nilai) {
            return response()->json(['message' => 'Nilai not found'], 404);
        }

        // Update the nilai
        $nilai->update([
            'nim' => $request->nim,
            'kd_mk' => $request->kd_mk,
            'nilai' => $request->nilai,
        ]);

        return new NilaiResource(true, 'Nilai Updated Successfully', $nilai);
    }

    public function destroy($id)
    {
        // Find the nilai
        $nilai = nilai::find($id);

        if (!$nilai) {
            return response()->json(['message' => 'Nilai not found'], 404);
        }

        // Delete the nilai
        $nilai->delete();

        return response()->json(['message' => 'Nilai Deleted Successfully']);
    }
}
