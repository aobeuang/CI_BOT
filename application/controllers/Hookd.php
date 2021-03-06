<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;

class Hookd extends CI_Controller {

public function __construct()
    {
        parent::__construct();
        $this->load->model('Uline');

    }

    public function index()
    {
    	// เชื่อมต่อกับ LINE Messaging API
		$httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
		$this->Uline->bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
		 
		// คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
		$content = file_get_contents('php://input');
		 
		// แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
		$events = json_decode($content, true);

		
		$replyToken = NULL;
		if(!is_null($events)){
		    // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
		    $replyToken = $events['events'][0]['replyToken'];
		}

		// ส่วนของคำสั่งจัดเตียมรูปแบบข้อความสำหรับส่ง
		$textMessageBuilder = new TextMessageBuilder(json_encode($events));
		 
		$response = $this->Uline->replyEvent($replyToken,$textMessageBuilder);

		echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }


}

