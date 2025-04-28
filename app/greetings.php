<?php

class Greetings
{
    protected $sourceType;
    
    public function __construct($sourceType)
    {
        $this->sourceType = $sourceType;
    }
    
    public function index()
    {
        $text = '';
        
        switch ($this->sourceType) {
            case 1:
                $text = $this->getLocalText();
                break;
            case 2:
                $text = $this->getAiResponse();
                break;
            default:
                $text = "未知数据源";
        }
        
        $this->copyToClipboard($text);
    }
    
    // 本地自定义文案
    protected function getLocalText()
    {
        // 判断是否在 PHAR 包内运行
        if (Phar::running()) {
            $pharPath = Phar::running();
            $realFilePath = substr($pharPath, 7);
            $dirPath = dirname($realFilePath);
            $filePath = $dirPath . DIRECTORY_SEPARATOR . 'data.json';
        } else {
            // 如果不是在 PHAR 包内，直接使用当前目录的 data.json
            $filePath = __DIR__ . '/data.json';
        }
    
        // 检查文件是否存在
        if (!file_exists($filePath)) {
            echo "无法读取数据文件。\n";
            return "无法加载吐槽内容";
        }
        
        $jsonContent = file_get_contents($filePath);
        $texts = json_decode($jsonContent, true);
        
        if (!is_array($texts)) {
            echo "数据格式错误。\n";
            return "格式错误";
        }
        
        return $texts[array_rand($texts)];
    }
    
    // AI文案
    protected function getAiResponse()
    {
        return "AI吐槽 - 时间：" . date('Y-m-d H:i:s', time());
        //调用 AI API
    }
    
    // 复制到剪贴板（Windows）
    protected function copyToClipboard($text)
    {
        $text = str_replace('"', '\"', $text);
        shell_exec("echo \"$text\" | clip");
        echo "复制到剪贴板: $text\n";
    }
}
