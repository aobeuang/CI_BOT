<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Uline extends CI_Model
{


	public function __construct()
    {
        parent::__construct();

    }

    public function mano($bot,$replyToken,$textMessageBuilder)
    {
    	//l ส่วนของคำสั่งตอบกลับข้อความ
		$response = $bot->replyMessage($replyToken,$textMessageBuilder);
		if ($response->isSucceeded()) {
		    echo 'Succeeded!';
		    return;
		}

		return $response;

    }
}
