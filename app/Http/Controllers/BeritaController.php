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
use Nette\Utils\Random;

class BeritaController extends Controller
{
    private string $icon = 'fa fa-file';

    public function __construct()
    {

        $this->middleware('can:Berita');
        $this->middleware('can:Berita Tambah')->only(['create', 'store']);
        $this->middleware('can:Berita Ubah')->only(['edit', 'update']);
        $this->middleware('can:Berita Detail')->only(['show']);
        $this->middleware('can:Berita Hapus')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // if ($request->ajax()) {
        $title = __('Berita');
        $routeIndex = route('berita.index');
        $icon = $this->icon;
        $data = Berita::orderBy('id', 'DESC')->get();
        $routeCreate = route('berita.create');
        $type_menu = 'Dashboard';
        $isYajra = true;




        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tags', 'backend.berita.tags')
                ->editColumn('gambar', 'backend.berita.gambar')
                ->editColumn('kategori_id', function ($row) {
                    return $row->kategori->nama_kategori;
                })
                ->editColumn('tanggal', '{{\Carbon\Carbon::parse($created_at)->format("d/m/Y H:i:s")}}')
                ->editColumn('created_at', '{{\Carbon\Carbon::parse($created_at)->format("Y-m-d H:i:s")}}')
                ->editColumn('updated_at', '{{\Carbon\Carbon::parse($updated_at)->format("Y-m-d H:i:s")}}')
                ->editColumn('action', function ($item) {
                    $user = auth()->user();
                    $canUpdate = $user->can('Berita Ubah');
                    $canDetail = $user->can('Berita Detail');
                    $canDelete = $user->can('Berita Hapus');
                    return view('backend.berita.action', compact('canUpdate', 'canDetail', 'canDelete', 'item'));
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
        $validasi = $this->validate($request, [
            'judul' => 'required|min:5|max:200',
            'tanggal' => 'required',
            'isi_berita' => 'required',

        ]);
        if (!$validasi) {
            Alert::error('Gagal!', 'Tolong di cek lagi form!');

            return \redirect()->back();
        }
        //---image resize-- //

        $slug = Str::slug($request->judul);

        $image = $request->file('gambar'); //image
        $b = Str::limit($slug, 32, '-' . time()) . '.' . $image->getClientOriginalExtension(); //rename

        //create thumbnail
        $thumb = Image::make($image->getRealPath())->resize(128, 128, function ($constraint) {
            $constraint->aspectRatio(); //keep aspect ratio
        });

        $path = '/storage/thumbnail/berita/' . $b;
        $thumb = Image::make($thumb)->save(\public_path() . $path);
        $gambar = Image::make($image->getRealPath())->resize(1024, 768, function ($constraint) {
            $constraint->aspectRatio();
        });
        $e = Image::make($gambar)->save(\public_path('/storage/berita/' . $b));
        // ---! end image resize !---//

        // --- save to database ---// $slug = Str::slug($request->judul);
        $x = new Berita();
        $x->judul = Str::title($request->judul);
        $x->isi_berita = $request->isi_berita;
        $x->tanggal = $request->tanggal;
        $x->kategori_id = $request->kategori_id;
        $x->tags = $request->tags;
        $x->gambar = '/storage/berita/' . $b;
        $x->thumbnail = $path;
        $x->slug = $slug;
        $x->user_id = auth()->user()->id;
        $x->save();

        Alert::success('Berhasil!', 'Anda Telah Menginput Berita!');

        return \redirect()->route('berita.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function show($berita)
    {
        $berita = Berita::find($berita);
        $data = $this->getDetail($berita, true);

        return view('backend.berita.form', $data);
    }
    /**
     * get detail data
     *
     * @param Berita $Berita
     * @param bool $isDetail
     * @return array
     */
    private function getDetail(Berita $berita, bool $isDetail = false)
    {

        $title       = __('Berita Edit');
        $routeIndex  = route('berita.index');
        $kategories = Categories::pluck('nama_kategori', 'id');
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'link'  => url('/home')
            ],
            [
                'label' => $title,
                'link'  => $routeIndex
            ],
            [
                'label' => $isDetail ? 'Detail' : 'Ubah'
            ]
        ];

        return [

            'd'               => $berita,
            'gambar'           => $berita->gambar,
            'title'           => $title,
            'fullTitle'       => $isDetail ? __('Detail Berita') : __('Ubah Berita'),
            'routeIndex'      => $routeIndex,
            'action'          => route('berita.update', [$berita->id]),
            'moduleIcon'      => $this->icon,
            'kategories'      => $kategories,
            'isDetail'        => $isDetail,
            'breadcrumbs'     => $breadcrumbs,
            'type_menu' => 'Post',
        ];
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function edit($berita)
    {
        $berita = Berita::find($berita);


        $data = $this->getDetail($berita);

        return view('backend.berita.form', $data);
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
        //  dd($request->gambar);
        $slug = Str::slug($request->judul);
        if ($request->hasFile('gambar')) {
            @unlink(\public_path($bb->gambar));
            @unlink(\public_path($bb->thumbnail));
            $image = $request->file('gambar'); //image
            $b = Str::limit($slug, 32, '-' . time()) . '.' . $image->getClientOriginalExtension(); //rename

            //create thumbnail
            $thumb = Image::make($image->getRealPath())->resize(128, 128, function ($constraint) {
                $constraint->aspectRatio(); //keep aspect ratio
            });
            $path = '/storage/thumbnail/berita/' . $b;
            $thumb = Image::make($thumb)->save(\public_path() . $path);
            $gambar = Image::make($image->getRealPath())->resize(1024, 768, function ($constraint) {
                $constraint->aspectRatio();
            });
            $e = Image::make($gambar)->save(\public_path('/storage/berita/' . $b));
            $gbr = '/storage/berita/' . $b;
            $thb = $path;
        } else {
            $thb = $bb->thumbnail;
            $gbr = $bb->gambar;
        }

        $bb->judul = $request->judul;

        $bb->tanggal = $request->tanggal;
        $bb->isi_berita = $request->isi_berita;
        $bb->kategori_id = $request->kategori_id;
        $bb->gambar = $gbr;
        $bb->thumbnail = $thb;
        $bb->slug = $slug;
        $bb->tags = $request->tags;
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
        try {

            $bb = Berita::find($id);
            @unlink(\public_path($bb->gambar));
            @unlink(\public_path($bb->thumbnail));

            Berita::destroy($id);
            Alert::error('Berhasil Hapus Berita', 'Anda Telah Menghapus Berita!');
            return \redirect()->back();
        } catch (\Exception $e) {

            return \redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
}
