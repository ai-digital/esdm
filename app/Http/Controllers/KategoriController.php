<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use RealRashid\SweetAlert\Facades\Alert;
use Datatables;
use Auth;

class KategoriController extends Controller
{
    private string $icon = 'far fa-square';
    public function __construct()
    {

        // $this->middleware('can:Kategori')->only(['show']);
        // $this->middleware('can:Kategori Tambah')->only(['create', 'store']);
        // $this->middleware('can:Kategori Ubah')->only(['edit', 'update']);
        // $this->middleware('can:Kategori Hapus')->only(['destroy']);
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
                ->rawColumns(['tags', 'gambar', 'action'])
                ->make(true);
        }
        $user = auth()->user();
        $canCreate = $user->can('Kategori Tambah');
        $canUpdate = $user->can('Kategori Ubah');
        $canDetail = $user->can('Kategori Detail');
        $canDelete = $user->can('Kategori Hapus');
        return view('backend.kategori.index', get_defined_vars());
    }
}
