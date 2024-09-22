<?php

namespace App\Http\Controllers;

use App\Models\DynamicFiled;
use App\Models\ProfessionalType;
use App\Models\Ranks;
use App\Models\SupportGroup;
use App\Models\User;
use Illuminate\Http\Request;

class DynamicCatagoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function title()
    {
        $titles = DynamicFiled::where('name','professional_title')->first();
        if($titles){
            $title_array = json_decode($titles->data);
        }else{
            $title_array = [];
        }
        return view('dashboard.dynamic_data.title', compact('title_array'));
    }
    public function deleteTitle($name)
    {
        $titles = DynamicFiled::where('name','professional_title')->first();
        if($titles){
            $title_array = json_decode($titles->data);
            if(($key = array_search($name, $title_array)) !== false) {
                unset($title_array[$key]);
            }
            $titles->data = json_encode(array_values($title_array));
            $titles->save();
        }
        return response()->json(true);
    }
    public function storeTitle(Request $request){
        $titles = DynamicFiled::where('name','professional_title')->first();
        if($titles){
            $tit_array = json_decode($titles->data);
            $tit_array[] = $request->title;
            $titles->data = json_encode($tit_array);
            $titles->save();
        }else{
            $tit_array = [];
            $tit_array[] = $request->title;
            $titles = new DynamicFiled();
            $titles->name = 'professional_title';
            $titles->data = json_encode($tit_array);
            $titles->save();
        }
        return redirect()->back()->with('success', 'Title added successfully');
    }
    public function professionalDocs()
    {
        $professional_docs = DynamicFiled::where('name','professional_docs')->first();
        if($professional_docs){
            $professional_docs_array = json_decode($professional_docs->data);
        }else{
            $professional_docs_array = [];
        }
        // dd($professional_docs_array);
        return view('dashboard.dynamic_data.professional_docs', compact('professional_docs_array'));
    }
    public function deleteProfessionalDocs($name)
    {
        $titles = DynamicFiled::where('name','professional_docs')->first();
        if($titles){
            $title_array = json_decode($titles->data);
            if(($key = array_search($name, $title_array)) !== false) {
                unset($title_array[$key]);
            }
            $titles->data = json_encode(array_values($title_array));
            $titles->save();
        }
        return response()->json(true);
    }
    public function storeProfessionalDocs(Request $request){
        $titles = DynamicFiled::where('name','professional_docs')->first();
        if($titles){
            $tit_array = json_decode($titles->data);
            $tit_array[] = $request->title;
            $titles->data = json_encode($tit_array);
            $titles->save();
        }else{
            $tit_array = [];
            $tit_array[] = $request->title;
            $titles = new DynamicFiled();
            $titles->name = 'professional_docs';
            $titles->data = json_encode($tit_array);
            $titles->save();
        }
        return redirect()->back()->with('success', 'Title added successfully');
    }
    public function rank()
    {
        $ranks = Ranks::all();
        return view('dashboard.dynamic_data.ranks', compact('ranks'));
    }
    public function deleterank($id)
    {
        $rank = Ranks::find($id);
        if($rank){
            $rank->delete();
        }
        return response()->json(true);
    }
    public function storerank(Request $request){
        $request->validate([
            'name' => 'required|string',
        ]);
        Ranks::create($request->all());
        return redirect()->back()->with('success', 'rank added successfully');
    }


    public function category()
    {
        $categories = ProfessionalType::all();
        return view('dashboard.dynamic_data.categories', compact('categories'));
    }
    public function deleteCategory($id)
    {
        $titles = ProfessionalType::find($id);
        if($titles){
            $titles->delete();
        }
        return response()->json(true);
    }
    public function storeCategory(Request $request){
        $request->validate([
            'name' => 'required|string',
        ]);
        // upload icon and save path in db
        if(null !== $request->file('icon')){
            $icon = $request->file('icon')->store('icons');
            $request->merge(['icon' => $icon]);
        }
        $pro = ProfessionalType::create($request->all());
        return redirect()->back()->with('success', 'Title added successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'url' => 'required|string',
        ]);
        SupportGroup::create($request->all());
        return redirect()->back()->with('success', 'Support Group created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportGroup $supportGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportGroup $supportGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupportGroup $supportGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportGroup $supportGroup)
    {
        $supportGroup->delete();
        return response()->json(true);
        // return redirect()->back()->with('success', 'Support Group deleted successfully');
    }
}
