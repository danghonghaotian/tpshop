<?php
namespace TPH\Controller;
use Think\Controller;
class EmptyController extends Controller
{
    public function index()
    {
       $this->redirect('Home/Index/index');
    }
}