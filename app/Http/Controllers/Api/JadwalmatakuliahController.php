<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JadwalmatakuliahResource;
use App\Models\matakuliah;
use App\Models\jadwalmatakuliah;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class JadwalMatakuliahController extends Controller
{
    public function index()
    {
        //get posts
        // $posts = jadwalmatakuliah::all();
        $jadwalmatakuliahs = Jadwalmatakuliah::with('matakuliah')->get();


        //return collection of posts as a resource
        return new JadwalmatakuliahResource(true, 'List Data Matakuliah', $jadwalmatakuliahs);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            // 'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kd_mk'     => 'required',
            'hari'     => 'required',
            'masuk'     => 'required',
            'selesai'     => 'required',
            'nama_dosen'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        // $image = $request->file('image');
        // $image->storeAs('public/posts', $image->hashName());

        //create post
        $post = jadwalmatakuliah::create([
            // 'image'     => $image->hashName(),
            'kd_mk'     => $request->kd_mk,
            'hari'     => $request->hari,
            'masuk'     => $request->masuk,
            'selesai'     => $request->selesai,
            'nama_dosen'     => $request->nama_dosen,

        ]);

        //return response
        return new JadwalmatakuliahResource(true, 'Data Matakuliah Berhasil Ditambahkan!', $post);
    }
    public function show($kd_mk)
    {
        $Matakuliah = jadwalmatakuliah::where('kd_mk', $kd_mk)->first();

        if (!$Matakuliah) {
            return response()->json([
                'success' => '404',
                'message' => 'Matakuliah not found',
                'data' => '404 Not Found'

            ], 404);
        }
        return new JadwalmatakuliahResource(true, 'Data Detail Matakuliah Berhasil Ditemukan!', $Matakuliah);
        // return response()->json(['data' => $Matakuliah]);
    }

    public function update(Request $request, $kodeMatakuliah)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'kd_mk'     => 'required',
            'hari'     => 'required',
            'masuk'     => 'required',
            'selesai'     => 'required',
            'nama_dosen'     => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find the matakuliah by kodeMatakuliah
        $matakuliah = jadwalmatakuliah::where('kd_mk', $kodeMatakuliah)->first();

        // Check if matakuliah exists
        if (!$matakuliah) {
            return response()->json(['message' => 'Matakuliah not found'], 404);
        }

        // Update matakuliah
        $matakuliah->update([
           'kd_mk'     => $request->kd_mk,
            'hari'     => $request->hari,
            'masuk'     => $request->masuk,
            'selesai'     => $request->selesai,
            'nama_dosen'     => $request->nama_dosen,
        ]);

        // Fetch the updated data from the database
        $matakuliah = jadwalmatakuliah::find($matakuliah->id);

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
        return new JadwalmatakuliahResource(true, 'Data Matakuliah Berhasil Dihapus!', null);
    }
}
