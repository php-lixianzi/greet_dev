<?php

use Workerman\Worker;
use Workerman\Lib\Timer;

require_once __DIR__ . '/../vendor/autoload.php';
require 'greetings.php';

// ====== 交互式问用户 ======

// 选择数据源
echo "请选择数据源：\n";
echo "1: 本地\n";
echo "2: AI\n";
echo "请输入选项数字：";
$handle = fopen("php://stdin", "r");
$sourceType = trim(fgets($handle));

// 校验输入
if (!in_array($sourceType, ['1', '2'])) {
    echo "无效的输入，程序退出。\n";
    exit;
}

if ($sourceType == 2){
    echo "请输入AI激活码：";
    $code = trim(fgets($handle));
    if (!is_numeric($code) || $code != 111000) {
        echo "无效的AI激活码，程序退出。\n";
        exit;
    }
}

// 发送间隔时间
echo "请输入发送间隔时间（单位秒，默认3秒）：";
$interval = trim(fgets($handle));
if (!is_numeric($interval) || $interval <= 0) {
    $interval = 3;
}

// 发送次数
echo "请输入发送次数（0表示无限循环，默认0）：";
$maxCount = trim(fgets($handle));
if (!is_numeric($maxCount) || $maxCount < 0) {
    $maxCount = 0;
}
fclose($handle);

// 保存用户输入
$options = [
    'sourceType' => (int)$sourceType,
    'interval'   => (int)$interval,
    'maxCount'   => (int)$maxCount,
];

// 创建 Worker
$worker = new Worker();

// onWorkerStart 中开始执行逻辑
$worker->onWorkerStart = function() use ($options) {
    $greetings = new Greetings($options['sourceType']);
    $count = 0;
    
    Timer::add($options['interval'], function() use ($greetings, &$count, $options) {
        $count++;
        $greetings->index();
        
        // 检查是否达到最大次数
        if ($options['maxCount'] > 0 && $count >= $options['maxCount']) {
            echo "已发送 {$count} 次，任务完成，退出。\n";
            Worker::stopAll();
        }
    });
};

Worker::runAll();
