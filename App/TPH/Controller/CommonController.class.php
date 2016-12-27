<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/27
 * Time: 20:51
 */
namespace TPH\Controller;
use Think\Controller;

class CommonController extends Controller{

    public function __construct()
    {
        if(session('?test'))
        {
            return parent::__construct();
        }

        if($_GET['pwd'] != '123')
        {
            echo '403 forbidden access';
            die;
        }

        if($_GET['pwd'] == '123')
        {
            session('test','test');
            return parent::__construct();
        }
    }
}

?>