<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicalDetail;
use App\Models\ProfessionalDetails;
use App\Models\ProfessionalType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function removeAccount(Request $request)
    {
        $user = auth()->user();
        $user->deleted_by = $user->id;
        $user->save();
        $user->delete();
        $data = [
            "status" => 200,
            "message" => "User Removed successfully",
            "data" => []
        ];
        return response()->json($data, $data["status"]);
    }


    public function saveProfessionalDetails(Request $request)
    {
        $pro = ProfessionalDetails::updateOrCreate(['user_id' => Auth::id()], $request->all());
        // if (null !== $request->file('id_card')) {
        //     $pro->clearMediaCollection('id_card');
        //     $pro->addMedia($request->file('id_card'))->toMediaCollection('id_card');
        // }
        // if (null !== $request->file('signature')) {
        //     $pro->clearMediaCollection('signature');
        //     $pro->addMedia($request->file('signature'))->toMediaCollection('signature');
        // }
        // if (null !== $request->file('degree_file')) {
        //     $pro->clearMediaCollection('degree_file');
        //     $pro->addMedia($request->file('degree_file'))->toMediaCollection('degree_file');
        // }

        $fileFields = array_keys($request->files->all());

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $pro->clearMediaCollection($field);
                $pro->addMedia($request->file($field))->toMediaCollection($field);
            }
        }

        if ($request->has("name_title")) {
            $user = User::find(Auth::id());
            $user->name_title = $request->name_title;
            $user->save();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Details Saved Successfully...',
            'data'   => $pro,
        ], 200);
    }
    public function getProfessionalDetails()
    {
        $pro = ProfessionalDetails::where('user_id', Auth::id())->first();
        
        if (!$pro) return response()->json([
            'status' => 404,
            'message' => 'Details Not Found...',
        ], 404);
        return response()->json([
            'status' => 200,
            'message' => 'Details Fetched Successfully...',
            'data'   => $pro,
        ], 200);
    }
    public function checkApprove(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $data = [
                'is_verified' => $user->is_verified,
            ];
            return response()->json([
                'status' => 200,
                'data'   => $data,
            ]);
        }
    }
    public function saveMedicalDetails(Request $request)
    {
        $med = MedicalDetail::updateOrCreate(['user_id' => Auth::id()], $request->all());
        foreach ($request->allFiles() as $key => $file) {
            if (strpos($key, 'file_type_') === 0) {
                $med->clearMediaCollection($key);
                $med->addMedia($file)->toMediaCollection($key);
            }
        }
        // get all file_type media urls
        $media = $med->getMedia();
        return response()->json([
            'status' => 200,
            'message' => 'Details Saved Successfully...',
            'data'   => $med,
        ], 200);
    }
    public function getMedicalDetails(Request $request)
    {
        if (isset($request->patient_id)) {
            $med = MedicalDetail::where('user_id', $request->patient_id)->first();
        } else {
            $med = MedicalDetail::where('user_id', Auth::id())->first();
        }
        if (!$med) return response()->json([
            'status' => 404,
            'message' => 'Details Not Found...',
        ], 404);
        return response()->json([
            'status' => 200,
            'message' => 'Details Fetched Successfully...',
            'data'   => $med,
        ], 200);
    }
    public function completeProfile(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User Not Found...',
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Profile Completed Successfully...',
                'data'   => $user->prepareUserData(),
            ], 200);
        }
    }
    public function getMedicalProfessionals(Request $request)
    {
        $query = User::with(['professionalDetails', 'MedReviews'])->role('medical');
        
        $query->where('is_verified', true);
    
        // Filter by professional ID
        if ($request->has('professional_id') && $request->professional_id != "") {
            $query->where('id', $request->professional_id);
        }
    
        // Filter by professional type ID
        if ($request->has('professional_type_id') && $request->professional_type_id != "") {
            $query->where('professional_type_id', $request->professional_type_id);
        }
    
        // Filter by search (first name or last name)
        if ($request->has('search') && $request->search != "") {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }
    
        // Filter by date
        if ($request->has('date') && $request->date != "") {
            $query->whereDate('created_at', $request->date);
        }
    
        // Filter by time (example: availability at a specific time)
        if ($request->has('time') && $request->time != "") {
            $query->whereTime('created_at', $request->time);
        }
    
        // Filter by location
        if ($request->has('location') && $request->location != "") {
            $query->where(function ($q) use ($request) {
                $q->where('country', 'like', '%' . $request->location . '%')
                    ->orWhere('state', 'like', '%' . $request->location . '%')
                    ->orWhere('city', 'like', '%' . $request->location . '%');
            });
        }
    
        if ($request->has('rating') && $request->rating != "") {
            $query->whereHas('MedReviews', function ($q) use ($request) {
                $q->where('rating', '>=', $request->rating);
            });
        }
    
        // Filter by language
        if ($request->has('language') && $request->language != "") {
            $query->where('language', 'like', '%' . $request->language . '%');
        }
    
        // Filter by online health professional (e.g., is_live field)
        if ($request->has('online') && $request->online != "") {
            $query->where('is_live', $request->online);
        }
    
        // Filter by category ID
        if ($request->has('category_id') && $request->category_id != "") {
            $query->whereHas('professionalType', function ($q) use ($request) {
                $q->where('id', $request->category_id);
            });
        }
    
        // Get the filtered results
        $professionals = $query->get();
    
        return response()->json([
            'status' => 200,
            'message' => 'Details Fetched Successfully...',
            'data' => $professionals,
        ], 200);
    }
    
    public function getMedicalProfessionalsMetaData(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) return response()->json([
            'status' => 404,
            'message' => 'Professional Not Found...',
        ], 404);
        $data = $user->professionalMetaData();
        return response()->json([
            'status' => 200,
            'message' => 'Details Fetched Successfully...',
            'data'   => $data,
        ], 200);
    }
    public function storeProfessionalType(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        // upload icon and save path in db
        if (null !== $request->file('icon')) {
            $icon = $request->file('icon')->store('icons');
            $request->merge(['icon' => $icon]);
        }
        $pro = ProfessionalType::create($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Professional Type Created Successfully...',
            'data'   => $pro,
        ], 200);
    }
    public function getProfessionalType()
    {
        $pro = ProfessionalType::all();
        return response()->json([
            'status' => 200,
            'message' => 'Professional Type Fetched Successfully...',
            // 'data'   => ['professional_types' => $pro,'total' => $pro->count() ?? 0],
            'data'   =>  $pro,
        ], 200);
    }
    public function updateProfessionalType(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        $pro = ProfessionalType::find($id);
        if (!$pro) return response()->json([
            'status' => 404,
            'message' => 'Professional Type Not Found...',
        ], 404);
        // upload icon and save path in db
        if (null !== $request->file('icon')) {
            $icon = $request->file('icon')->store('icons');
            $request->merge(['icon' => $icon]);
        }
        $pro->update($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Professional Type Updated Successfully...',
            'data'   => $pro,
        ], 200);
    }
    public function deleteProfessionalType($id)
    {
        $pro = ProfessionalType::find($id);
        if (!$pro) return response()->json([
            'status' => 404,
            'message' => 'Professional Type Not Found...',
        ], 404);
        $pro->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Professional Type Deleted Successfully...',
        ], 200);
    }
}
