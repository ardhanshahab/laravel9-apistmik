<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MatakuliahResource;
use App\Models\matakuliah;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        //get posts
        $posts = matakuliah::all();

        //return collection of posts as a resource
        return new MatakuliahResource(true, 'List Data Matakuliah', $posts);
    }

    public function getBySemester($semester)
{
    // Validate the semester parameter, assuming it should be an integer
    if (!is_numeric($semester) || $semester < 1) {
        return response()->json(['message' => 'Invalid semester parameter'], 422);
    }

    // Get matakuliah data for the specified semester
    $posts = Matakuliah::where('semester', $semester)->get();

    // Return the filtered collection of matakuliah as a resource
    return new MatakuliahResource(true, "List Data Matakuliah for Semester $semester", $posts);
}

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            // 'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nm_jurusan'     => 'required',
            'nm_mk'     => 'required',
            'kd_mk'     => 'required',
            'kd_kur'     => 'required',
            'kd_jur'     => 'required',
            'semester'     => 'required',
            'sks'   => 'required',
            'nm_intl'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        // $image = $request->file('image');
        // $image->storeAs('public/posts', $image->hashName());

        //create post
        $post = matakuliah::create([
            // 'image'     => $image->hashName(),
            'nm_jurusan'     => $request->nm_jurusan,
            'nm_mk'     => $request->nm_mk,
            'kd_mk'     => $request->kd_mk,
            'kd_kur'     => $request->kd_kur,
            'kd_jur'     => $request->kd_jur,
            'semester'     => $request->semester,
            'sks'     => $request->sks,
            'nm_intl'   => $request->nm_intl,
        ]);

        //return response
        return new MatakuliahResource(true, 'Data Matakuliah Berhasil Ditambahkan!', $post);
    }
    public function show($kd_mk)
    {
        $Matakuliah = matakuliah::where('kd_mk', $kd_mk)->first();

        if (!$Matakuliah) {
            return response()->json([
                'success' => '404',
                'message' => 'Matakuliah not found',
                'data' => '404 Not Found'

            ], 404);
        }
        return new MatakuliahResource(true, 'Data Detail Matakuliah Berhasil Ditemukan!', $Matakuliah);
        // return response()->json(['data' => $Matakuliah]);
    }

    public function update(Request $request, $kodeMatakuliah)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'nm_jurusan' => 'required',
            'nm_mk'      => 'required',
            'kd_mk'      => 'required',
            'kd_kur'     => 'required',
            'kd_jur'     => 'required',
            'semester'   => 'required',
            'sks'        => 'required',
            'nm_intl'    => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find the matakuliah by kodeMatakuliah
        $matakuliah = matakuliah::where('kd_mk', $kodeMatakuliah)->first();

        // Check if matakuliah exists
        if (!$matakuliah) {
            return response()->json(['message' => 'Matakuliah not found'], 404);
        }

        // Update matakuliah
        $matakuliah->update([
            'nm_jurusan' => $request->nm_jurusan,
            'nm_mk'      => $request->nm_mk,
            'kd_mk'      => $request->kd_mk,
            'kd_kur'     => $request->kd_kur,
            'kd_jur'     => $request->kd_jur,
            'semester'   => $request->semester,
            'sks'        => $request->sks,
            'nm_intl'    => $request->nm_intl,
        ]);

        // Fetch the updated data from the database
        $matakuliah = Matakuliah::find($matakuliah->id);

        // Return response
        return response()->json(['success' => true, 'message' => 'Data Matakuliah Berhasil Diubah!', 'data' => $matakuliah]);
    }

    public function destroy($post)
    {
        //delete image
        // Storage::delete('public/posts/'.$post->image);

        //delete post
        $post->delete();

        //return response
        return new MatakuliahResource(true, 'Data Matakuliah Berhasil Dihapus!', null);
    }
}
