<?php

namespace App\Controllers;

class WebSocketController extends BaseController
{
    public function index()
    {
        return view('websocket/chat');
    }

    public function status()
    {
        return $this->response->setJSON(['status'=>'active','server'=>'ws://127.0.0.1:8080','timestamp'=>date('Y-m-d H:i:s')]);
    }
}
