<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Resources\AddProductResource;
use App\Models\Address;
use App\Models\Admin;
use App\Models\Products;
use App\Models\ECommerce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Response;
use File;
use App\Http\Controllers\Controller as BaseController;
use App\Product;

class AdminController extends ApiController
{
    public function eCommerceRegister(ECommerce $ECommerce, Request $request)
    {
        $this->authorize('admin');
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'website' => 'required',
            'authorizedPerson' => 'required',
        ]);
        if ($validated->fails()) {
            return response()->json(['error' => $validated->errors()->all()]);
        }

        $address = Address::create([
            'city_id' => $request->city_id,
            'address' => $request->address,
            'telephone' => $request->telephone,
            'tax_number' => $request->tax_number,
        ]);

        $site = ECommerce::create([
            'address_id' => $address->id,
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website,
            'logo' => $request->logo,
            'color1' => $request->color1,
            'color2' => $request->color2,
            'color3' => $request->color3,
            'authorized_person' => $request->authorizedPerson,
            'ip_address' => $request->ipAddress,
            'licence_start_date' => $request->licenceStartDate,
            'licence_update_date' => $request->licenceUpdateDate,
            'licence_end_date' => $request->licenceEndDate,
        ]);
        if ($ECommerce) {
            return response()->json(['success' => ['Siteniz kaydı tamamlandı.']], 200);
        } else {
            return response()->json(['error' => ['Bilgileriniz eksik veya yanlış.']], 200);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *  @OA\Post (
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

    //Admin Profili görüntüleme 
    public function getAdminProfile(Request $request)
    {
        $user = User::find($request->user()->id);
        $user['token'] = $request->bearerToken(); // Kullanıcıya ait token alma işlemi.
        $site = ECommerce::where('id', $user->site_id)->first();
        $user['siteName'] = $site->name;

        $message = 'Profil bilgileriniz başarıyla yüklendi.';
        return $this->sendResponse(new UserResource($user), $message);
    }

    //Bütün ÜRÜNLER
    public function getProduct(Request $request)
    {
        $product =Products::where('site_id', $request->input('siteId'))->get();
        $message = '';
        return $this->sendResponse($product, $message);
    } 

    //ÜRÜN ekleme   
    public function addproduct(Request $request)
    {
        if ($request->hasFile('productImage')) {
            $image = time() . '.' . $request->productImage->getClientOriginalExtension();
            $request->productImage->move(public_path('image/product/'), $image);
        }
        try {
            $add_product = Products::create([
                'site_id' => $request->siteId,
                'product_code' => $request->productCode,
                'product_name' => $request->productName,
                'product_image' => 'image/product/' . $image
            ]);
            $worker = User::find($request->user()->id);
            $add_product->adminId()->attach($worker);
            $message = 'Ürün kaydı tamamlandı.';
            return $this->sendResponse(new AddProductResource($add_product), $message);
        } catch (\Exception $e) {

            $message = 'Ürün kaydı tamamlanamadı.';
            return $this->sendError($message);
        }
    }

   //Ürün Güncelleme 
   public function updateProduct(Request $request, $id)
   {
       $product = Products::find($id)->first();
       $oldImagePath = $product->product_image;

       if ($oldImagePath != null) {

           $dnPath = public_path() . $oldImagePath;
           if (File::exists($dnPath)) {
               File::delete($dnPath);
           }
       }
       if ($request->hasFile('productImage')) {
           $image = time() . '.' . $request->productImage->getClientOriginalExtension();
           $request->productImage->move(public_path('image/product/'), $image);
       }
       try {
           $update_product = Products::where('id', $id)->update([
               'product_image' => 'image/product/' . $image,
               'product_name' => $request->productName,
           ]);
           $message = ' Ürün başarıyla güncellendi.';
           return $this->sendResponse($update_product, $message);
       } catch (\Exception $e) {

           $message = 'Ürün güncellenemedi.';
           return $this->sendError($message);
       }
   }

   //Ürün Silme 
    public function deleteProduct($id)
    {
        try {
            $product_find = Products::find($id);
            $product_image = $product_find->product_image;
            if ($product_image != null) 
                $dnPath = public_path() . "/" . $product_image;
                if (File::exists($dnPath)) {
                    File::delete($dnPath);
                }
            $delete_product = $product_find->delete();

            $message = "Ürün Silindi.";
            return $this->sendResponse($delete_product, $message);
        } catch (\Exception $e) {

            $message = "Bir hata oluştu.";
            return $this->sendError($message);
        }
    }

}
