<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AddProductResource;
use App\Http\Resources\AnnouncementResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Models\Announcement;
use App\Models\ECommerce;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\User;
use App\Product;
use Exception;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CustomerController extends ApiController
{

    //Müşteri profil bilgilerinin döndüğü api
    public function getCustomerProfile(Request $request)
    {
        $user = User::find($request->user()->id);
        $user['token'] = $request->bearerToken(); // Kullanıcıya ait token alma işlemi.
        $site = ECommerce::where('id', $user->site_id)->first();
        $user['siteName'] = $site->name;

        $message = 'Profil bilgileriniz başarıyla yüklendi.';

        return $this->sendResponse(new UserResource($user), $message);
    }

    //müşterinin aldığı ürünlerin listelendiği api
    public function getCustomerProduct(Request $request)
    {
        $user = User::find($request->user()->id);
        $customer = $user->products()->where('product.isActive', '=', '1')->get(); 
        $message = '';
        return $this->sendResponse(ProductResource::collection($customer), $message);
    }

    //Bütün ÜRÜNLER
    public function getProduct(Request $request)
    {
        
        $product =Products::where('site_id', $request->input('siteId'))->get();
        $message = '';
        return $this->sendResponse(ProductResource::collection($product), $message);
    }

    //müşterinin ürünlerine ait duyuruların listelendiği apiler
    public function getAnnouncement(Request $request)
    {
        $productId = $request->user()
            ->products()
            ->pluck('product_id');

        $result = Announcement::whereIn('product_id', $productId)
            ->join('products', 'products.id', '=', 'announcements.product_id')
            ->select('product_name', 'head', 'body', 'announcements.created_at', 'announcements.isActive')
            ->where('announcements.isActive', 1)
            ->latest('announcements.created_at')
            ->get();

        return $this->sendResponse(AnnouncementResource::collection($result), __('Başarılı sonuç'));
    }

    //Müşteri bilgilerinin güncellendiği api
    public function profileUpdate(Request $request)
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
    
    //Şifre Güncelleme
    public function passwordUpdate(Request $request, $id){
        $messages = [
             'password.required' => 'Lütfen şifrenizi giriniz.',
             'password.min' => 'Şifre 6 karakterden küçük olamaz.',
        ];
        $customer = User::where('id',$id)->update([
            'password' =>bcrypt($request->password),
        ]);
        $message = 'Şifre güncellendi';
        return $this->sendResponse($customer, $message);
    }

    //Profil resmi güncelleme api 
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
    
}
