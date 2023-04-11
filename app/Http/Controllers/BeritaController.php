<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Categories;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use DataTables;

class BeritaController extends Controller
{
    private string $icon = 'fa fa-file';


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
    public function index(Request $request)
    {

        $title = __('Berita');
        $routeIndex = route('berita.index');
        $icon = $this->icon;
        $data = Berita::orderBy('id', 'DESC');
        $routeCreate = route('berita.create');
        $type_menu = 'Dashboard';
        $isYajra = true;
        // $beritas = $this->getYajraDataTables($query);

        if ($request->ajax()) {
            $tables = DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tags', 'stisla.crud-example.tags')
                ->editColumn('gambar', 'stisla.berita.gambar')
                ->editColumn('tanggal', '{{\Carbon\Carbon::parse($created_at)->format("d/m/Y H:i:s")}}')
                ->editColumn('created_at', '{{\Carbon\Carbon::parse($created_at)->format("Y-m-d H:i:s")}}')
                ->editColumn('updated_at', '{{\Carbon\Carbon::parse($updated_at)->format("Y-m-d H:i:s")}}')
                ->editColumn('action', function ($berita) {

                    return view('backend.berita.action');
                })
                ->rawColumns(['tags', 'gambar', 'action'])
                ->make(true);
        }
        $user = auth()->user();
        $canCreate = $user->can('Berita Tambah');
        $canUpdate = $user->can('Berita Ubah');
        $canDetail = $user->can('Berita Detail');
        $canDelete = $user->can('Berita Hapus');

        return view('backend.berita.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title = __('Berita');
        $routeIndex = route('berita.index');
        $fullTitle = __('Tambah Berita');
        $kategories = Categories::pluck('nama_kategori', 'id');
        return view('backend.berita.form', [
            'title' => $title,
            'fullTitle' => $fullTitle,
            'kategories' => $kategories,
            'routeIndex' => $routeIndex,
            'action' => route('berita.store'),
            'moduleIcon' => $this->icon,
            'isDetail' => false,
            'breadcrumbs' => [
                [
                    'label' => __('Dashboard'),
                    'link' => url('/')
                ],
                [
                    'label' => $title,
                    'link' => $routeIndex
                ],
                [
                    'label' => 'Tambah'
                ]
            ],
            'type_menu' => 'Post',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $a = $request->file('gambar');
        $b = Str::random(40) . '.' . $a->getClientOriginalExtension();

        $c = Image::make($a->getRealPath())->resize(400, 200);
        $d = '/storage/thumbnail/berita/' . $b;
        $c = Image::make($c)->save(\public_path() . $d);
        $e = Image::make($a)->save(\public_path('/storage/berita/' . $b));

        $x = new Berita();
        $x->judul = $request->judul;
        $x->isi_berita = $request->isi;
        $x->kategori_id = $request->kategori_id;
        $x->tags = $request->tags;
        $x->gambar = '/storage/berita/' . $b;
        $x->thumbnail = $d;
        $x->slug = Str::slug($request->judul);
        $x->user_id = auth()->user()->id;
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
    public function getYajraDataTables($query)
    {
    }
}
