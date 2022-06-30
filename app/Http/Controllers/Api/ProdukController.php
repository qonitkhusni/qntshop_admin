<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Produk;

class ProdukController extends Controller
{
    public function index(){
        // dd($requset->all());die();
        $produk = Produk::all();
        return response()->json([
            'success' => 1,
            'message' => 'Get Produk Berhasil',
            'produks' => $produk
        ]);
    }

    public function delete(Request $requset){
        $product = Produk::where('id', $requset->id)->first();
        if ($product) {
            $product->delete();
            return response()->json([
                'success' => 1,
                'message' => 'Produk Berhasil Dihapus'
            ]);            
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Produk Tidak di Temukan'
            ]);
        }
    }

    public function update(Request $requset){
        $product = Produk::where('id', $requset->id)->first();
        if ($product) {
            $product->update($requset->all());
            return response()->json([
                'success' => 1,
                'message' => 'Produk Berhasil Diedit',
                'data' => $requset->all()
            ]);            
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Produk Tidak di Temukan'
            ]);
        }
    }
}
