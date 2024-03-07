<?php
/*
 * @Author: 18855190718 1491579574@qq.com
 * @Date: 2023-01-26 16:40:55
 * @LastEditors: wmzn-ltpp 1491579574@qq.com
 * @LastEditTime: 2023-12-30 14:32:53
 * @FilePath: \LTPP-CODE\app\controller\Robot.php
 * @Description: Email:1491579574@qq.com
 * QQ:1491579574
 * Copyright (c) 2023 by 18855190718 1491579574@qq.com, All Rights Reserved. 
 */

namespace app\controller;

class Robot extends Email
{
    /**
     * 发送邮件
     * @param string $msg 消息
     */
    static public function sendEmail($msg = '')
    {
        if (!$msg) {
            return;
        }
        Email::mailto($msg);
    }
};
