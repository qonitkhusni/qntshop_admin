<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(){
        $transaksiPading['listPanding'] = Transaksi::whereStatus("MENUNGGU")->get();
        $transaksiSelesai['listDone'] = Transaksi::where("Status", "NOT LIKE", "%MENUNGGU%")->get();
        return view('transaksi')->with($transaksiPading)->with($transaksiSelesai);
    }

    public function batal($id){
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->pushNotif('Transaksi Dibatalkan', "Transaksi produk ".$transaksi->details[0]->produk->name."Dibatalkan", $transaksi->user->fcm);
        $transaksi->update([
            'status' => "Batal"
        ]);
        return redirect('transaksi');
    }

    public function confirm($id){
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->pushNotif('Transaksi Diproses', "Transaksi produk ".$transaksi->details[0]->produk->name." Sedang Diproses", $transaksi->user->fcm);
        $transaksi->update([
            'status' => "Proses"
        ]);
        return redirect('transaksi');
    }

    public function kirim($id){
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->pushNotif('Transaksi Dikirim', "Transaksi produk ".$transaksi->details[0]->produk->name."Sedang Dalam Pengiriman", $transaksi->user->fcm);
        $transaksi->update([
            'status' => "Dikirim"
        ]);
        return redirect('transaksi');
    }

    public function selesai($id){
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();

        $this->pushNotif('Transaksi Selesai', "Transaksi produk ".$transaksi->details[0]->produk->name." Sudah Selesai", $transaksi->user->fcm);
        $transaksi->update([
            'status' => "Selesai"
        ]);
        return redirect('transaksi');
    }

    public function pushNotif($title, $message, $mFcm) {

        $mData = [
            'title' => $title,
            'body' => $message
        ];

        $fcm[] = $mFcm;

        $payload = [
            'registration_ids' => $fcm,
            'notification' => $mData
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Content-type: application/json",
                "Authorization: key=AAAAcVw8dPc:APA91bEpZDo165ZcMFEU8lC5kJ5C8KhpQKrGrN9FePVSeEprtoWGYyqM5I1PmVOJEAMc73IlEDZDW_BPPOZOmtp1BCBZYlbEuAXIqogubNBbh2oPxAfEb82wmxPCQ0HsGLB4jxG7mAYB"
            ),
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = [
            'success' => 1,
            'message' => "Push notif success",
            'data' => $mData,
            'firebase_response' => json_decode($response)
        ];
        return $data;
    }
}
