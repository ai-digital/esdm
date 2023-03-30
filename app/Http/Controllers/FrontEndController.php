<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Menu;
use App\Models\Pengumuman;
use App\Models\Dokumen;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index()
    {
        $main_menu = Menu::all();
        $berita = Berita::orderBy('created_at', 'DESC')->paginate(3);
        $pengumuman = Pengumuman::orderBy('created_at', 'DESC')->paginate(4);
        $galeri_head = Galeri::orderBy('created_at', 'DESC')->skip(0)->limit(1)->get();
        $galeri_thumb = Galeri::orderBy('created_at', 'DESC')->skip(1)->limit(4)->get();

        return view('index', compact('main_menu', 'berita', 'pengumuman', 'galeri_head', 'galeri_thumb'));
    }

    public function berita()
    {
        $main_menu = Menu::all();
        $berita_header = Berita::orderBy('created_at', 'DESC')->paginate(1);
        $berita = Berita::orderBy('created_at', 'DESC')->get();

        return view('berita.index', compact('main_menu', 'berita', 'berita_header'));
    }

    public function content_single($id)
    {
        $main_menu = Menu::all();
        $content = Menu::find($id);
        $berita = Berita::orderBy('created_at', 'DESC')->paginate(3);

        return view('content', compact('main_menu', 'content', 'berita'));
    }

    public function berita_single($slug)
    {
        $main_menu = Menu::all();
        $content = Berita::where('slug', $slug)->first();
        $berita = Berita::orderBy('created_at', 'DESC')->paginate(3);

        return view('berita.single', compact('main_menu', 'content', 'berita'));
    }

    public function pengumuman_single($slug)
    {
        $main_menu = Menu::all();
        $content = Pengumuman::where('slug', $slug)->first();
        $berita = Pengumuman::orderBy('created_at', 'DESC')->paginate(3);

        return view('pengumuman.single', compact('main_menu', 'content', 'berita'));
    }

    public function dokumen_single()
    {
        $main_menu = Menu::all();
        $dokumen_1 = Dokumen::where('id', 1)->get();
        $dokumen_2 = Dokumen::where('id', 2)->get();
        $dokumen_3 = Dokumen::where('id', 3)->get();
        $dokumen_4 = Dokumen::where('id', 4)->get();
        return view('dokumen', compact('main_menu', 'dokumen_1', 'dokumen_2', 'dokumen_3', 'dokumen_4'));
    }
}
