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
	    
	    if(strpos($message,'ดี') !== false){
		$mass = $this->strpos_arr($ss,'ดี');
	    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
	    $arrayPostData['messages'][0]['type'] = "text";
	    $arrayPostData['messages'][0]['text'] = $mass;
	}
        // // 返信メッセージの格納 (5件まで)
        // $messages = [
        //                 'type' => 'text',
        //                 'text' => $event->message_text,
        //             ];
          #ตัวอย่าง Message Type "Location"
	
    else if(strpos($message, 'เทส') !== false){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0] = $this->Line->gProfile($arrayJson['events'][0]['source']['userId']);

    }

    
        $ss = array("ดี","สวัสดี","ดีจ้า","หวัดดี","Hello","Hi","โย่ว");
        // messagesをリプライで送信
        //$this->Line->replyMsg($arrayHeader,$arrayPostData);
        $mass = $this->strpos_arr($ss,'ดี');
        echo $mass;
    }
    
    function strpos_arr($haystack, $needle) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $what) {
        if(($pos = strpos($haystack, $what))!==false) return $pos;
    }
    return false;
}

}
