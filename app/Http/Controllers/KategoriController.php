<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use RealRashid\SweetAlert\Facades\Alert;
use DataTables;
use Auth;

class KategoriController extends Controller
{
    private string $icon = 'fa-solid fa-list';
    public function __construct()
    {

        $this->middleware('can:Kategori')->only(['show']);
        $this->middleware('can:Kategori Tambah')->only(['create', 'store']);
        $this->middleware('can:Kategori Ubah')->only(['edit', 'update']);
        $this->middleware('can:Kategori Hapus')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $title = __('Kategori');
        $routeIndex = route('kategori.index');
        $icon = $this->icon;
        $data = Categories::orderBy('id', 'DESC');
        $routeCreate = route('kategori.create');
        $type_menu = 'Post';
        $isYajra = true;




        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('created_at', '{{\Carbon\Carbon::parse($created_at)->format("Y-m-d H:i:s")}}')
                ->editColumn('updated_at', '{{\Carbon\Carbon::parse($updated_at)->format("Y-m-d H:i:s")}}')
                ->editColumn('action', function ($item) {
                    $user = auth()->user();
                    $canUpdate = $user->can('Kategori Ubah');

                    $canDelete = $user->can('Kategori Hapus');
                    return view('backend.kategori.action', compact('canUpdate', 'canDelete', 'item'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $user = auth()->user();
        $canCreate = $user->can('Kategori Tambah');
        $canUpdate = $user->can('Kategori Ubah');
        $canDetail = $user->can('Kategori Detail');
        $canDelete = $user->can('Kategori Hapus');
        return view('backend.kategori.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        $title = __('Kategori');
        $routeIndex = route('kategori.index');
        $fullTitle = __('Tambah Kategori');
        $kategories = Categories::pluck('nama_kategori', 'id');
        return view('backend.kategori.form', [
            'title' => $title,
            'fullTitle' => $fullTitle,
            'kategories' => $kategories,
            'routeIndex' => $routeIndex,
            'action' => route('kategori.store'),
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

    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama_kategori' => 'required|min:3|max:200',
        ]);
        if (!$validasi) {
            Alert::error('Gagal!', 'Tolong di cek lagi form!');

            return \redirect()->back();
        }

        // --- save to database ---// 
        $x = new Categories();
        $x->nama_kategori = $request->nama_kategori;
        $x->slugs = \Str::slug($request->nama_kategori);
        $x->user_id = auth()->user()->id;
        $x->save();

        Alert::success('Berhasil!', 'Anda Telah Menginput Categories!');

        return \redirect()->route('kategori.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $Categories
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kategori = Categories::find($id);
        $data = $this->getDetail($kategori, true);

        return view('backend.kategori.form', $data);
    }

    private function getDetail(Categories $Categories, bool $isDetail = false)
    {

        $title = __('Kategori Edit');
        $routeIndex = route('kategori.index');

        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'link' => url('/home')
            ],
            [
                'label' => $title,
                'link' => $routeIndex
            ],
            [
                'label' => $isDetail ? 'Detail' : 'Ubah'
            ]
        ];

        return [

            'd' => $Categories,

            'title' => $title,
            'fullTitle' => $isDetail ? __('Detail Kategori') : __('Ubah Kategori'),
            'routeIndex' => $routeIndex,
            'action' => route('kategori.update', [$Categories->id]),
            'moduleIcon' => $this->icon,

            'isDetail' => $isDetail,
            'breadcrumbs' => $breadcrumbs,
            'type_menu' => 'Post',
        ];
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $Categories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = Categories::findOrFail($id);
        if ($kategori == null) {
            abort(404);
            exit;
        }

        $data = $this->getDetail($kategori);

        return view('backend.kategori.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $Categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bb = Categories::findorFail($id);


        $bb->nama_kategori = $request->nama_kategori;
        $bb->slugs = \Str::slug($request->nama_kategori);


        $bb->save();

        Alert::success('Berhasil Edit', 'Anda Telah Mengedit Kategori!');
        return \redirect()->route('kategori.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $Categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $bb = Categories::find($id);


            Categories::destroy($id);
            Alert::error('Berhasil Hapus Categories', 'Anda Telah Menghapus Kategori!');
            return \redirect()->back();
        } catch (\Exception $e) {

            return \redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
}