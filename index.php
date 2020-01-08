<?php
require_once __DIR__ . '/vendor/autoload.php';

use Log\Log;
Log::Init();

//Log::debug("调试信息输出","order");

//print_r(log::getList(1,5));

//debug,info,warning,error

//数据库
//触发时间,日志标签,错误类型,错误信息（描述信息）,文件路径块和代码行号,关键数据