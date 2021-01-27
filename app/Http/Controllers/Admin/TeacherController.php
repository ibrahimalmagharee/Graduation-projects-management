<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $teacher = Teacher::latest()->get();
            return DataTables::of($teacher)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<td><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editTeacher"><i class="now-ui-icons shopping_tag-content"></i></a></td>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn = $btn.' <td><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="now-ui-icons ui-1_simple-remove"></i></a></td>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.pages.teacher');
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
        Teacher::updateOrCreate(['id' => $request->id],
               ['name' => $request->name,
                'email' => $request->email,
                'job' => $request->job,
                'department' => $request->department]
        );

        return response()->json(['success' => 'Teacher Added Successfully.']);
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
        $teacher = Teacher::findOrFail($id);
        return response()->json($teacher);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Teacher::find($id)->delete();
        return response()->json(['success' => 'Teacher Deleted Successfully.']);
    }
}
