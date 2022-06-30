<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushNotifController extends Controller {
    public function pushNotif(Request $requset) {

        $mData = [
            'title' => $requset->title,
            'body' => $requset->message
        ];

        $fcm[] = "dvDirPDvRA6N02e5QQI_I0:APA91bF8YxeCvcStvZ_ervbeTjsShxWcdDJ2oNKE1TCs7Syxz5xBo_sU4TXVfKLuI173vHi-FrTwCCirS1XAsoIlczM50lPcg99TOuWwa6rJdEli8aD--UcH1CaQeZ0iSAQ1_VXvVJFr";

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
