<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_all = Dokumen::where('parent_id', '=', NULL)->get();
        return view('admin.dokumen.index', compact('get_all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_main_menu()
    {
        return view('admin.dokumen.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file('path') == NULL) {
            $x = new Dokumen();
            $x->parent_id = $request->parent_id;
            $x->nama_menu = $request->nama_menu;
            $x->keterangan = $request->isi_menu;
            $x->status_menu = $request->status_menu;
            $x->slug = Str::slug($request->nama_menu);

            $x->save();

            Alert::success('Berhasil Tambah Dokumen', 'Anda Telah Menambahkan Dokumen Baru!');

            return \redirect()->route('dokumen.index');
        } else {
            $thumbnail = $request->file('path');
            $extension_thumbnail = $thumbnail->getClientOriginalExtension();
            $path_thumbnail = $thumbnail->storeAs('public/gambar', \time() . '.' . $extension_thumbnail);

            $x = new Dokumen();
            $x->parent_id = $request->parent_id;
            $x->nama_menu = $request->nama_menu;
            $x->keterangan = $request->isi_menu;
            $x->path = $path_thumbnail;
            $x->status_menu = $request->status_menu;
            $x->slug = Str::slug($request->nama_menu);

            $x->save();

            Alert::success('Berhasil Tambah Dokumen', 'Anda Telah Menambahkan Dokumen Baru!');

            return \redirect()->route('dokumen.index');
        }
    }

    public function submenu_index($id)
    {
        $a = Dokumen::find($id);
        $get_all = Dokumen::where('parent_id', '=', $id)->get();
        return view('admin.dokumen.index_submenu', compact('get_all', 'a'));
    }

    public function create_submenu($id)
    {
        $a = Dokumen::find($id);
        return view('admin.dokumen.tambah_submenu', compact('a'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dokumen  $dokumen
     * @return \Illuminate\Http\Response
     */
    public function show(Dokumen $dokumen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dokumen  $dokumen
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $x = Dokumen::find($id);

        return view('admin.dokumen.edit', compact('x'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dokumen  $dokumen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->file('path') == NULL) {
            $x = Dokumen::find($id);
            $x->parent_id = $request->parent_id;
            $x->nama_menu = $request->nama_menu;
            $x->keterangan = $request->isi_menu;
            $x->status_menu = $request->status_menu;
            $x->slug = Str::slug($request->nama_menu);

            $x->save();

            Alert::success('Berhasil Update Dokumen', 'Anda Telah Mengupdate Dokumen!');

            return \redirect()->route('dokumen.index');
        } else {
            $thumbnail = $request->file('path');
            $extension_thumbnail = $thumbnail->getClientOriginalExtension();
            $path_thumbnail = $thumbnail->storeAs('public/gambar', \time() . '.' . $extension_thumbnail);

            $x = Dokumen::find($id);
            $x->parent_id = $request->parent_id;
            $x->nama_menu = $request->nama_menu;
            $x->keterangan = $request->isi_menu;
            $x->path = $path_thumbnail;
            $x->status_menu = $request->status_menu;
            $x->slug = Str::slug($request->nama_menu);

            $x->save();

            Alert::success('Berhasil Mengupdate Dokumen', 'Anda Telah Mengupdate Dokumen!');

            return \redirect()->route('dokumen.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dokumen  $dokumen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Dokumen::destroy($id);
        Alert::error('Berhasil Hapus Dokumen', 'Anda Telah Menghapus Dokumen!');
        return \redirect()->back();
    }
}
