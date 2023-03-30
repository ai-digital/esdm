<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_all = Galeri::all();
        return view('admin.galeri.index', compact('get_all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.galeri.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $thumbnail = $request->file('path');
        $extension_thumbnail = $thumbnail->getClientOriginalExtension();

        $path_thumbnail = $thumbnail->storeAs('public/arsip', \time() . '.' . $extension_thumbnail);

        $x = new Galeri();
        $x->nama_menu = $request->nama_menu;
        $x->path = $path_thumbnail;
        $x->slug = Str::slug($request->nama_menu);

        $x->save();

        Alert::success('Berhasil Tambah Galeri', 'Anda Telah Menambahkan Galeri Baru!');

        return \redirect()->route('galeri.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function show(Galeri $galeri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function edit(Galeri $galeri)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Galeri $galeri)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Galeri::destroy($id);
        Alert::error('Berhasil Hapus Galeri', 'Anda Telah Menghapus Galeri!');
        return \redirect()->back();
    }
}
