<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\ECommerce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends ApiController
{
    /**
    * @param Request $request
    * @return UserResource|\Illuminate\Http\JsonResponse
    * @OA\Post (
    *     path="/api/admin/register",
    *     operationId="register",
    *     tags={"admin"},
    *     summary="Admin kayıt",
    *     @OA\RequestBody(
    *      description="Register a admin",
    *      required=true,
    *       @OA\JsonContent(
    *          type="array",
    *          @OA\Items(ref="#/components/schemas/User")
    *     )
    *     ),
    *      @OA\Response(
    *      response=200,
    *      description="Admin created response",
    *      @OA\JsonContent(ref="#/components/schemas/User")
    *
    * ),
    *     @OA\Response(
    *      response=401,
    *      description="Unauthorized",
    *      @OA\JsonContent()
    *     ),
    *     @OA\Response(
    *      response="default",
    *      description="Unexpected Error",
    *      @OA\JsonContent()
    *     ),
    *)
    */
    public function register(Request $request)
    {
        $messages = [
            'email.required' => 'E-mail alanı boş bırakılamaz.',
            'email.unique' => 'Girdiğiniz E-maile ait kayıt bulunmaktadır.',
            'name.required' => 'İsim alanı boş bırakılamaz.',
            'name.min' => 'İsim 3 karakterden küçük olamaz.',
            'surname.required' => 'Soyad alanı boş bırakılamaz.',
            'password.required' => 'Lütfen şifrenizi giriniz.',
            'c_password.required' => 'Lütfen şifre tekrarı giriniz.',
            'c_password.same' => 'Şifre tekrarı eşleşmiyor.',
            'password.min' => 'Şifre 6 karakterden küçük olamaz.',
            'telephone.digits' => 'Telefon numaranızı (5xxxxxxxxx) olarak giriniz.',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|numeric',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password'
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError('Doğrulama hatası.', $validator->errors());
        }

        $admin = User::create([
            'role_id' => $request->roleId,
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => bcrypt($request->password),
            'identity_number' => $request->identityNumber,
            'site_id' => $request->siteId,
        ]);
        $eCommerce = ECommerce::where('id', $admin->site_id)->first();
        if ($eCommerce) {
            $admin['siteId'] = $eCommerce->name;
        } else {
            $admin['siteId'] = null;
        }
        $admin['token'] = $admin->createToken('AdminAuth')->plainTextToken;
        $message = 'Kayıt başarıyla oluşturuldu';
        if ($admin->role_id == 1) {
            $admin->role_id = 'admin';
        } else if ($admin->role_id == 2) {
            $admin->role_id = 'Worker';
        } else if ($admin->role_id = 3) {
            $admin->role_id = 'Customer';
        }
        return $this->sendResponse(new UserResource($admin), $message);
    }

    /**
    * @param Request $request
    * @return UserResource|\Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    * @OA\Post (
    *     path="api/admin/login",
    *     tags={"Admin Login"},
    *     summary="Login",
    *     operationId="login",
    *     @OA\RequestBody(
    *      description="Login a admin",
    *      required=true,
    *      @OA\JsonContent(),
    *     @OA\Schema(
    *               type="object",
    *               required={"email", "password"},
    *               @OA\Property(property="email", type="email"),
    *               @OA\Property(property="password", type="password")
    *            ),
    *     ),
    *     @OA\Response(
    *      response=200,
    *      description="Success Login",
    *      @OA\JsonContent(),
    *   ),
    *     )
    */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Lütfen e-mail ve parola kontrol ediniz.');
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            $auth['token'] = $auth->createToken('UserAuth', ['user'])->plainTextToken;
            if ($auth->role_id == 1) {
                $auth->role_id = 'admin';
            } else if ($auth->role_id == 2) {
                $auth->role_id = 'worker';
            } else if ($auth->role_id = 3) {
                $auth->role_id = 'customer';
            }
            $eCommerce = ECommerce::where('id', $auth->site_id)->first();
            if ($eCommerce) {
                $auth['siteName'] = $eCommerce->name;
            } else {
                $auth['siteName'] = null;
            }
            $message = 'Giriş başarılı';

            return $this->sendResponse(new UserResource($auth), $message);
        } else {
            return $this->sendError('Giriş başarısız.');

        }
    }

    public function logOut(Request $request){
        try{
            $request->user()->tokens()->delete();
            return response()->json(['status'=>'true','message'=>"Çıkış Yapıldı",'data'=>[]]);
        } catch(\Exception $e){
            return response()->json(['status'=>'false','message'=>$e->getMessage(),'data'=>[]],500);
        }
    }
    
}