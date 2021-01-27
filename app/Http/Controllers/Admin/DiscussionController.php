<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Discussion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $data = Discussion::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<td><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editDiscussion"><i class="now-ui-icons shopping_tag-content"></i></a></td>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn = $btn.' <td><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="now-ui-icons ui-1_simple-remove"></i></a></td>';

                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);

        }

        return view('Admin.pages.discussions');
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
        $discussion = array($request->discussant);
        $discussion_array = json_encode($discussion);
        Discussion::updateOrCreate(['id' => $request->id],
                              ['group' => $request->group,
                               'discussion_date' => $request->discussion_date,
                               'discussion_time' => $request->discussion_time,
                               'discussion_place' => $request->discussion_place,
                               'discussant' => $discussion_array]);

        return response()->json(['success' => 'Discussion Added Successfully.']);
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
        $discussion = Discussion::findOrFail($id);
        return response()->json( $discussion);
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
        Discussion::find($id)->delete();
        return response()->json(['success' => 'Discussion Deleted Successfully.']);
    }
}
