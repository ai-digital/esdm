<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class MenuController extends Controller
{
    public function menu_tinymce(Request $request)
    {
        $file = $request->file('file');
        $path = url('storage/menu/') . '/' . $file->getClientOriginalName();
        $imgpath = $file->move(public_path('storage/menu/'), $file->getClientOriginalName());
        $fileNameToStore = $path;

        return json_encode(['location' => $fileNameToStore]);
    }

    public function index()
    {
        $get_all = Menu::where('parent_id', '=', NULL)->get();
        return view('admin.menu.index', compact('get_all'));
    }

    public function create_main_menu()
    {
        $get_all = Menu::where('parent_id', '=', NULL)->get();
        return view('admin.menu.tambah', compact('get_all'));
    }

    public function store(Request $request)
    {
        if ($request->file('path') == NULL) {
            $x = new Menu();
            $x->parent_id = $request->parent_id;
            $x->nama_menu = $request->nama_menu;
            $x->keterangan = $request->isi_menu;
            $x->status_menu = $request->status_menu;
            $x->slug = Str::slug($request->nama_menu);

            $x->save();

            Alert::success('Berhasil Tambah menu', 'Anda Telah Menambahkan menu Baru!');

            return \redirect()->route('menu.index');
        } else {
            $thumbnail = $request->file('path');
            $extension_thumbnail = $thumbnail->getClientOriginalExtension();
            $path_thumbnail = $thumbnail->storeAs('public/gambar', \time() . '.' . $extension_thumbnail);

            $x = new Menu();
            $x->parent_id = $request->parent_id;
            $x->nama_menu = $request->nama_menu;
            $x->keterangan = $request->isi_menu;
            $x->path = $path_thumbnail;
            $x->status_menu = $request->status_menu;
            $x->slug = Str::slug($request->nama_menu);

            $x->save();

            Alert::success('Berhasil Tambah menu', 'Anda Telah Menambahkan menu Baru!');

            return \redirect()->route('menu.index');
        }
    }

    public function submenu_index($id)
    {
        $a = Menu::find($id);
        $get_all = Menu::where('parent_id', '=', $id)->get();
        return view('admin.submenu.index_submenu', compact('get_all', 'a'));
    }

    public function create_submenu($id)
    {
        $a = Menu::find($id);
        return view('admin.submenu.tambah_submenu', compact('a'));
    }

    public function edit($id)
    {
        $x = Menu::find($id);

        return view('admin.menu.edit', compact('x'));
    }

    public function update(Request $request, $id)
    {
        if ($request->file('path') == NULL) {
            $x = Menu::find($id);
            $x->nama_menu = $request->nama_menu;
            $x->keterangan = $request->isi_menu;
            $x->status_menu = $request->status_menu;
            $x->slug = Str::slug($request->nama_menu);
            $x->save();

            Alert::success('Berhasil Tambah menu', 'Anda Telah Menambahkan menu Baru!');

            return \redirect()->route('menu.index');
        } else {
            $thumbnail = $request->file('path');
            $extension_thumbnail = $thumbnail->getClientOriginalExtension();
            $path_thumbnail = $thumbnail->storeAs('public/gambar', \time() . '.' . $extension_thumbnail);

            $x = Menu::find($id);
            $x->parent_id = $x->parent_id;
            $x->nama_menu = $request->nama_menu;
            $x->keterangan = $request->isi_menu;
            $x->path = $path_thumbnail;
            $x->status_menu = $request->status_menu;
            $x->slug = Str::slug($request->nama_menu);

            $x->save();

            Alert::success('Berhasil Tambah menu', 'Anda Telah Menambahkan menu Baru!');

            return \redirect()->route('menu.index');
        }
    }

    public function destroy_menu($id)
    {
        Menu::destroy($id);
        Alert::error('Berhasil Hapus Menu', 'Anda Telah Menghapus Menu!');
        return \redirect()->back();
    }

    public function destroy_submenu($id)
    {
        Menu::destroy($id);
        Alert::error('Berhasil Hapus Sub Menu', 'Anda Telah Menghapus Sub Menu!');
        return \redirect()->back();
    }
}
