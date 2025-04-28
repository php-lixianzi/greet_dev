<?php
$pharFile = 'hello.phar';

if (file_exists($pharFile)) {
    unlink($pharFile);
}

$phar = new Phar($pharFile);
$phar->buildFromDirectory(__DIR__);
$phar->setDefaultStub('app/start.php');

echo "打包完成！生成：$pharFile\n";
