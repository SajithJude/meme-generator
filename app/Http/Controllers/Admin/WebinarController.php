<?php

namespace App\Http\Controllers\Admin;

use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\DataTables\WebinarsDataTable;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;

class WebinarController extends Controller {

    public function getList(WebinarsDataTable $datatable) {
        return $datatable->render('admin.webinars.webinar-listing');
    }

    public function getWebinarView() {
        return view('admin.webinars.add-webinar');
    }

    public function saveWebinar(Request $request) {
        $image = null;
        if (!empty($request->image)) {
            $uploadImage = self::uploadImage($request->image);
            if ($uploadImage['success'] == false) {
                return redirect()->back()->with('Error occurred while uploading image! please try again');
            }
            $image = $uploadImage['filename'];
        }
        $data = self::prepareData($request, $image);
        $save = Webinar::saveData($data);

        if ($save) {
            return redirect()->route('webinar.list')->with('Saved Successfully!');
        } else {
            return redirect()->back()->with('Error occurred! please try again');
        }
    }

    public function updateWebinar(Request $request) {
        $image = null;
        if (!empty($request->image)) {
            $uploadImage = self::uploadImage($request->image);
            if ($uploadImage['success'] == false) {
                return redirect()->back()->with('Error occurred while uploading image! please try again');
            }
            $image = $uploadImage['filename'];
        }
        $data = self::prepareData($request, $image);
        $data['id'] = $request->id;
        $save = Webinar::updateData($data);
        if ($save) {
            return redirect()->route('webinar.list')->with('Saved Successfully!');
        } else {
            return redirect()->back()->with('Error occurred! please try again');
        }
    }

    public function editWebinar($id) {
        $data = Webinar::getWebinar($id);
        return view('admin.webinars.edit-webinar', compact('data'));
    }

    public static function prepareData($data, $image) {
        $request = $data->toArray();
        $inputs['title'] = $request['title'];
        $inputs['video_url'] = $request['url'];
        $inputs['date'] = $request['date'];
        $inputs['instructor'] = $request['instructor_name'];
        $inputs['type'] = $request['type'];
        $inputs['accessibility'] = (Integer)$request['accessibility'];
        $inputs['image'] = (!empty($image)) ? $image : null;
        return $inputs;
    }

    public function deleteWebinar($id) {
        $id = Crypt::decrypt($id);
        $data = ['is_active' => 0];
        $update = Webinar::where('id', $id)->update($data);

        if ($update) {
            return redirect()->route('webinar.list')->with('Deleted Successfully!');
        } else {
            return redirect()->back()->with('Error occurred! please try again');
        }
    }

    public static function uploadImage($image) {
        $allowedfileExtension = ['jpg', 'jpeg', 'png'];
        $filename = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $check = in_array($extension, $allowedfileExtension);
        if ($check) {
            $image->move(public_path('assets/img'), $filename);

//            $filename = $image->store('public/photos');
            return ['success' => true, 'filename' => $filename];
        } else {
            return ['success' => false];
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $webinar = Webinar::findOrFail($id);
            $webinar->delete();
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Webinar Deleted successfully'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
