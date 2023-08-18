<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Image,Storage;
use App\Models\TextContent;
use Validator;

class ContentController extends Controller
{
   

    public function __construct() {     

       
               
    }
    public function add(Request $request) {

    	$input = $request->only('type','contenttext');
        
       
        $rules = [
            'contenttext'        =>  'required',            
            'type'         =>  'required|in:TC,PP,CP'            
        ];       
        
        $validator = Validator::make($input, $rules);        
        if ($validator->fails()) {
            if(array_key_exists("user_id", $validator->messages()->messages())){
                //dd($validator->messages()->messages());
                $code = 401;
                $output = ['error' => [ 'code' => $code, 'messages' => ['You dont have permission to perform this action, You may be removed or disabled by admin.'] ] ];
            }else{
                $code = 406;
                $output = ['error' => [ 'code' => $code, 'messages' => $validator->messages()->all() ] ];
            }
        } else {
        	$exists = TextContent::where("type",$input['type'])->first();
            if($exists == NULL)
            {

                $content = new TextContent();
                $content->contenttext =  $input['contenttext']; 
                $content->type =  $input['type']; 
                if($content->save()){
                    $code = 200;
                        $output = ['response'=>['code'=>$code,'messages'=>['Content Added Successfully.']]];
                } 
                else{
                        $code = 409;
                        $output = ['error'=>['code'=>$code,'messages'=>['An error occured while creating content.']]];
                }
            }
            else{
                    
                    
                    $updated=$exists->update(['contenttext'=>$input['contenttext']]);
                    
                    
                    if($updated){
                        $code = 200;
                            $output = ['response'=>['code'=>$code,'messages'=>['Content Updated Successfully.']]];
                    } 
                    else{
                            $code = 409;
                            $output = ['error'=>['code'=>$code,'messages'=>['An error occured while creating content.']]];
                    }
                }
        }

        return response()->json($output, $code);
    }
    
    public function all(Request $request)
    {
    	$input = $request->only('type');
        
         $rules = [
            
            'type'         =>  'required|in:TC,PP,CP'            
            ];
    	
        $validator = Validator::make($input, $rules);
       
        if ($validator->fails()) {
            
                $code = 406;
                $output = ['error' => [ 'code' => $code, 'messages' => $validator->messages()->all() ] ];
           
        } else {
        	      
            $content = TextContent::where("type",$input['type'])->first();
            $response = [];
            if($content != NULL){
                            
               
                $response = ($content);

            }
            else{
               $content = new TextContent();
               $content->contenttext = "";
                
                $response = ($content); 
            }
            $code = 200;
            $output = [
                    'response' => [
                    'code' => $code,
                    'data' => $response,
                    ]
                ];
          }

        return response()->json($output, $code);
    }
  
    public function delete(Request $request)
    {
      $input = $request->only('content_type');
        
         $rules = [            
            'content_type'         =>  'required|in:TC,PP,US,PL'            
            ];
    $validator = Validator::make($input, $rules);
    
    if ($validator->fails()) {
        if(array_key_exists("user_id", $validator->messages()->messages())){
            //dd($validator->messages()->messages());
            $code = 401;
            $output = ['error' => [ 'code' => $code, 'messages' => ['You dont have permission to perform this action, You may be removed or disabled by admin.'] ] ];
        }else{
            $code = 406;
            $output = ['error' => [ 'code' => $code, 'messages' => $validator->messages()->all() ] ];
        }
    } else {
        $response = TextContent::where("content_type",$input['content_type'])->delete();
        if ($response) {
                $code = 200;
                $output = ['error'=>['code'=>$code,'messages'=>['content deleted Successfully']]];
                }else{
                    $code = 409;
                    $output = ['error'=>['code'=>$code,'messages'=>['An error occured while creating course.']]];
                }
        }

        return response()->json($output, $code); 
    }

    
    
        
    
}
