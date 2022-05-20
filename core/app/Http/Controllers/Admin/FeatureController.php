<?php

namespace App\Http\Controllers\Admin;

use App\Feature;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        if(request()->has('search') && request()->search){
            $key            = trim(strtolower(request()->search));
            $features       = Feature::where('name', 'LIKE', "%$key%")->orderBy('name', 'desc')->paginate(getPaginate());
        }else{
            $features       = Feature::orderBy('name', 'desc')->paginate(getPaginate());
        }

        $page_title     = "All Features";
        $empty_message  = "No Feature Yet";
        return view('admin.feature.index', compact('page_title', 'empty_message', 'features'));
    }

    public function store(Request $request)
    {
        $request->validate([
                'name'  => 'required|string|max:191|unique:features,name',
        ]);

        $feature            = new Feature();
        $feature->name      = $request->name;
        $feature->save();

        $notify[]           = ['success', 'Feature Created Successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'            => 'required|string|max:191|unique:features,name,'.$id,
        ]);

        $feature        = Feature::findOrFail($id);
        $notify[]       = ['success', 'Feature Updated Successfully'];
        $feature->name  = $request->name;
        $feature->save();

        return redirect()->back()->withNotify($notify);
    }

    public function delete(Feature $feature)
    {
        $status = $feature->delete();

        if($status) {
            $notify[]=['success','Feature Deleted Successfully'];
        }else{
            $notify[]=['error','Sorry! Failed To Delete. Please Try Again Letter'];
        }
        return back()->withNotify($notify);

    }
}
