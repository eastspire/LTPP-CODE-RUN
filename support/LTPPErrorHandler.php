<?php

namespace support;

use Throwable;
use Webman\Exception\ExceptionHandler;
use Webman\Http\Request;
use Webman\Http\Response;
use app\controller\Base;
use support\exception\BusinessException;

/**
 * Class Handler
 * @package support\exception
 */
class LTPPErrorHandler extends ExceptionHandler
{
    public $dontReport = [
        BusinessException::class,
    ];

    public function report(Throwable $exception)
    {
    }

    public function render(Request $request, Throwable $exception): Response
    {
        try {
            if (($exception instanceof BusinessException) && ($response = $exception->render($request))) {
                return $response;
            }
            $json = [
                'code' => -1,
                'data' => Base::$server_error_msg,
                'time' => 0,
                'memory' => 0
            ];
            return new Response(
                200,
                ['Content-Type' => 'application/json'],
                json_encode(
                    $json,
                    JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                )
            );
        } catch (Throwable $e) {
        }
        return Base::notFoundPage();
    }
}
