<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class BeritaController extends Controller
{

    public function berita_tinymce(Request $request)
    {
        $file = $request->file('file');
        $path = url('storage/berita/') . '/' . $file->getClientOriginalName();
        $imgpath = $file->move(public_path('storage/berita/'), $file->getClientOriginalName());
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
        $get_all = Berita::all();
        return view('admin.berita.index', compact('get_all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.berita.tambah');
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
        $d = '/storage/thumbnail_berita' . $b;
        $c = Image::make($c)->save(\public_path() . $d);

        $x = new Berita();
        $x->judul = $request->judul;
        $x->isi_berita = $request->isi_berita;
        $x->thumbnail = $d;
        $x->slug = Str::slug($request->judul);

        $x->save();

        Alert::success('Berita Sudah Diinput ke Sistem!', 'Anda Telah Menginput Berita!');

        return \redirect()->route('berita.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function show(Berita $berita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $b = Berita::find($id);

        return view('admin.berita.edit', compact('b'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bb = Berita::find($id);

        if ($request->hasFile('thumbnail')) {
            $a = $request->file('thumbnail');
            $b = $request->file('thumbnail')->getClientOriginalName();

            $c = Image::make($a->getRealPath())->resize(400, 200);
            $d = '/storage/thumbnail_berita' . $b;
            $c = Image::make($c)->save(\public_path() . $d);
            $data_path = $d;
        } else {
            $data_path = $bb->thumbnail;
        }

        $bb->judul = $request->judul;
        $bb->isi_berita = $request->isi_berita;
        $bb->thumbnail = $data_path;
        $bb->slug = Str::slug($request->judul);
        $bb->save();

        Alert::success('Berhasil Edit Berita', 'Anda Telah Mengedit Berita!');
        return \redirect()->route('berita.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Berita::destroy($id);
        Alert::error('Berhasil Hapus Berita', 'Anda Telah Menghapus Berita!');
        return \redirect()->back();
    }
}
