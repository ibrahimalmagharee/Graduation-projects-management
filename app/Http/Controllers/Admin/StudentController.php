<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $data = Student::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<td><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editStudent"><i class="now-ui-icons shopping_tag-content"></i></a></td>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn = $btn.' <td><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="now-ui-icons ui-1_simple-remove"></i></a></td>';



                    return $btn;

                })


                ->rawColumns(['action'])

                ->make(true);

        }

        return view('Admin.pages.student');
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

        Student::updateOrCreate(['id' => $request->id],
            ['student_id' => $request->student_id,
            'name' => $request->name,
            'email' => $request->email,
            'specialization' => $request->specialization,
            'level' => $request->level]
            );

        return response()->json(['success' => 'Student Added Successfully.']);
/*
        $rules = array(
            'student_id'     => 'required|max:8|min:8',
            'name'           =>  'required',
            'email'          =>  'required|email|unique:users',
            'specialization' =>  'required',
            'level'          =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'id'             => $request->id,
            'student_id'     => $request->student_id,
            'name'           => $request->name,
            'email'          => $request->email,
            'specialization' => $request->specialization,
            'level'          => $request->level,
        );

        Student::updateOrCreate($form_data);

        return response()->json(['success' => 'Student Added successfully.']);
*/
        /*
        $validate_student = $request->validate([
            'student_id' => 'required|max:8|min:8',
            'name'       =>  'required',
            'email'       =>  'required|email|unique:users',
            'specialization'       =>  'required',
            'level'       =>  'required',
        ]);
         */
/*
        Student::updateOrCreate(['id' => $request->id],
            ['student_id' => $request->student_id],
            ['name' => $request->name],
            ['email' => $request->email],
            ['specialization' => $request->specialization],
            ['level' => $request->level],
            );

        return response()->join(['success' => 'Student Added Successfully.']);
*/
        //$student = new Student($validate_student);

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

            $student = Student::findOrFail($id);
            return response()->json( $student);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request)
    {
        $rules = array(
            'student_id'     => 'required|max:8|min:8',
            'name'           =>  'required',
            'email'          =>  'required|email|unique:users',
            'specialization' =>  'required',
            'level'          =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }


        $form_data = array(
            'id'             => $request->id,
            'student_id'     => $request->student_id,
            'name'           => $request->name,
            'email'          => $request->email,
            'specialization' => $request->specialization,
            'level'          => $request->level,
        );
        Student::whereId($request->id)->update($form_data);

        return response()->json(['success' => 'Student is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Student::find($id)->delete();
        return response()->json(['success' => 'Student Deleted Successfully.']);
    }
}
