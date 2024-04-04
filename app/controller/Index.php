<?php

namespace app\controller;

use support\Request;

class Index
{
    /**
     * 提交代码
     */
    public function Index(Request $request)
    {
        $ip = $request->getRealIp(true);
        $header = $request->header();
        $referer = '';
        if (isset($header['referer']) && $header['referer']) {
            $referer = $header['referer'];
        }
        if (isset($header['Referer']) && $header['Referer']) {
            $referer = $header['Referer'];
        }
        $child_path = Base::getChildPpath($referer,  $ip);
        $code = $request->post('code');
        $testin = $request->post('testin');
        $userlanguage = $request->post('language');
        if (!$userlanguage) {
            $userlanguage = '';
        }
        $userlanguage = strtolower($userlanguage);
        if (!isset(Base::$language_map[$userlanguage])) {
            return json([
                'code' => -1,
                'data' => '该语言不支持！请重新选择语言后提交！',
                'memory' => 0,
                'time' => 0
            ]);
        }
        $userlanguage = Base::$language_map[$userlanguage];
        // 代码检测
        $check_safe_json = Base::judgeCodeSafe($code, $userlanguage);
        if (!isset($check_safe_json['code']) || $check_safe_json['code'] != 1) {
            return json($check_safe_json);
        }
        if (!Base::judgeJudgeInstall()) {
            return json([
                'code' => -1,
                'data' => '判题机未安装',
                'memory' => 0,
                'time' => 0
            ]);
        }
        $run_res = Base::getUserCodeRunResult($code, $userlanguage, $testin, $child_path);
        return json($run_res);
    }
}
