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

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

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

    public function gProfile($userid)
    {
        $userss = json_decode(api_profile($userid));
            $userdetail = array (
                              'type' => 'flex',
                              'altText' => 'Flex Message',
                              'contents' => 
                              array (
                                'type' => 'bubble',
                                'hero' => 
                                array (
                                  'type' => 'image',
                                  'url' => $userss->pictureUrl,
                                  'size' => 'full',
                                  'aspectRatio' => '20:13',
                                  'aspectMode' => 'cover',
                                  'action' => 
                                  array (
                                    'type' => 'uri',
                                    'label' => 'Line',
                                    'uri' => $userss->pictureUrl,
                                  ),
                                ),
                                'footer' => 
                                array (
                                  'type' => 'box',
                                  'layout' => 'vertical',
                                  'flex' => 0,
                                  'spacing' => 'sm',
                                  'contents' => 
                                  array (
                                    0 => 
                                    array (
                                      'type' => 'spacer',
                                      'size' => 'sm',
                                    ),
                                    1 => 
                                    array (
                                      'type' => 'text',
                                      'text' => $userss->displayName,
                                      'size' => 'xl',
                                      'align' => 'center',
                                      'gravity' => 'center',
                                      'color' => '#050505',
                                    ),
                                    2 => 
                                    array (
                                      'type' => 'text',
                                      'text' => '!! Welcome !!',
                                      'size' => 'xl',
                                      'align' => 'center',
                                      'gravity' => 'center',
                                      'weight' => 'bold',
                                      'color' => '#1200FF',
                                    ),
                                  ),
                                ),
                              ),
                            );

            return $userdetail;
    }

}
