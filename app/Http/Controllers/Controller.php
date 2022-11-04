<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function permissionDenied() {
        return response()->json([
            'status'=>false,
            'result'=>null,
            'error'=>trans('defaults.permission_denied')
        ]);
    }

    protected function failure($validator) {
        return response()->json([
            'success'=>false,
            'result'=>'',
            'error'=>$validator instanceof Validator ? $validator->messages() : $validator
        ]);
    }

    protected function success($result){

        return response()->json([
            'success'=>true,
            'result'=>$result,
            'error'=>''
        ]);

    }
}
