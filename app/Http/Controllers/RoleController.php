<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\Datatables\Datatables;

class RoleController extends Controller

{
    private string $icon = 'far fa-file-alt';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('can:Role');
        $this->middleware('can:Role Tambah')->only(['create', 'store']);
        $this->middleware('can:Role Ubah')->only(['edit', 'update']);
        $this->middleware('can:Role Hapus')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Role::orderBy('id', 'DESC')->get();
        $permission = Permission::get();
        $title = __('Roles');
        $routeIndex = route('roles.index');
        $icon = $this->icon;

        $routeCreate = route('roles.create');
        $type_menu = 'User';
        $isYajra = true;

        // $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$request->id)
        // ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        // ->all();
        if ($request->ajax()) {


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $user = auth()->user();
                    $canUpdate = $user->can('Role Ubah');
                    $canDelete = $user->can('Role Hapus');
                    return view('backend.roles.action', compact('canUpdate', 'canDelete', 'item'));
                })
                ->make(true);
        }
        $user = auth()->user();
        $canCreate = $user->can('Role Tambah');
        $canUpdate = $user->can('Role Ubah');
        $canDetail = $user->can('Role Detail');
        $canDelete = $user->can('Role Hapus');
        return view('backend.roles.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fullTitle = __('Tambah Roles');
        $title = __('Role');
        $routeIndex = route('roles.index');
        $action = route('roles.store');


        $isDetail = false;
        $moduleIcon = $this->icon;

        $checkboxOptions = Permission::pluck('name', 'id');
        $breadcrumbs = [
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
        ];
        $type_menu = 'pengaturan';
        return view('backend.roles.form', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        Alert::success('Berhasil!', 'Anda Telah Menginput Role!');

        return \redirect()->route('roles.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('pages.master.roles.show', compact('role', 'rolePermissions'));
    }

    private function getDetail(Role $role, bool $isDetail = false)
    {

        $title = __('Role Edit');
        $roles = Role::find($role->id);
        //$permission = Permission::get();

        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->pluck('id', 'name');
        dd($rolePermissions);
        // $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
        //     ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
        //     ->all();
        $routeIndex = route('roles.index');
        $permission = Permission::pluck('name', 'id');

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

            'd' => $role,
            'title' => $title,
            'fullTitle' => $isDetail ? __('Detail Role') : __('Ubah Role'),
            'routeIndex' => $routeIndex,
            'action' => route('roles.update', [$roles->id]),
            'moduleIcon' => $this->icon,
            'isDetail' => $isDetail,
            'breadcrumbs' => $breadcrumbs,
            'type_menu' => 'pengaturan',
            'permission' => $rolePermissions,
            'checkboxOptions' => $permission,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::find($id);
        $data = $this->getDetail($roles);
        return view('backend.roles.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));
        Alert::success('Berhasil!', 'Anda Telah Mengubah Role!');
        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        Alert::error('Berhasil!', 'Anda Telah Menghapus Role!');
        return \redirect()->back();
    }
}
