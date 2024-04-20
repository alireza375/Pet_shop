<?php

use Illuminate\Support\Str;
use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


function errorResponse($message = null, $status = 400, $data = null,)
{
    $message = $message ? $message :  'Something went wrong';
    $response  = ['error' => true, 'status' => $status, 'msg' => $message, 'data' =>  $data];
    return response()->json($response, $status);
}

function successResponse($message = null, $data = null, $status = 200)
{
    $message = $message ? $message :  'success';
    $response  = ['error' => false, 'status' => $status, 'msg' => $message, 'data' =>  $data];
    return response()->json($response, $status);
}

function otpVerify($email = null, $otp = null, $type = null)
{

    $message = 'Done';
    $status = true;
    // $otp = Otp::where(['otp' => $request->otp, 'phone' => str_replace(' ', '', $request->phone)])->first();
    $otp = Otp::where(['otp' => str_replace(' ', '', $otp), 'email' => $email])->first();

    if (empty($otp)) {
        return [
            'message' => __("OTP is not valid"),
            'status' => false
        ];
    }
    if (!$otp->type === $type) {
        return [
            'message' => __("OTP is not valid"),
            'status' => false
        ];
    }

    if (Carbon::now() > Carbon::parse($otp->expired_at)) {
        return [
            'message' => __("OTP has been expired"),
            'status' => false
        ];
    }
    if ($status == true) {
        $otp->delete();
    }

    return [
        'message' => $message,
        'status' => $status
    ];



    // // check otp expired or not
    // if (Carbon::now() > Carbon::parse($otp->expired_at)) {
    //     return errorResponse(__('OTP has been expired'));
    // }

    // // phone verify by otp
    // if (!empty($user->phone) && !empty($otp->phone)) {
    //     $user->update([
    //         'is_phone_verified' => ENABLE
    //     ]);

    //     // SSO Verified
    //     User::where('phone', $otp->phone)->update([
    //         'is_phone_verified' => ENABLE
    //     ]);
    //     Seller::where('phone', $otp->phone)->update([
    //         'is_phone_verified' => ENABLE
    //     ]);

    //     $message = "Phone";
    // }

    // // email verify by otp
    // elseif (!empty($user->email) && !empty($otp->email)) {
    //     $user->update([
    //         'is_mail_verified' => ENABLE
    //     ]);

    //     // SSO Verified
    //     User::where('phone', $otp->phone)->update([
    //         'is_mail_verified' => ENABLE
    //     ]);
    //     Seller::where('phone', $otp->phone)->update([
    //         'is_mail_verified' => ENABLE
    //     ]);
    //     $message = "Email";
    // } else {
    //     return errorResponse(__("not_matched", ['key' => __("OTP")]));
    // }

    // $otp->delete();
    // return successResponse(__($message . ' successfully verified'));


}

/**
 * array response
 */

// function errorReturn($message = null, $status = 400, $data = null,)
// {
//     $message = $message ? $message :  __('wrong_message');
//     return  ['success' => false, 'status' => $status, 'message' => $message, 'data' =>  $data];
// }

// function successReturn($message = null, $data = [], $status = 200)
// {
//     $message = $message ? $message :  __('success_message');
//     return ['success' => true, 'status' => $status, 'message' => $message, 'data' =>  $data];
// }
/**
 * Here will be checked, record already exist or not
 */

// function exists($model, $condition, $id = null)
// {
//     if ($id) {
//         return  $model::where($condition)->where('id', '!=', $id)->exists();
//     } else {
//         return  $model::where($condition)->exists();
//     }
// }

/**
 * File upload
 */
function fileUploadAWS($file, $path, $old_file = null)
{
    try {
        $fileObj = Storage::disk('s3')->put($path, $file, 'public');
        $url = Storage::disk('s3')->url.($fileObj);
        // return ["url" => $url,"status" => true];
        if ($old_file != null) {
            $file = explode(IMAGE_URL, $old_file);
            Storage::disk('s3')->delete($file[1]);
        }
        return $url;
    } catch (Exception $e) {
        // return ["status" => false, "message" => $e->getMessage()];
        return $e->getMessage();
    }
}

function fileRemoveAWS($path)
{
    if (Storage::disk('s3')->delete($path)) {
        return true;
    } else {
        return false;
    }
}



function uploadMultipleImages($files)
{
    $images = [];
    foreach ($files as $file) {
        $images[] = fileUploadAWS($file, IMAGE_PATH);
    }
    return $images;
}


// function fileUploadLocal($file, $path, $old_file = null)
// {
//     try {
//         if (!file_exists(public_path($path))) {
//             mkdir(public_path($path), 0777, true);
//         }
//         $file_name = time() . '_' . randomNumber(16) . '_' . $file->getClientOriginalName();
//         $destinationPath = public_path($path);

//         $file_name = str_replace(' ', '_', $file_name);
//         # old file delete
//         if ($old_file) {
//             removeFileLocal($path, $old_file);
//         }
//         # resize image
//         // if (filesize($file) / 1024 > 2048) {

//         //     // enable extension=gd2
//         //     // $file->orientate(); //so that the photo does not rotate automatically

//         //     Image::make($file)->orientate()->save($destinationPath . $file_name, 60);
//         //     // quality = 60 low, 75 medium, 80 original
//         // } else {
//         //     #original image upload
//         //     $file->move($destinationPath, $file_name);
//         // }

//         $file->move($destinationPath, $file_name);

//         return $file_name;
//     } catch (Exception $e) {
//         return null;
//     }
// }

function fileUpload($file, $path, $old_file = null)
 {
     try {
         if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true);
         }
         $file_name = time() . '_' . randomNumber(16) . '_' . $file->getClientOriginalName();
         $destinationPath = public_path($path);

         # old file delete
         if ($old_file) {
            removeFile($path, $old_file);
         }
         # resize image
         if (filesize($file) / 1024 > 2048) {

             // enable extension=gd2
             // $file->orientate(); //so that the photo does not rotate automatically

             Image::make($file)->orientate()->save($destinationPath . $file_name, 60);
             // quality = 60 low, 75 medium, 80 original
         } else {
             #original image upload
             $file->move($destinationPath, $file_name);
         }

         // $file->move($destinationPath, $file_name);

         return $path . $file_name;
     } catch (Exception $e) {
         // dd($e);
         return null;
     }
 }


function removeFile($path)
{
    try {
        if (file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    } catch (Exception $e) {
        return null;
    }

}

function removeFileLocal($path, $old_file)
{
    $url =  public_path($path);
    $old_file_name = str_replace($url . '/', '', $old_file);

    if (isset($old_file) && $old_file != "" && file_exists($path . $old_file_name)) {
        unlink($path . $old_file_name);
    }
    return true;
}

/**
 ** Random String
 */
// function randomString($a = 10)
// {
//     $x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
//     // $x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
//     $c = strlen($x) - 1;
//     $z = '';
//     for ($i = 0; $i < $a; $i++) {
//         $y = rand(0, $c);
//         $z .= substr($x, $y, 1);
//     }
//     return $z;
// }

/**
 * Random number
 */
function randomNumber($a = 10)
{
    $x = '0123456789';
    $c = strlen($x) - 1;

    $z = rand(1, $c);       # first number never taken 0

    for ($i = 0; $i < $a - 1; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }

    return $z;
}

/**
 * unique slug for products
 */
function slug($mode, $name, $id = null)
{
    $slugInc = null;
    $productData['slug'] = Str::slug($name);

    do {
        $productData['slug'] = $slugInc ? Str::slug($name . '_' . $slugInc) : Str::slug($name);
        if ($id) {
            $existSlug = $mode::where('slug', $productData['slug'])->where('id', '!=', $id)->exists();
        } else {
            $existSlug = $mode::where('slug', $productData['slug'])->exists();
        }
        if ($slugInc >= 1) {
            $slugInc++;
        } else {
            $slugInc = 1;
        }
    } while ($existSlug);

    return  $productData['slug'];
}
