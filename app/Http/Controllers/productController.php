<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;   
use App\Models\Product;

class ProductController extends Controller
{
   public function store(Request $request) {
        //memvalidasi inputan
        $validator = Validator::make($request->all(),[
            'product_name' => 'required|max:50',
            'product_type' => 'required|in:snack,drink,fruit,drug,groceries,cigarette,make-up,cigarette',
            'product_price' => 'required|numeric',
            'expired_at'=> 'required|date'
        ]);
        //kondisi apabila inputan yang diinginkan tidak sesuai
        if($validator->fails()){
            //response json akan dikirim jika ada inputan yang salah
            return response() -> json($validator->messages())->setStatusCode(422);

        }

        $payload = $validator->validate();
        //masukkan inputan yang benar ke database (table product)
        Product::create([
            'product_name' => $payload['product_name'],
            'product_type' => $payload['product_type'],
            'product_price' => $payload['product_price'],
            'expired_at' => $payload['expired_at']
        ]);
        //response json akan dikirm jika inputan benar 
        return response()->json([
            'msg'=>'Data produk berhasil disimpan'
        ],201);
    }
    public function update(Request $request,$id) {
        //memvalidasi inputan
        $validator = Validator::make($request->all(),[
            'product_name' => 'required|max:50',
            'product_type' => 'required|in:snack,drink,fruit,drug,groceries,cigarette,make-up,cigarette',
            'product_price' => 'required|numeric',
            'expired_at'=> 'required|date'
        ]);
        //kondisi apabila inputan yang diinginkan tidak sesuai
        if($validator->fails()){
            //response json akan dikirim jika ada inputan yang salah
            return response()->json($validator->messages())->setStatusCode(422);

        }

        $payload = $validator->validated();
        //masukkan inputan yang benar ke database (table product)
        Product::where('id',$id)->update([
            'product_name' => $payload['product_name'],
            'product_type' => $payload['product_type'],
            'product_price' => $payload['product_price'],
            'expired_at' => $payload['expired_at']
        ]);
        //response json akan dikirm jika inputan benar 
        return response()->json([
            'msg'=>'Data produk berhasil diubah'
        ],201);
    }
    public function delete($id){
        $product=Product::where('id',$id)->get();

        if($product){
            Product::where('id',$id)->delete();

            //respon json akan dikirim 
            return response()->json([
                'msg' => 'Data Produk dengan ID: '.$id.' Berhasil Dihapus'
            ],200);
        }

        //response json bila ID tidak ada 
        return response()->json([
            'msg'=>'Data Produk Dengan ID: '.$id.' Tidak Ditemukan'
        ],404);
    }
    function showAll(){

        $products = Product::all();
        return response()->json([
            'msg' => 'Data produk keseluruhan',
            'data' => $products

        ],200);
    }

    function showById($id){
        $product =Product::where('id',$id)->first();

        if($product) {

            return response()->json([
                'msg' => 'Data Produk dengan ID' .$id,
                'data' => $product
            ],200);
        }
        return response()->json([
            'msg' => 'Data produk dengan ID: '.$id.' tidak ditemukan',
        ],404);
    }

    function showByName($product_name){
        $product= Product::where('product_name','LIKE','%'.$product_name.'%')->get();

        if($product->count() > 0) {
            return response()->json([
                'msg' => 'Data produk dengan nama yang mirip: '.$product_name,
                'data' => $product
            ],200);
        }
        return response()->json([
            'msg' => 'Data produk dengan nama yang mirip: '.$product_name.'tidak ditemukan',
        ],404); 
    }
}