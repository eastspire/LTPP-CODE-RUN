<?php

namespace app\controller;

use Exception;

class Language
{
    const c = 'c';
    const cpp = 'cpp';
    const php = 'php';
    const java = 'java';
    const javascript = 'javascript';
    const typescript = 'typescript';
    const ruby = 'ruby';
    const rust = 'rust';
    const python = 'python';
    const golang = 'golang';
    const csharp = 'csharp';
};

class Base
{

    /**
     * 软件名称
     */
    static $app_name = 'LTPP在线开发平台【CODE-RUN服务】';

    /**
     * 代码提交成功提示
     */
    static $code_up_success_msg = '代码提交成功';

    /**
     * 代码提交失败提示
     */
    static $code_up_fail_msg = '代码提交失败！请重新提交！';

    /**
     * 异常超时提示
     */
    static $timout_error_msg = '系统检测到异常代码导致运行超时！请修改代码后重新运行！';

    /**
     * 判题机路径
     */
    static $judgepath = '/JudgeServer/judge';

    /**
     * 编译时间限制（MS）
     */
    static $compiler_timeout_time = 4000;

    /**
     * 运行时间限制（MS）
     */
    static $code_run_limittime = 4000;

    /**
     * 内存限制（KB）
     */
    static $code_run_limitmemory = 1073741824;

    /**
     * 默认请求头
     */
    static $default_http_header = ['Content-Type:application/x-www-form-urlencoded'];

    /**
     * ltpp用户id
     */
    static $ltpp_linux_user_id = 1000;

    /**
     * 文字编码
     */
    static $str_encoding = 'UTF-8,GBK,GB2312,BIG5';

    /**
     * 代码安全信息
     */
    static $code_safe = 'safe';

    /**
     * 判题机安装路径
     */
    static $judge_install_path = '/JudgeServer/';

    /**
     * 判题机名称
     */
    static $judge_name = 'judge';

    /**
     * 服务器异常提示
     */
    static $server_error_msg = '服务器异常';

    /**
     * 404异常访问提示
     */
    static $not_found_msg = '非法访问';

    /**
     * 沙箱地址
     */
    static $sandbox_path = '/home/LTPPSANDBOX/';

    /**
     * 语言转换
     */
    static $language_map = [
        'csharp' => Language::csharp,
        'c#' => Language::csharp,
        'c++' => Language::cpp,
        'cpp' => Language::cpp,
        'java' => Language::java,
        'c' => Language::c,
        'javascript' => Language::javascript,
        'js' => Language::javascript,
        'node' => Language::javascript,
        'typescript' => Language::typescript,
        'ts' => Language::typescript,
        'python' => Language::python,
        'python2' => Language::python,
        'python3' => Language::python,
        'rusthon' => Language::python,
        'rust' => Language::rust,
        'golang' => Language::golang,
        'go' => Language::golang,
        'ruby' => Language::ruby,
        'jruby' => Language::ruby,
        'macruby' => Language::ruby,
        'rake' => Language::ruby,
        'rb' => Language::ruby,
        'rbx' => Language::ruby,
        'inc' => Language::php,
        'php' => Language::php
    ];

    /**
     * 判题机用户代码运行状态码
     */
    static $judge_code_error = -1;

    /**
     * 判题机异常状态码
     */
    static $judge_server_error = 0;

    /**
     * 判题机用户代码正常运行完成状态码
     */
    static $judge_code_finish = 1;

    /**
     * 判题机编译错误状态码
     */
    static $judge_code_compiler_error = 2;

    /**
     * 判题机用户代码运行TLE状态码
     */
    static $judge_code_tle = 3;

    /**
     * 判题机用户代码运行MLE状态码
     */
    static $judge_code_mle = 4;

    /**
     * 判题机用户代码运行RE状态码
     */
    static $judge_code_re = 5;

    /**
     * 代码TLE关键词
     */
    static $code_run_tle = 'TLE';

    /**
     * 代码RE关键词
     */
    static $code_run_re = 'RE';

    /**
     * 代码MLE关键词
     */
    static $code_run_mle = 'MLE';

    /**
     * 代码编译出错关键词
     */
    static $code_run_compiler_wrong = '编译出错';

    /**
     * 代码运行出错关键词
     */
    static $code_run_running_wrong = '运行出错';

    /**
     * 判题机编译异常提示
     */
    static $code_compiler_error = '判题机编译异常';

    /**
     * 判题机运行异常提示
     */
    static $code_run_error = '判题机运行异常';

    /**
     * 测试用例路径
     */
    static $testdata_path = '/tmp/testdata/';

    /**
     * 代码输出内容长度限制
     * @var int $code_out_limit 代码输出内容长度限制
     */
    static $code_out_limit = 100000;

    /**
     * LTPP文件夹绝对路径
     * @var string $LTPP_path LTPP文件夹绝对路径
     */
    static $LTPP_path = '/home/LTPP/';

    /**
     * LTPP_runtime_path
     * @var string $LTPP_runtime_path LTPP_runtime_path
     */
    static $LTPP_runtime_path = '/home/LTPP/LTPPRUNTIME';

    /**
     * LTPP日志文件夹绝对路径
     * @var string $LTPP_logs_path LTPP日志文件夹绝对路径
     */
    static $LTPP_logs_path = '/home/LTPP/LTPPRUNTIME/logs/';

    /**
     * LTPP公开文件夹绝对路径
     * @var string $LTPP_public_path LTPP公开文件夹绝对路径
     */
    static $LTPP_public_path = '/home/LTPP/public';

    /**
     * 返回404页面
     */
    static public function notFoundPage($path = '', $file_extion = '')
    {
        $res = json_encode(
            ['code' => -1, 'data' => Base::$not_found_msg, 'time' => 0, 'memory' => 0],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return response($res, 200, [
            'Content-Type' => 'application/json;charset=utf-8',
            'Accept-Ranges' => 'bytes',
            'Content-Length' => strlen($res),
            'File-Content-Type' => 'application/json;charset=utf-8',
            'File-Path' => $path,
            'File-Extion' => $file_extion,
        ]);
    }

    /**
     * 去除沙箱路径信息
     * @param string $mainfile 可执行文件路径
     * @param string $str 文本
     */
    static public function removeMsgSandboxPath($mainfile = '', $str = '')
    {
        try {
            $tp = Base::utfsubstr(Base::$sandbox_path, 1, strlen(Base::$sandbox_path)) . $mainfile;
            $str = str_replace([$tp, $mainfile], '', $str);
            Base::removeBr($str);
            if (strlen($str) > Base::$code_out_limit) {
                $str = Base::utfsubstr($str, 0, Base::$code_out_limit, true) . "\n" . '【仅显示前' . Base::$code_out_limit . '个字符】';
            }
            return $str;
        } catch (Exception $e) {
        }
        return '';
    }

    /**
     * 运行shell命令
     */
    public static function runExec($command = '', &$out = '', &$run_exec_code = 0)
    {
        try {
            $run_exec_code = 0;
            $pipes = [];
            $descriptorspec = [
                0 => ['pipe', 'r'],  // 标准输入
                1 => ['pipe', 'w'],  // 标准输出
                2 => ['pipe', 'w']   // 标准错误输出
            ];
            $process = proc_open($command, $descriptorspec, $pipes);
            if (is_resource($process)) {
                // 关闭标准输入管道
                fclose($pipes[0]);
                // 读取标准输出和标准错误输出
                $stdout = stream_get_contents($pipes[1]);
                $stderr = stream_get_contents($pipes[2]);
                // 关闭标准输出和标准错误输出管道
                fclose($pipes[1]);
                fclose($pipes[2]);
                // 注册信号处理程序                
                pcntl_signal(SIGTERM, function ($signo) {
                    $pid = getmypid();
                    posix_kill(-$pid, SIGKILL);
                });
                $pid = intval(proc_get_status($process)['pid']);
                // 等待进程终止
                pcntl_waitpid($pid, $run_exec_code);
                // 输出结果或错误信息
                if (!empty($stdout)) {
                    $out = $stdout;
                }
                if (!empty($stderr)) {
                    $out =  $stderr;
                }
                // 取消注册信号处理程序
                pcntl_signal(SIGTERM, SIG_DFL);
                // 关闭进程
                proc_close($process);
            }
        } catch (Exception $e) {
            $out = Base::$server_error_msg;
            $run_exec_code = 0;
        }
    }

    /**
     * 判断路径是否存在（路径以/开头），不存在创建路径中的文件夹
     * @param string $path 路径
     * @param int $grade 权限
     */
    static public function judgeCreatPath($path, $grade = 0666)
    {
        if (file_exists($path)) {
            return true;
        }
        $name = [];
        $length = strlen($path);
        // 获取全部名称
        for ($i = 0; $i < $length; ++$i) {
            if ($path[$i] == '/') {
                $tem = '';
                for ($j = $i + 1; $j < $length; ++$j) {
                    if ($path[$j] == '/') {
                        $i = $j - 1;
                        break;
                    }
                    $tem .= $path[$j];
                    if ($j == $length - 1) {
                        $i = $j;
                        break;
                    }
                }
                if ($tem != '') {
                    $name[] = $tem;
                }
            }
        }
        $now_path = '/';
        foreach ($name as &$tem) {
            $now_path .= $tem . '/';
            $isfile = strripos($now_path, '.');
            if (!file_exists($now_path) && $isfile === false && !is_dir($now_path)) {
                try {
                    @mkdir($now_path, $grade, true);
                } catch (Exception $e) {
                    continue;
                }
            }
        }
        return false;
    }

    /**
     * 安装沙箱环境
     */
    static public function installSandboxEnv()
    {
        $path = Base::$sandbox_path;
        // 清理软连接
        Base::deleteAllFile($path . 'usr/bin/java');
        // 创建沙箱目录
        Base::judgeCreatPath($path);
        // 挂载（C#必须这步）
        $proc_path = $path . 'proc';
        Base::judgeCreatPath($proc_path);
        Base::runExec('umount ' . $proc_path . ' > /dev/null 2>&1');
        Base::runExec('mount -t proc none ' . $proc_path . ' > /dev/null 2>&1');
        // 系统时间
        Base::runExec("cp -p -r --parents -f /etc/timezone $path;cp -p -r --parents -f /etc/localtime $path;");
        // ln安装
        Base::runExec("cp -p -r --parents -f /usr/bin/ln $path");
        // 环境安装
        Base::runExec("cp -p -r --parents -f /usr/share/ $path");
        Base::runExec("cp -p --parents -f /bin/bash $path;cp -p --parents -f /bin/sh $path;cp -p -r --parents -f /usr/lib/mono $path;cp -p --parents -f /usr/bin/mono $path;cp -p --parents -f /usr/bin/gem $path;cp -p --parents -f /usr/bin/gem3.1 $path;cp -p --parents -f /usr/bin/ruby $path;cp -p --parents -f /usr/bin/node $path;cp -p --parents -f /usr/bin/node $path;cp -p --parents -f /usr/bin/php $path;cp -p --parents -f /usr/bin/python3 $path;cp -p -r --parents -f /root/.cargo $path;cp -p --parents -f /usr/bin/mcs $path;cp -p -r --parents -f /usr/local/nodejs $path;cp -p --parents -f /usr/bin/go $path;cp -p --parents -f /usr/bin/g++ $path;cp -p --parents -f /usr/bin/javac $path;cp -p --parents -f /lib64/ld-linux-x86-64.so.2 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libgcc_s.so.1 $path;cp -p --parents -f /lib/x86_64-linux-gnu/librt.so.1 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libpthread.so.0 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libm.so.6 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libdl.so.2 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libm.so.6 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libxml2.so.2 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libssl.so.3 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libcrypto.so.3 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libpcre2-8.so.0 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libz.so.1 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libsodium.so.23 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libargon2.so.1 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libicuuc.so.72 $path;cp -p --parents -f /lib/x86_64-linux-gnu/liblzma.so.5 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libpthread.so.0 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libicudata.so.72 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libstdc++.so.6 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libgcc_s.so.1 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libdl.so.2 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libstdc++.so.6 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libm.so.6 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libgcc_s.so.1 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libpthread.so.0 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libruby-3.1.so.3.1 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libgmp.so.10 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libcrypt.so.1 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libm.so.6 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libm.so.6 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libgcc_s.so.1 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libtinfo.so.6 $path;cp -p --parents -f /lib/x86_64-linux-gnu/libc.so.6 $path;");
        Base::runExec("cp -p -r --parents -f /usr/lib $path;cp -p -r --parents -f /usr/lib32 $path;cp -p -r --parents -f /usr/lib64 $path;cp -p -r --parents -f /etc/python3 $path;cp -p -r --parents -f /usr/lib/python3 $path;cp -p -r --parents -f /usr/lib/jvm/ $path;cp -p --parents -f /usr/lib/x86_64-linux-gnu/libexpat.so.1 $path;cp -p --parents -f /usr/bin/python3 $path;cp -p --parents -f /etc/alternatives/java $path;cp -p -r --parents -f /etc/ssl/certs/java $path;cp -p --parents -f /var/lib/dpkg/alternatives/java $path;cp -p --parents -f /etc/alternatives/javac $path;cp -p --parents -f /usr/bin/javac $path;cp -p --parents -f /var/lib/dpkg/alternatives/javac $path;cp -p --parents -f /etc/alternatives/php $path;cp -p --parents -f /etc/cron.d/php $path;cp -p -r --parents -f /etc/php $path;cp -p -r --parents -f /usr/lib/php $path;cp -p -r --parents -f /usr/include/php $path;cp -p --parents -f /var/lib/dpkg/alternatives/php $path;cp -p -r --parents -f /var/lib/php $path;cp -p --parents -f /usr/bin/mcs $path;cp -p -r --parents -f /usr/lib/x86_64-linux-gnu/ruby $path;cp -p -r --parents -f /usr/lib/ruby $path;cp -p --parents -f /usr/bin/ruby $path;");
        // java安装
        Base::runExec('chroot ' . $path . ' /bin/sh -c "ln -s /usr/lib/jvm/java-17-openjdk-amd64/bin/java /usr/bin/java" > /dev/null 2>&1');
        // 权限设置
        Base::runExec('chmod -R --no-preserve-root 777 ' . $path . ' > /dev/null 2>&1');
        Base::runExec('chown -R --no-preserve-root ltpp:ltpp ' . $path . ' > /dev/null 2>&1');
    }

    /**
     * 文件（夹）删除
     * @param string $dir 文件路径
     * @return bool $res 删除是否成功
     */
    static public function deleteAllFile($dir = '/tmp')
    {
        //其他文件夹不可删除
        if (strripos($dir, Base::$sandbox_path) === false) {
            return false;
        }
        try {
            if (!file_exists($dir)) {
                return false;
            }
            if ($dir == '.' || $dir == '..') {
                return false;
            }
            if (!is_dir($dir)) {
                @unlink("$dir");
                return true;
            }
            $handle = opendir($dir);
            while (($file = readdir($handle)) !== false) {
                if ($file != '.' && $file != '..') {
                    Base::deleteAllFile("$dir/$file");
                }
            }
            closedir($handle);
            @rmdir($dir);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @param string $code
     * @param string $userlanguage
     */
    static public function judgeCodeSafe($code, $userlanguage)
    {
        if (!$code) {
            return ['code' => -1, 'data' => '请编写代码后再次提交哦！', 'memory' => 0, 'time' => 0];
        }
        switch ($userlanguage) {
            case Language::c:
                break;
            case Language::cpp:
                break;
            case Language::java:
                break;
            case Language::python:
                break;
            case Language::golang:
                break;
            case Language::php:
                break;
            case Language::javascript:
                break;
            case Language::rust:
                break;
            case Language::typescript:
                break;
            case Language::csharp:
                break;
            case Language::ruby:
                break;
            default:
                return ['code' => -1, 'data' => '该语言不支持！请重新选择语言后提交！', 'memory' => 0, 'time' => 0];
        }
        return ['code' => 1, 'data' => Base::$code_safe, 'memory' => 0, 'time' => 0];
    }

    /**
     * 判断判题机是否安装
     */
    static public function judgeJudgeInstall()
    {
        $path_judge = Base::$judge_install_path . Base::$judge_name;
        $path_sandbox = Base::$sandbox_path;
        try {
            $has_judge = file_exists($path_judge);
            $has_sandbox = file_exists($path_sandbox);
            if ($has_judge && $has_sandbox) {
                return true;
            }
            Base::deleteAllFile(Base::$judge_install_path);
            Base::judgeCreatPath(Base::$judge_install_path);
            Base::runExec('cp -f /home/LTPP/InstallMust/JudgeServer/judge ' . Base::$judge_install_path . ' 2>&1', $out);
            Base::chmodFile('/JudgeServer', 0555);
            if ($out) {
                return false;
            }
            Base::installSandboxEnv();
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * 修改权限
     * @param string $path
     * @param int $num
     */
    static public function chmodFile($path, $num = 0444)
    {
        try {
            if (!file_exists($path)) {
                return;
            }
            if ($path == '.' || $path == '..') {
                return;
            }
            if (!is_dir($path)) {
                chmod($path, $num);
                return;
            }
            $dirs = scandir($path);
            foreach ($dirs as &$tem) {
                if ($tem == '.' || $tem == '..') {
                    continue;
                }
                $tempath = $path . '/' . $tem;
                Base::chmodFile($tempath, $num);
            }
        } catch (Exception $e) {
            return;
        }
    }

    /**
     * 修改所有者
     * @param string $path
     * @param int $num
     */
    static public function chownFile($path, $user_id)
    {
        try {
            if (!file_exists($path)) {
                return;
            }
            if ($path == '.' || $path == '..') {
                return;
            }
            if (!is_dir($path)) {
                chown($path, $user_id);
                return;
            }
            $dirs = scandir($path);
            foreach ($dirs as &$tem) {
                if ($tem == '.' || $tem == '..') {
                    continue;
                }
                $tempath = $path . '/' . $tem;
                Base::chownFile($tempath, $user_id);
            }
        } catch (Exception $e) {
            return;
        }
    }

    /**
     * 获取getChildPpath
     * @param string $referer
     * @param string $ip
     */
    static public function getChildPpath($referer = '', $ip = '')
    {
        return md5($referer . $ip);
    }

    /**
     * 写入文件
     * @param string $file 文件路径
     * @param string $content 写入的内容
     */
    static public function writeToFile($file, $content = '')
    {
        Base::judgeCreatPath($file);
        while (1) {
            try {
                $result = file_put_contents($file, $content);
                if ($result !== false) {
                    // 写入成功
                    return;
                }
            } catch (Exception $e) {
                continue;
            }
        }
    }

    /**
     * 代码写入文件
     * @param string $userlanguage
     * @param string $code
     * @param string $filepath
     * @param string $runcodefilepath
     * @return array $res
     */
    static public function writeCodeToFile($userlanguage, $code, $filepath, $runcodefilepath)
    {
        try {
            //编译
            switch ($userlanguage) {
                case Language::rust:
                    Base::writeToFile($runcodefilepath . '.rs', $code);
                    break;
                case Language::c:
                    Base::writeToFile($runcodefilepath . '.c', $code);
                    break;
                case Language::cpp:
                    Base::writeToFile($runcodefilepath . '.cpp', $code);
                    break;
                case Language::golang:
                    Base::writeToFile($runcodefilepath . '.go', $code);
                    break;
                case Language::java:
                    $runcodefilepath = $filepath . 'Main';
                    Base::writeToFile($runcodefilepath . '.java', $code);
                    break;
                case Language::javascript:
                    Base::writeToFile($runcodefilepath . '.js', $code);
                    break;
                case Language::typescript:
                    Base::writeToFile($runcodefilepath . '.ts', $code);
                    break;
                case Language::php:
                    Base::writeToFile($runcodefilepath . '.php', $code);
                    break;
                case Language::python:
                    Base::writeToFile($runcodefilepath . '.py', $code);
                    break;
                case Language::ruby:
                    Base::writeToFile($runcodefilepath . '.rb', $code);
                    break;
                case Language::csharp:
                    Base::writeToFile($runcodefilepath . '.cs', $code);
                    break;
                default:
                    return [
                        'code' => -1,
                        'result' => '请选择语言后提交！',
                        'usememory' => 0,
                        'usetime' => 0
                    ];
            }
        } catch (Exception $e) {
            return [
                'code' => -1,
                'data' => Base::$server_error_msg,
                'memory' => 0,
                'time' => 0
            ];
        }
        return [
            'code' => 1,
            'data' => '',
            'memory' => 0,
            'time' => 0
        ];
    }

    /**
     * 运行
     * @param string $userlanguage
     * @param string $filepath
     * @param string $inpath
     * @param string $outpath
     * @param string $errpath
     * @param string $runcodefilepath
     * @param int $compiler_timeout_time
     * @param int $limittime
     * @param int limitmemory
     */
    static public function run($userlanguage, $filepath, $inpath, $outpath, $errpath, $runcodefilepath, $compiler_timeout_time, $limittime, $limitmemory)
    {
        $out = '';
        $compiler_cmd = '""';
        $run_cmd = '';
        try {
            // 运行
            switch ($userlanguage) {
                case Language::rust:
                    $compiler_cmd = '/root/.cargo/bin/rustc@-O@-o@' . $runcodefilepath . '@' . $runcodefilepath . '.rs';
                    $run_cmd = $runcodefilepath;
                    Base::runExec(Base::$judgepath . ' ' . $compiler_cmd . ' ' . $run_cmd  . ' ' . $compiler_timeout_time . ' ' . $limittime . ' ' . $limitmemory . ' ' . $inpath . ' ' . $outpath . ' ' . $errpath, $out);
                case Language::c:
                    $compiler_cmd = '/usr/bin/g++@-o@' . $runcodefilepath . '@' . $runcodefilepath . '.c@-std=c++2a';
                    $run_cmd =  $runcodefilepath;
                    Base::runExec(Base::$judgepath . ' ' . $compiler_cmd . ' ' . $run_cmd  . ' ' . $compiler_timeout_time . ' ' . $limittime . ' ' . $limitmemory . ' ' . $inpath . ' ' . $outpath . ' ' . $errpath, $out);
                    break;
                case Language::cpp:
                    $compiler_cmd = '/usr/bin/g++@-o@' . $runcodefilepath . '@' . $runcodefilepath . '.cpp@-std=c++2a';
                    $run_cmd =  $runcodefilepath;
                    Base::runExec(Base::$judgepath . ' ' . $compiler_cmd . ' ' . $run_cmd . ' ' . $compiler_timeout_time . ' ' . $limittime . ' ' . $limitmemory . ' ' . $inpath . ' ' . $outpath . ' ' . $errpath, $out);
                    break;
                case Language::golang:
                    Base::runExec('/usr/bin/go env -w GO111MODULE=auto');
                    $compiler_cmd = '/usr/bin/go@build@-o@' . $filepath . '@' . $runcodefilepath . '.go';
                    $run_cmd =  $runcodefilepath;
                    Base::runExec(Base::$judgepath . ' ' . $compiler_cmd . ' ' . $run_cmd  . ' ' . $compiler_timeout_time . ' ' . $limittime . ' ' . $limitmemory . ' ' . $inpath . ' ' . $outpath . ' ' . $errpath, $out);
                    break;
                case Language::java:
                    $limittime <<= 1;
                    $limitmemory <<= 1;
                    $compiler_cmd = '/usr/bin/javac@-J-Dfile.encoding=UTF-8@' . $runcodefilepath . '.java';
                    $run_cmd = '/usr/bin/java@-cp@' . $filepath . '@Main';
                    Base::runExec(Base::$judgepath . ' ' . $compiler_cmd . ' ' . $run_cmd . ' ' . $compiler_timeout_time . ' ' . $limittime . ' ' . $limitmemory . ' ' . $inpath . ' ' . $outpath . ' ' . $errpath, $out);
                    break;
                case Language::javascript:
                    $limittime <<= 1;
                    $limitmemory <<= 1;
                    $compiler_cmd = '""';
                    $run_cmd = '/usr/bin/node@' . $runcodefilepath . '.js';
                    Base::runExec(Base::$judgepath . ' ' . $compiler_cmd . ' ' . $run_cmd . ' ' . $compiler_timeout_time . ' ' . $limittime . ' ' . $limitmemory . ' ' . $inpath . ' ' . $outpath . ' ' . $errpath, $out);
                    break;
                case Language::typescript:
                    $limittime <<= 1;
                    $limitmemory <<= 1;
                    $compiler_cmd = '/usr/local/nodejs/bin/tsc@-t@es2022@--outFile@' . $runcodefilepath . '.js' . $runcodefilepath . '.ts';
                    $run_cmd =  '/usr/bin/node@' . $runcodefilepath . '.js';
                    Base::runExec(Base::$judgepath . ' ' . $compiler_cmd . ' ' . $run_cmd . ' ' . $compiler_timeout_time . ' ' . $limittime . ' ' . $limitmemory . ' ' . $inpath . ' ' . $outpath . ' ' . $errpath, $out);
                    break;
                case Language::php:
                    $limittime <<= 1;
                    $limitmemory <<= 1;
                    $compiler_cmd = '""';
                    $run_cmd = '/usr/bin/php@' . $runcodefilepath . '.php';
                    Base::runExec(Base::$judgepath . ' ' . $compiler_cmd . ' ' . $run_cmd . ' ' . $compiler_timeout_time . ' ' . $limittime . ' ' . $limitmemory . ' ' . $inpath . ' ' . $outpath . ' ' . $errpath, $out);
                    break;
                case Language::python:
                    $limittime <<= 1;
                    $limitmemory <<= 1;
                    $compiler_cmd = '""';
                    $run_cmd = '/usr/bin/python3@' . $runcodefilepath . '.py';
                    Base::runExec(Base::$judgepath . ' ' . $compiler_cmd . ' ' . $run_cmd . ' ' . $compiler_timeout_time . ' ' . $limittime . ' ' . $limitmemory . ' ' . $inpath . ' ' . $outpath . ' ' . $errpath, $out);
                    break;
                case Language::ruby:
                    $limittime <<= 1;
                    $limitmemory <<= 1;
                    $compiler_cmd = '""';
                    $run_cmd = '/usr/bin/ruby@' . $runcodefilepath . '.rb';
                    Base::runExec(Base::$judgepath . ' ' . $compiler_cmd . ' ' . $run_cmd . ' ' . $compiler_timeout_time . ' ' . $limittime . ' ' . $limitmemory . ' ' . $inpath . ' ' . $outpath . ' ' . $errpath, $out);
                    break;
                case Language::csharp:
                    $limittime <<= 1;
                    $limitmemory <<= 1;
                    $compiler_cmd = '/usr/bin/mcs@-out:' . $runcodefilepath . ' ' . $runcodefilepath . '.cs';
                    $run_cmd = '/usr/bin/mono@' . $runcodefilepath;
                    Base::runExec(Base::$judgepath . ' ' . $compiler_cmd . ' ' . $run_cmd . ' ' . $compiler_timeout_time . ' ' . $limittime . ' ' . $limitmemory . ' ' . $inpath . ' ' . $outpath . ' ' . $errpath, $out);
                default:
                    break;
            }
        } catch (Exception $e) {
            return [
                json_encode([
                    'status' => Base::$judge_server_error,
                    'time_used' => 0,
                    'memory_used' => 0,
                    'msg' => Base::$server_error_msg
                ])
            ];
        }
        return $out;
    }

    /**
     * 用户代码状态，消耗的时间和内存
     * @param string $str
     * @return array $res
     */
    static public function getCodeTimeMemory(&$str)
    {
        $status = 0;
        $time_used = 0;
        $memory_used = 0;
        $msg = '';
        try {
            $res = json_decode($str, true);
            if (!isset($res['status']) || !$res['status']) {
                $res['status'] = 0;
            }
            if (!isset($res['time_used']) || !$res['time_used']) {
                $res['time_used'] = 0;
            }
            if (!isset($res['memory_used']) || !$res['memory_used']) {
                $res['memory_used'] = 0;
            }
            if (!isset($res['msg']) || !$res['msg']) {
                $res['msg'] = '';
            }
            $status = (int) $res['status'];
            $time_used = (int) $res['time_used'];
            $memory_used = (int) $res['memory_used'];
            $msg = $res['msg'];
        } catch (Exception $e) {
            // 触发错误的情况是判题机输出 Segmentation fault (core dumped) 导致解析json失败 而判题机触发该错误是不断分配内存不回收触发安全机制导致程序崩溃
            // 由于具体分配内存大小不确定，所以按照 RE 处理
            return [
                'status' => 4,
                'time_used' => $time_used,
                'memory_used' => $memory_used,
                'msg' => $msg
            ];
        }
        return [
            'status' => $status,
            'time_used' => $time_used,
            'memory_used' => $memory_used,
            'msg' => $msg
        ];
    }

    /**
     * 中文字符串截取
     * @param string [$str] 字符串
     * @param int [$index] 起始下标
     * @param int [$getlen] 获取的字符串长度
     * @return string $res 截取后的字符串 
     * @param bool $is_has_br 是否保留换行符（默认false）
     * @return string res
     */
    static public function utfsubstr(string $str = '', $index = 0, $getlen = 0, $is_has_br = false)
    {
        try {
            if (!$str) {
                return '';
            }
            mb_internal_encoding('UTF-8');
            $len = min(mb_strlen($str), $getlen);
            $s = mb_substr($str, $index, $len);
            if (!$is_has_br) {
                // 去除所有换行符
                $s = str_replace(["\r", "\n"], '', $s);
            }
            return $s;
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * 去除开头若干换行
     * @param string $str
     */
    static public function removeBr(&$str)
    {
        try {
            $len = strlen($str);
            $res = '';
            for ($i = 0; $i < $len; ++$i) {
                if ($str[$i] == "\n" && $res == '') {
                    continue;
                }
                $res .= $str[$i];
            }
            $str = $res;
        } catch (Exception $e) {
        }
    }

    /**
     * 代码运行创建目录和代码
     * @param string $user_path
     * @param string $testin 
     */
    static public function creatCodeRunDirFile($user_path = '', $testin = '')
    {
        // 子目录名称
        $mainfile = '';
        // 完整路径
        $filepath = '';
        // 可执行文件完整路径
        $runcodefilepath = '';
        // 输入文件完整路径
        $inpath = '';
        // 输出文件完整路径
        $outpath = '';
        // 错误文件完整路径
        $errpath = '';
        try {
            //代码存放路径
            do {
                $mainfile = $user_path . uniqid() . mt_rand(1, 100000) . time() . '/';
                $filepath = Base::$sandbox_path .  $mainfile;
            } while (file_exists($filepath));
            if (!file_exists($filepath)) {
                Base::judgeCreatPath($filepath, 0777);
            }
            // 可执行文件不能提前生成或写入
            // 如果提前生成或写入会导致编译器生成可执行文件失败
            $runcodefilepath = $filepath . 'main';
            // 输入文件
            $inpath = $runcodefilepath . '.in';
            Base::writeToFile($inpath, $testin);
            // 输出文件
            $outpath = $runcodefilepath . '.out';
            Base::writeToFile($outpath, '');
            // 错误文件
            $errpath = $runcodefilepath . '.err';
            Base::writeToFile($errpath, '');
        } catch (Exception $e) {
        }
        return [
            'mainfile' => $mainfile,
            'filepath' => $filepath,
            'runcodefilepath' => $runcodefilepath,
            'inpath' => $inpath,
            'outpath' => $outpath,
            'errpath' => $errpath,
        ];
    }

    /**
     * 获取用户代码运行结果
     * @param string $code
     * @param string $userlanguage
     * @param string $testin
     * @param string $child_path
     * @return array $json
     */
    static public function getUserCodeRunResult($code = '', $userlanguage = Language::cpp, $testin = '', $child_path = '')
    {
        // 用户文件夹
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
        $out = Base::run(
            $userlanguage,
            $filepath,
            $inpath,
            $outpath,
            $errpath,
            $runcodefilepath,
            Base::$compiler_timeout_time,
            Base::$code_run_limittime,
            Base::$code_run_limitmemory
        );

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
};
