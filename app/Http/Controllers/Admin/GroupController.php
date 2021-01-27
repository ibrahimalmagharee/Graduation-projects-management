<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Group;
use App\Admin\Project;
use App\Admin\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $data = Group::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<td><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editGroup"><i class="now-ui-icons shopping_tag-content"></i></a></td>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn = $btn.' <td><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="now-ui-icons ui-1_simple-remove"></i></a></td>';

                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);

        }

        return view('Admin.pages.group');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $student = array($request->student);
        $stdudent_array = json_encode($student);
        Group::updateOrCreate(['id' => $request->id],
            ['group_number' => $request->group_number,
            'student' => $stdudent_array,
            'project' => $request->project,
            'supervisor' => $request->supervisor]);

        return response()->json(['success' => 'Group Added Successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id);
        return response()->json( $group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Group::find($id)->delete();
        return response()->json(['success' => 'Group Deleted Successfully.']);
    }
}
