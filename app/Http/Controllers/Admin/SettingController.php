<?php

namespace App\Http\Controllers\Admin;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\DataTables\SettingsDataTable;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index(SettingsDataTable $datatable)
    {
        return $datatable->render('admin.settings.index');

    }
    
    public function edit($id)
    {
        try {
            $setting = GeneralSetting::findOrFail($id);
            return response()->json([
                'status' => true,
                'data' => $setting
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|regex:/^[A-Za-z 0-9]+$/',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $setting = GeneralSetting::findOrFail($id);
            $setting->update([
                'title' => $request->title,
                'value' => $request->value,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Settings Updated Successfully'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
