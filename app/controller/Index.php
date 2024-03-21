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

        //编译
        $compiler_res_json = Base::compiler($userlanguage, $code, $filepath, $runcodefilepath, Base::$code_run_limittime);

        if (!isset($compiler_res_json['code']) || $compiler_res_json['code'] != 1) {
            Base::deleteAllFile($filepath);
            return $compiler_res_json;
        }

        $out = $compiler_res_json['data'];
        if (!empty($out)) {
            Base::deleteAllFile($filepath);
            $code = $code . "\n\n\n报错详情：\n";
            $res_data = Base::$code_run_compiler_wrong . "！\n";
            $err_data = '';
            // 去除路径信息
            foreach ($out as &$tem) {
                $err_data .= $tem . "\n";
            }
            $tp = Base::utfsubstr(Base::$sandbox_path, 1, strlen(Base::$sandbox_path)) . $mainfile;
            $err_data = str_replace([$tp, $mainfile], '', $err_data);
            Base::removeBr($err_data);
            $code .= $err_data;
            $res_data .= $err_data;
            if (strlen($res_data) > Base::$code_out_limit) {
                $res_data = Base::utfsubstr($res_data, 0, Base::$code_out_limit, true) . "\n" . '【仅显示前' . Base::$code_out_limit . '个字符】';
            }
            return ['code' => -1, 'data' => $res_data, 'memory' => 0, 'time' => 0];
        }

        $out = [];

        //运行
        $out = Base::run($userlanguage, $filepath, $inpath, $outpath, $errpath, $runcodefilepath, Base::$code_run_limittime, Base::$code_run_limitmemory);

        if (!$out || empty($out)) {
            Base::deleteAllFile($filepath);
            return ['code' => -1, 'data' => Base::$code_run_error . '！', 'memory' => 0, 'time' => 0];
        }
        $out = $out[0];
        $run_resource_consumption = Base::getCodeTimeMemory($out);
        if (!$run_resource_consumption || !isset($run_resource_consumption['status'])) {
            Base::deleteAllFile($filepath);
            return ['code' => -1, 'data' => Base::$code_run_error . '！', 'memory' => 0, 'time' => 0];
        }

        $status = $run_resource_consumption['status'] ?? 0;
        $time_used = $run_resource_consumption['time_used'] ?? 0;
        $memory_used = $run_resource_consumption['memory_used'] ?? 0;

        if ($status == Base::$judge_server_error) {
            Base::deleteAllFile($filepath);
            $msg = $run_resource_consumption['msg'];
            if (strlen($msg) > Base::$code_out_limit) {
                $resout = Base::utfsubstr($msg, 0, Base::$code_out_limit, true) . "\n" . '【仅显示前' . Base::$code_out_limit . '个字符】';
            }
            return ['code' => -1, 'data' => Base::$code_run_error . "！\n" . $msg, 'memory' => 0, 'time' => 0];
        }

        if ($status == Base::$judge_code_error) {
            $code .= "\n\n\n报错详情：\n";
            $err_data = Base::$code_run_running_wrong . "！\n";
            //读取输出
            $resout = Base::getFileText($errpath);
            Base::deleteAllFile($filepath);
            // 去除路径信息
            $tp = Base::utfsubstr(Base::$sandbox_path, 1, strlen(Base::$sandbox_path)) . $mainfile;
            $resout = str_replace([$tp, $mainfile], '', $resout);
            Base::removeBr($resout);

            if (strlen($resout) > Base::$code_out_limit) {
                $resout = Base::utfsubstr($resout, 0, Base::$code_out_limit, true) . "\n" . '【仅显示前' . Base::$code_out_limit . '个字符】';
            }
            $code .= $resout . "\n";
            $err_data .= $resout;
            return [
                'code' => -1,
                'data' => $err_data,
                'time' => $time_used,
                'memory' => $memory_used
            ];
        }

        //读取输出
        $resout = Base::getFileText($outpath);
        // 去除路径信息
        $tp = Base::utfsubstr(Base::$sandbox_path, 1, strlen(Base::$sandbox_path)) . $mainfile;
        $resout = str_replace([$tp, $mainfile], '', $resout);
        Base::removeBr($resout);

        if (strlen($resout) > Base::$code_out_limit) {
            $resout = Base::utfsubstr($resout, 0, Base::$code_out_limit, true) . "\n" . '【仅显示前' . Base::$code_out_limit . '个字符】';
        }
        switch ($status) {
            case Base::$judge_code_tle:
                Base::deleteAllFile($filepath);
                return ['code' => -1, 'data' => Base::$code_run_tle . '！请更改代码后再次尝试哦！' . ($resout ? "\n" . $resout : ''), 'time' => $time_used, 'memory' => $memory_used];
            case Base::$judge_code_mle:
                Base::deleteAllFile($filepath);
                return ['code' => -1, 'data' =>  Base::$code_run_mle . '！请更改代码后再次尝试哦！' . ($resout ? "\n" . $resout : ''), 'time' => $time_used, 'memory' => $memory_used];
            case Base::$judge_code_re:
                Base::deleteAllFile($filepath);
                return ['code' => -1, 'data' =>  Base::$code_run_re . '！请更改代码后再次尝试哦！' . ($resout ? "\n" . $resout : ''), 'time' => $time_used, 'memory' => $memory_used];
            default:
                break;
        }
        Base::deleteAllFile($filepath);
        return ['code' => 1, 'data' => $resout, 'time' => $time_used, 'memory' => $memory_used];
    }
}
