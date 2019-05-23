<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Hookd extends CI_Controller {
public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    	$json = file_get_contents('php://input');

		$request = json_decode($json, true);

		echo print_r($request);
    }
}

