<?php

$_SERVER["DOCUMENT_ROOT"] = dirname(dirname(__DIR__));

define("LANGUAGE_ID", "s1");
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define("LOG_FILENAME", 'php://stderr');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// Альтернативный способ вывода ошибок типа "DB query error.":
// $GLOBALS["DB"]->debug = true;

// Заменяем вывод фатальных ошибок Битрикса на STDERR - чтобы не было "молчаливого" поведения

class PhpunitFileExceptionHandlerLog extends Bitrix\Main\Diag\FileExceptionHandlerLog {
  public function write(\Exception $exception, $logType)
  {
    $text = Bitrix\Main\Diag\ExceptionHandlerFormatter::format($exception, false, $this->level);
    $msg = date("Y-m-d H:i:s")." - Host: ".$_SERVER["HTTP_HOST"]." - ".static::logTypeToString($logType)." - ".$text."\n";
    fwrite(STDERR, $msg);
  }
}

$handler = new PhpunitFileExceptionHandlerLog;

$bitrixExceptionHandler = \Bitrix\Main\Application::getInstance()->getExceptionHandler();

$reflection = new \ReflectionClass($bitrixExceptionHandler);
$property = $reflection->getProperty('handlerLog');
$property->setAccessible(true);
$property->setValue($bitrixExceptionHandler, $handler);

require('TestCaseBitrix.php');
