<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/2/5
 * Time: 9:33
 */

namespace Admin\Controller;
use Think\Controller;

class PaymentController extends AdminController
{
    public function lst()
    {
        $paymentModel = D('Payment');
        $payment = $paymentModel->getPaymentInfo();
        $this->assign('payment', $payment);
        $this->display();
    }

    /**
     * 显示相应的模板文件
     * @param $pay_code
     */
    public function save($pay_code)
    {
        if(IS_POST)
        {
            $model = D('Payment');
            if($model->create())
            {
                if($model->save() !== FALSE)
                {
                    $this->success('修改成功', U('lst'));
                    exit;
                }
                else
                {
                    if(APP_DEBUG)
                        echo 'SQL为：'.$model->getLastSql();
                    else
                        $this->error('发生失败，请重试！');
                }
            }
            else
                $this->error($model->getError());
        }

        $paymentModel = D('Payment');
        $payment = $paymentModel->where(array('pay_code'=>$pay_code))->find();
        $payment = $paymentModel->getPaymentDetail($payment);
        $this->assign('payment', $payment);
        $this->display($pay_code);
    }

    /**
     * 是否开启功能
     * @param $enabled
     */
    public function enabled($pay_code,$enabled)
    {
        $paymentModel = M('Payment');
        $res = $paymentModel->where(array('pay_code'=>$pay_code))->setField('enabled',$enabled);
        if($res === 1)
        {
            $this->success('更新成功', U('lst'));
        }
        else
        {
            $this->error('发生失败，请重试！');
        }
    }


}