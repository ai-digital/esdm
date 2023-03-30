<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    public function pengumuman_tinymce(Request $request)
    {
        $file = $request->file('file');
        $path = url('storage/pengumuman/') . '/' . $file->getClientOriginalName();
        $imgpath = $file->move(public_path('storage/pengumuman/'), $file->getClientOriginalName());
        $fileNameToStore = $path;

        return json_encode(['location' => $fileNameToStore]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_all = Pengumuman::all();
        return view('admin.pengumuman.index', compact('get_all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.pengumuman.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $a = $request->file('thumbnail');
        $b = $request->file('thumbnail')->getClientOriginalName();

        $c = Image::make($a->getRealPath())->resize(400, 200);
        $d = '/storage/thumbnail_pengumuman' . $b;
        $c = Image::make($c)->save(\public_path() . $d);

        $x = new Pengumuman();
        $x->judul = $request->judul;
        $x->isi_pengumuman = $request->isi_pengumuman;
        $x->thumbnail = $d;
        $x->slug = Str::slug($request->judul);

        $x->save();

        Alert::success('pengumuman Sudah Diinput ke Sistem!', 'Anda Telah Menginput pengumuman!');

        return \redirect()->route('pengumuman.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function show(pengumuman $pengumuman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $b = Pengumuman::find($id);

        return view('admin.pengumuman.edit', compact('b'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bb = Pengumuman::find($id);

        if ($request->hasFile('thumbnail')) {
            $a = $request->file('thumbnail');
            $b = $request->file('thumbnail')->getClientOriginalName();

            $c = Image::make($a->getRealPath())->resize(400, 200);
            $d = '/storage/thumbnail_pengumuman' . $b;
            $c = Image::make($c)->save(\public_path() . $d);
            $data_path = $d;
        } else {
            $data_path = $bb->thumbnail;
        }

        $bb->judul = $request->judul;
        $bb->isi_pengumuman = $request->isi_pengumuman;
        $bb->thumbnail = $data_path;
        $bb->slug = Str::slug($request->judul);
        $bb->save();

        Alert::success('Berhasil Edit pengumuman', 'Anda Telah Mengedit pengumuman!');
        return \redirect()->route('pengumuman.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pengumuman::destroy($id);
        Alert::error('Berhasil Hapus pengumuman', 'Anda Telah Menghapus pengumuman!');
        return \redirect()->back();
    }
}
