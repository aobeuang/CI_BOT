<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Bot extends CI_Controller {
public function __construct()
    {
        parent::__construct();
        $this->load->model(['Botchan','Line', 'Db_mdl']);
        $this->load->helper('url');
    }

    public function index()
    {
        // LINE Webhookから情報を受け取る
        $raw = file_get_contents('php://input');
        $arrayJson = json_decode($raw, true);
     //    // receiveの一部をオブジェクトに整理
     //    $event = $this->Line->hook_data($receive);
        $message = $arrayJson['events'][0]['message']['text'];
     //    $content = file_get_contents('php://input');
	    // $arrayJson = json_decode($content, true);
	    
	    $arrayHeader = array();
	    $arrayHeader[] = "Content-Type: application/json";
	    $arrayHeader[] = "Authorization: Bearer {".LINE_ACCESS_TOKEN."}";

	    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
	    $arrayPostData['messages'][0]['type'] = "text";
	    $arrayPostData['messages'][0]['text'] = "555";
        // // 返信メッセージの格納 (5件まで)
        // $messages = [
        //                 'type' => 'text',
        //                 'text' => $event->message_text,
        //             ];
          #ตัวอย่าง Message Type "Location"
    if(strpos($message, 'เทส') !== false){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $this->Line->gProfile($arrayJson['events'][0]['source']['userId']);

    }
        
        // messagesをリプライで送信
        $this->Line->replyMsg($arrayHeader,$arrayPostData);
    }

}
