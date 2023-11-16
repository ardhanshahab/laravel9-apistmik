<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MahasiswaResource;
use Illuminate\Support\Facades\Validator;
use App\Models\mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        //get posts
        $posts = mahasiswa::latest()->paginate(5);

        //return collection of posts as a resource
        return new MahasiswaResource(true, 'List Data Posts', $posts);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            // 'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nim'     => 'required',
            'nm_mhs'     => 'required',
            'jurusan'     => 'required',
            'kelas'     => 'required',
            'masuk_tahun'     => 'required',
            'jk'   => 'required',
            'ttl'   => 'required',
            'gol_darah'   => 'required',
            'nmr_hp'   => 'required',
            'email'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        // $image = $request->file('image');
        // $image->storeAs('public/posts', $image->hashName());

        //create post
        $post = mahasiswa::create([
            // 'image'     => $image->hashName(),
            'nim'     => $request->nim,
            'nm_mhs'     => $request->nm_mhs,
            'jurusan'     => $request->jurusan,
            'kelas'     => $request->kelas,
            'masuk_tahun'     => $request->masuk_tahun,
            'jk'     => $request->jk,
            'gol_darah'   => $request->gol_darah,
            'nmr_hp'   => $request->nmr_hp,
            'email'   => $request->email,
            'ttl'   => $request->ttl,
        ]);

        //return response
        return new MahasiswaResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }
    public function show($nim)
    {
        $mahasiswa = mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa not found'], 404);
        }

        return response()->json(['data' => $mahasiswa]);
    }
}
