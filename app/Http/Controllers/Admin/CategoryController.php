<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Rules\FileTypeValidate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $pageTitle  = "Category List";
        $categories = Category::paginate(getPaginate(10));

        return view('admin.category.index',compact('pageTitle','categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'image'         => ['nullable','image',new FileTypeValidate(['jpg','jpeg','png'])],
            'description'   => 'required|string'
        ]);

        if(!$request->id)
        {
            $category = new Category();
            $notify[] = ['success', 'Category has been added successfully'];
        }
        else{
            $category           = Category::findOrFail($request->id);
            $notify[]           = ['success', 'Category has been updated successfully'];
        }

        $category->name         = $request->name;
        $category->description  = $request->description;
        $category->icon         = $request->icon;

        $category->save();

        return back()->withNotify($notify);

    }

    public function active($id)
    {
        $category = Category::where('id',$id)->firstOrFail();
        $category->status = 1;
        $category->save();
        $notify[]  = ['success', $category->name.' '.'enabled successfully'];
        return back()->withNotify($notify);
    }
    public function deactive($id)
    {
        $category = Category::where('id',$id)->firstOrFail();
        $category->status = 0;
        $category->save();
        $notify[]  = ['success', $category->name.' '.'disabled successfully'];
        return back()->withNotify($notify);
    }



    public function destroy($id)
    {
        //
    }
}
