<?php

namespace App\Http\Controllers\API;

use App\ApiUser;
use App\Eventlog;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'sur_name' => 'required',
            'agentId' => 'required',
            'email' => 'required|email|unique:api_users',
            'login_name' => 'required',
            'password' => 'required',
            'operatorLevel' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
           $mag = $validator->messages()->first();
           $statusCode = 300;
        }else{

            
            $allRequest = $request->all();

            $logData = [
                'action' => 'create',
                'email' => $request->get('email')
            ];
            $allRequest['password'] = bcrypt($request->get('password'));
            //dd($allRequest);
            $ckTable = ApiUser::where('email',$request->get('email'))->first();

            if (!$ckTable) {
                ApiUser::create($allRequest);
                Eventlog::create($logData);

                $mag = 'User Successfully Created';
                $statusCode = 200;
            }else{
                $mag = 'User Already Exist';
                $statusCode = 300;
            }

        }

        return response()->json($mag,$statusCode);




    }

    public function updateUser(Request $request, $id)
    {

        $getAllInputs = $request->except('password');
        $findUser = ApiUser::find($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'sur_name' => 'required',
            'agentId' => 'required',
            'email' => 'required|email',
            'login_name' => 'required',
        
            'operatorLevel' => 'required',
            'status' => 'required',
        ]);

        if($findUser) {
            if ($validator->fails()) {
                $mag = $validator->messages()->first();
                $statusCode = 300;
             }else{
     
                 
                 $allRequest = $request->all();
     
                 $logData = [
                     'action' => 'update',
                     'email' => $request->get('email'),
     
                 ];
     
                // $allRequest['password'] = bcrypt($request->get('password'));
                 //dd($allRequest);
                 
                $findUser->update($allRequest);
                Eventlog::create($logData);

                $mag = 'User Successfully updated';
                $statusCode = 200;
              
     
             }
        }else{
            $mag = 'User Not Exist';
            $statusCode = 300;
        }
        

        return response()->json($mag,$statusCode);




    }


    public function deleteUser(Request $request, $id)
    {

        $findUser = ApiUser::find($id);

        if($findUser) {
           
            $logData = [
                'action' => 'delete',
                'email' => $findUser->email,

            ];

            $findUser->delete();
            Eventlog::create($logData);

            $mag = 'User Successfully deleted';
            $statusCode = 200;
                

        }else{
            $mag = 'User Not Exist';
            $statusCode = 300;
        }
        

        return response()->json($mag,$statusCode);

    }

    
    
}
