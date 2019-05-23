<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Line extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Db_mdl']);
    }
    const LINE_ACCESS_TOKEN = '{LINE_ACCESS_TOKEN}';
    public function replyMsg($arrayHeader,$arrayPostData){
        $strUrl = "https://api.line.me/v2/bot/message/reply";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
    }
    public function api_profile($id)
    {
        // ユーザ情報を取得
        $url = 'https://api.line.me/v2/bot/profile/' . $id;

        // リクエストを生成
        $headers = ['Content-Type: application/json',
            'Authorization: Bearer ' . LINE_ACCESS_TOKEN];

        // curlのオプション
        $options = [CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers];
        // curlセッションの実行
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;

    }
    public function api_content($id)
    {
        $url = 'https://api.line.me/v2/bot/message/' . $id . '/content';

        // リクエストを生成
        $headers = ['Content-Type: application/json',
            'Authorization: Bearer ' . LINE_ACCESS_TOKEN];

        // curlのオプション
        $options = [CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers];
        // curlセッションの実行
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;

    }

    public function hook_data($json)
    {
        // 受け取ったeventsからよく使う値を格納する
        $event = $json['events'][0];
        return (object) [
            'all' => $event,
            'reply_token' => $event['replyToken'],
            'message_text' => $event['message']['text'],
            'userid' => $event['source']['userId'],
            'id' => $event['message']['id'],
        ];

    }

}
