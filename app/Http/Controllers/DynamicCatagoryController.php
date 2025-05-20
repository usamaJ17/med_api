<?php

namespace App\Http\Controllers;

use App\Models\DynamicFiled;
use App\Models\ProfessionalType;
use App\Models\ClinicalNotesField;
use App\Models\ConsultationSummaryField;
use App\Models\ArticleCategory;
use App\Models\Ranks;
use App\Models\DynamicDoc;
use App\Models\SupportGroup;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

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
    public function updateTitle(Request $request)
    {
        $request->validate([
            'oldName' => 'required|string',
            'name' => 'required|string',
        ]);
    
        $titles = DynamicFiled::where('name', 'professional_title')->first();
    
        if ($titles) {
            $title_array = json_decode($titles->data, true);
            
            // Find the index of the old name
            $key = array_search($request->oldName, $title_array);
    
            if ($key !== false) {
                // Update the name in the array
                $title_array[$key] = $request->name;
                $titles->data = json_encode(array_values($title_array));
                $titles->save();
    
                return redirect()->back()->with('success', 'Title updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Old title not found!');
            }
        }
        return redirect()->back()->with('error', 'No title not found!');
    }
    




    
    public function professionalDocs(){
        $professional_docs = DynamicDoc::get();
        return view('dashboard.dynamic_data.professional_docs', compact('professional_docs'));
    }

    public function deleteProfessionalDocs($id){
        DynamicDoc::where('id', $id)
        ->delete();
        return response()->json($deleted > 0);
    }

    public function storeProfessionalDocs(Request $request){
        $exists = DynamicDoc::where('title', $request->title)
        ->exists();
        if (!$exists) {
            DynamicDoc::create([
                'title' => $request->title,
                'doc_type' => $request->doc_type,
            ]);
            return redirect()->back()->with('success', 'Title added successfully');
        }

        return redirect()->back()->with('error', 'Title already exists');
    }

    public function updateProfessionalDocs(Request $request){
        $request->validate([
            'title' => 'required|string',
            'doc_type' => 'required|string',
        ]);

        $titles = DynamicDoc::where('id', $request->id)->first();

        if ($titles) {
            $titles->title = $request->title;
            $titles->doc_type = $request->doc_type;
            $titles->save();
            return redirect()->back()->with('success', 'Title updated successfully');
        }
        return redirect()->back()->with('error', 'No professional documents found');
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
    public function updateRank(Request $request)
    {
        $request->validate([
            'editId' => 'required|integer|exists:ranks,id',
            'name' => 'required|string|max:255',
        ]);
    
        $rank = Ranks::find($request->editId);
    
        if ($rank) {
            $rank->name = $request->name;
            $rank->save();
    
            return redirect()->back()->with('success', 'Rank updated successfully');
        }
    
        return redirect()->back()->with('error', 'Rank not found');
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
            $titles->clearMediaCollection();
            $titles->delete();
        }
        return response()->json(true);
    }
    public function storeCategory(Request $request){
        $request->validate([
            'name' => 'required|string',
            'chat_fee' => 'required|string|max:20',
            'audio_fee' => 'required|string|max:20',
            'video_fee' => 'required|string|max:20',
        ]);
        $pro = ProfessionalType::create($request->all());
        if ($request->hasFile('icon')) {
            $pro->addMedia($request->file('icon'))->toMediaCollection();
        }
        return redirect()->back()->with('success', 'Title added successfully');
    }
    public function updateCategory(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'chat_fee' => 'required|string|max:20',
            'audio_fee' => 'required|string|max:20',
            'video_fee' => 'required|string|max:20',
        ]);
        $category = ProfessionalType::findOrFail($request->id);
        $category->name = $request->name;
        $category->chat_fee = $request->chat_fee;
        $category->audio_fee = $request->audio_fee;
        $category->video_fee = $request->video_fee;
        $category->save();
        // If an icon was uploaded, save it to the media collection
        if ($request->hasFile('icon')) {
            $category->clearMediaCollection();
            $category->addMedia($request->file('icon'))->toMediaCollection();
        }
        return redirect()->back()->with('success', 'Category updated successfully');
    }



    public function article_category()
    {
        $article_categories = ArticleCategory::all();
        return view('dashboard.dynamic_data.article_categories', compact('article_categories'));
    }
    public function deleteArticleCategory($id)
    {
        $titles = ArticleCategory::find($id);
        if($titles){
            $titles->delete();
        }
        return response()->json(true);
    }
    public function storeArticleCategory(Request $request){
        $request->validate([
            'name' => 'required|string',
        ]);        
        $pro = ArticleCategory::create($request->all());
        return redirect()->back()->with('success', 'Category added successfully');
    }
    public function updateArticleCategory(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $summary = ArticleCategory::findOrFail($request->id);
        $summary->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Category updated successfully');
    }
    
    
    public function clinical_notes()
    {
        
        $clinical_notes = ClinicalNotesField::all();
        return view('dashboard.dynamic_data.clinical_notes', compact('clinical_notes'));
    }
    public function deleteClinicalNotes($id)
    {
        $titles = ClinicalNotesField::find($id);
        if($titles){
            $titles->delete();
        }
        return response()->json(true);
    }
    public function storeClinicalNotes(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'is_required' => 'required|string',
        ]);     
        $pro = ClinicalNotesField::create($request->all());
        return redirect()->back()->with('success', 'Clinical Notes added successfully');
    }
    public function updateClinicalNotes(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'is_required' => 'required|string',
        ]);
        $summary = ClinicalNotesField::findOrFail($request->id);
        $summary->update([
            'name' => $request->name,
            'is_required' => $request->is_required,
        ]);

        return redirect()->back()->with('success', 'Note updated successfully');
    }




    
    public function consultation_summary()
    {
        

        $consultation_summary = ConsultationSummaryField::all();
        return view('dashboard.dynamic_data.consultation_summary', compact('consultation_summary'));
    }
    public function deleteCusultationSummary($id)
    {
        $titles = ConsultationSummaryField::find($id);
        if($titles){
            $titles->delete();
        }
        return response()->json(true);
    }
    public function storeCusultationSummary(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'is_required' => 'required|string',
            'type' => 'required|string',
        ]);     
        $pro = ConsultationSummaryField::create($request->all());
        return redirect()->back()->with('success', 'Clinical Notes added successfully');
    }
    public function updateCusultationSummary(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'is_required' => 'required|string',
            'type' => 'required|string',
        ]);
        $summary = ConsultationSummaryField::findOrFail($request->id);
        $summary->update([
            'name' => $request->name,
            'is_required' => $request->is_required,
            'type' => $request->type,
        ]);

        return redirect()->back()->with('success', 'Consultation Summary updated successfully');
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
