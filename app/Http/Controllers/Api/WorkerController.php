<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AddProductResource;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Models\ECommerce;
use App\Models\User;
use App\Models\Role;
use App\Product;
use Illuminate\Http\Request;
use File;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WorkerController extends ApiController
{
    //Çalışan Profili görüntüleme 
    public function getWorkerProfile(Request $request)
    {
        $user = User::find($request->user()->id);
        $user['token'] = $request->bearerToken(); // Kullanıcıya ait token alma işlemi.
        $site = ECommerce::where('id', $user->site_id)->first();
        $user['siteName'] = $site->name;

        $message = 'Profil bilgileriniz başarıyla yüklendi.';

        return $this->sendResponse(new UserResource($user), $message);
    }

    //Telefon numarası güncelleme
    public function updateProfile(Request $request)
    {
        $messages = [
            'telephone.digits' => 'Telefon numaranızı (5xxxxxxxxx) olarak giriniz.',
        ];
        $validator = Validator::make($request->all(), [
            'telephone' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError('Doğrulama hatası.', $validator->errors());
        }
        $profileUpdate = User::find($request->user()->id)
            ->update([     
                'telephone' => $request->telephone,
            ]);
        $message = 'Profil bilgileriniz başarıyla güncellendi.';
        return $this->sendResponse($profileUpdate, $message);
    }

    //Profil resmi güncelleme 
    public function profileImageUpdateandAdd(Request $request)
    {
        $user = User::find($request->user()->id)->first();
        $oldImagePath = $user->image;

        if ($oldImagePath != null) {

            $dnPath = public_path() . $oldImagePath;
            if (File::exists($dnPath)) {
                File::delete($dnPath);
            }
        }
        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('image/profile/'), $image);
        }

        $update_image = User::where('id', $request->user()->id)->update([
            'image' => 'image/profile/' . $image,
        ]);

        $message = 'Profil resmi güncellendi.';
        return $this->sendResponse($update_image, $message);
    }

    //Şifre güncelleme
    public function passwordUpdate(Request $request, $id){
        $messages = [
             'password.required' => 'Lütfen şifrenizi giriniz.',
             'password.min' => 'Şifre 6 karakterden küçük olamaz.',
        ];
        $customer = User::where('id',$id)->update([
            'password' => bcrypt($request->password),
        ]);
        $message = 'Şifre güncellendi';
        return $this->sendResponse($customer, $message);
    }

    //Bütün ÜRÜNLER
    public function getProduct(Request $request)
    {
        $product =Products::where('site_id', $request->input('siteId'))->get();
        $message = '';
        return $this->sendResponse($product, $message);
    } 

    //ÜRÜN ekleme   
    public function addProduct(Request $request)
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
                'product_image' => 'image/product/' . $image,
                'product_price'=>$request->productPrice
            ]);
            $worker = User::find($request->user()->id);
            $add_product->workerId()->attach($worker);
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
               'product_price'=>$request->productPrice

           ]);
           $message = ' Ürün başarıyla güncellendi.';
           return $this->sendResponse($update_product, $message);
       } catch (\Exception $e) {

           $message = 'Ürün güncellenemedi.';
           return $this->sendError($e->getMessage());
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
