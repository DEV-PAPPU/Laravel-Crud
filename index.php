<?php
 
namespace Shafiqsuhag\DentrinoPatientInfo\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Shafiqsuhag\DentrinoPatientInfo\Models\DentrinoPatientInfo;
use Illuminate\Support\Facades\Auth;
 
class DentrinoContactInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return DentrinoPatientInfo::get()->all();
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
        $request['user_id']= Auth::user()->id;
        $request['dentrino_clinic_id']= Auth::user()-> dentrino_clinic_id;   
        // Validation check 
 
 
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'dentrino_clinic_id' => 'required',
            'dentrino_patient_info_id' => 'required',
        ]);
       
        if($validator->fails()){
            
            return response(json_encode(
                [
 
                    'errorMsg' => ($validator->errors()), 
                    'msg'=> '',
                    'data' => ""
 
                ]),400
            );
        }
        else {
           // Create 
            $result = DentrinoPatientInfo::create($request->all());
            return response(
                [
                  
                    'errorMsg' => "", 
                    'msg'=> 'Data has been successfully saved',
                    'data' => $result
 
                ],201
            );
 
        }
        
        
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
        return DentrinoPatientInfo::find($id);
    }
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $errorMsg = "";
        if($id){
            $errorMsg = "ID is required.";
        }

        if($id ){
            $data = DentrinoPatientInfo::find($id);
            if($data === null){
                $errorMsg = "No match found with id : ".$id;
            }else{
                return response(json_encode(
                    [
    
                        'errorMsg' =>"", 
                        'msg'=> $id . ' id is updated.',
                        'data' => $data->update($request->all())
    
                    ]),200
                );
            } 
        }    

        return response(json_encode(
            [
 
                'errorMsg' =>$errorMsg, 
                'msg'=> '',
                'data' => '', 
 
            ]),400
        );
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = DentrinoPatientInfo::find($id);
        if(!$data){
            return response()->json([
                'msg'=>$id . 'id  does not exist'
            ]);
        }else{
            // data found 
             $data->delete();
             
            if( $res === true){
                return response()->json([
                    'msg' => 'Deleted success of id : ' .$id ,
                ]);
            }
            else{
                return response()->json([
                    'msg'=>'Not success'
                ]);
            }
        }
    }
}