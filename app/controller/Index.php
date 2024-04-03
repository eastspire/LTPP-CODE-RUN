<?php

namespace app\controller;

use support\Request;

class Index
{
    /**
     * 代码运行
     * @param string $code
     * @param string $userlanguage
     * @param string $testin
     * @param string $child_path
     * @return array $json
     */
    static private function run($code = '', $userlanguage = Language::cpp, $testin = '', $child_path = '')
    {
        //用户文件夹
        $dir_res = Base::creatCodeRunDirFile($child_path, $testin);
        $mainfile = $dir_res['mainfile'];
        $filepath = $dir_res['filepath'];
        $runcodefilepath = $dir_res['runcodefilepath'];
        $inpath = $dir_res['inpath'];
        $outpath = $dir_res['outpath'];
        $errpath = $dir_res['errpath'];

        // 代码写入文件
        $compiler_res_json = Base::writeCodeToFile($userlanguage, $code, $filepath, $runcodefilepath);

        if (!isset($compiler_res_json['code']) || $compiler_res_json['code'] != 1) {
            Base::deleteAllFile($filepath);
            return $compiler_res_json;
        }

        $out = '';

        //运行
        $out = Base::run($userlanguage, $filepath, $inpath, $outpath, $errpath, $runcodefilepath, Base::$compiler_timeout_time, Base::$code_run_limittime, Base::$code_run_limitmemory);

        Base::deleteAllFile($filepath);

        $run_resource_consumption = Base::getCodeTimeMemory($out);

        if (!$run_resource_consumption || !isset($run_resource_consumption['status'])) {
            return ['code' => -1, 'data' => Base::$code_run_error . '！', 'memory' => 0, 'time' => 0];
        }

        $status = $run_resource_consumption['status'] ?? 0;
        $time_used = $run_resource_consumption['time_used'] ?? 0;
        $memory_used = $run_resource_consumption['memory_used'] ?? 0;
        $msg = $run_resource_consumption['msg'] ?? '';

        // 去除路径信息
        $msg = Base::removeMsgSandboxPath($mainfile, $msg);

        if ($status == Base::$judge_code_finish) {
            return ['code' => 1, 'data' => $msg, 'time' => $time_used, 'memory' => $memory_used];
        }
        return [
            'code' => -1,
            'data' =>  $msg,
            'time' => $time_used,
            'memory' => $memory_used
        ];
    }

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
            return json(['code' => -1, 'data' => '该语言不支持！请重新选择语言后提交！', 'memory' => 0, 'time' => 0]);
        }
        $userlanguage = Base::$language_map[$userlanguage];
        //代码检测
        $check_safe_json = Base::judgeCodeSafe($code, $userlanguage);
        if (!isset($check_safe_json['code']) || $check_safe_json['code'] != 1) {
            return json($check_safe_json);
        }
        if (!Base::judgeJudgeInstall()) {
            return json(['code' => -1, 'data' => '判题机未安装', 'memory' => 0, 'time' => 0]);
        }
        $run_res =  $this->run($code, $userlanguage, $testin, $child_path);
        return json($run_res);
    }
}
