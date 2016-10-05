<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    // 首页展示
    public function index(){
        $this-> display();
    }
}