<?php

namespace App\Http\Controllers\Item;
use App\item;
use App\categories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            return datatables()->of(item::latest()->get())
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $categories = categories::all();

        return view('Item/Item', compact('categories'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $rules = array(
            'item_name'    =>  'required',
            'item_desc'     =>  'required',
            'category_name'     =>  'required',
            'item_qty'     =>  'required'

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        
        $form_data = array(
      
            'item_name'        =>  $request->item_name,
            'item_desc'        =>  $request->item_desc,
            'category_name'        =>  $request->category_name,
            'item_qty'         =>  $request->item_qty

        );

        item::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            if(request()->ajax())
            {
                $data = item::findOrFail($id);
                return response()->json(['data' => $data]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            'item_name'    =>  'required',
            'item_desc'    =>  'required',
            'category_name'     =>  'required',
            'item_qty'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
        
            'item_name'       =>   $request->item_name,
            'item_desc'       =>   $request->item_desc,
            'category_name'        =>  $request->category_name,
            'item_qty'        =>   $request->item_qty
          
        );
        item::whereid($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = item::findOrFail($id);
        $data->delete($id);
    }

     public function trashindex()
    {
         if(request()->ajax())
        {
            return datatables()->of(item::latest()->onlyTrashed()->get())
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="restore" id="'.$data->id.'" class="restore btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="permdelete" id="'.$data->id.'" class="permdelete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Item/TrashItem');
    }

    public function restore(Request $request, $id)
    {
        item::where('id', $id)->restore();
        return view('item/TrashItem');

    }
}
