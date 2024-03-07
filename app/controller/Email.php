<?php
/*
 * @Author: 18855190718 1491579574@qq.com
 * @Date: 2023-01-12 12:38:58
 * @LastEditors: wmzn-ltpp 1491579574@qq.com
 * @LastEditTime: 2023-11-12 01:01:51
 * @FilePath: \LTPP-CODE\app\controller\Email.php
 * @Description: Email:1491579574@qq.com
 * QQ:1491579574
 * Copyright (c) 2023 by 18855190718 1491579574@qq.com, All Rights Reserved. 
 */

namespace app\controller;


class Email
{
    /**
     * 邮件发送函数
     * @param string $content 邮件内容
     */
    static public function mailto($content = '')
    {
        $to = 'robot@ltpp.vip';
        $title = Base::$app_name . '运行信息';
        $mail_url = 'https://bt.ltpp.vip/mail_sys/send_mail_http.json';
        $mail_username = 'code@ltpp.vip';
        $mail_password = 'CODE@666666@code';
        if (!$mail_url || !$mail_username) {
            return;
        }
        Base::postRequest($mail_url, ['Content-Type:application/x-www-form-urlencoded'], [
            'mail_from' => $mail_username,
            'password' => $mail_password,
            'mail_to' => $to,
            'subject' => $title,
            'content' => $content,
            'subtype' => 'html'
        ]);
    }
}
