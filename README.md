
# 📝 软件使用说明

## 开发原因

初始想法是惩治嘴臭的，摆烂的，令人气氛的键盘侠。

在LOL中明明很认真在玩，但是喷子伺机而动。为了保护家人毅然决然拿起了键盘 .....

## 项目概述


基于 PHP 和 Workerman 开发。其核心功能是自动生成文案，自动将其复制到剪贴板。用户可以选择不同的数据源（本地、AI）来生成文案。

## 期望愿景

对接AI，读取上下文。更智能进行对答。客服回复等.....

---

## 项目文件结构


```
greet_dev/ 
├── app/ 
│ ├── data.json         # 本地内容的数据文件 
│ ├── greetings.php     # 处理问候和逻辑的 PHP 脚本 
│ └── start.php         # 启动 Workerman 服务的入口文件 
├── vendor/ 
├── build.php           # 打包项目生成phar文件代码
├── composer.json
├── composer.lock
├── php.exe
├── php.ini             # php --ini
├── README.md
└── start_for_win.bat   # win启动
```

---

## 核心代码解析

### `greetings.php`

该文件包含了核心的功能逻辑，负责生成文案并将其复制到剪贴板。

### 功能说明：

- **`index` 方法**：调用 `getAiResponse` 生成吐槽文案，并通过 `copyToClipboard` 将文案复制到剪贴板。
- **`getAiResponse` 方法**：通过 AI API 生成吐槽文案。
- **`copyToClipboard` 方法**：通过 `shell_exec` 调用 Windows 系统命令将文案复制到剪贴板。

#### 功能说明：


### `build.php`

`build.php` 是一个打包脚本，利用 PHP 打包工具 `Phar` 生成 `.phar` 文件。

#### 代码示例：

```php
<?php
$phar = new Phar('hello.phar');
$phar->buildFromDirectory('src/');  // 假设源码存放在 src 目录下
$phar->setStub($phar->createDefaultStub('index.php'));
```

#### 功能说明：

- **`Phar`**：创建一个 `.phar` 文件。
- **`buildFromDirectory`**：从指定目录打包文件。
- **`setStub`**：设置 `.phar` 的启动入口，确保启动时能够自动执行。

---

## 测试说明

### 测试方法：

1. **启动测试**：
   - 在app目录 执行 `php start.php`。
   
2. **功能验证**：
   - 检查生成的文案是否正确并已复制到剪贴板。

3. **后台运行**：
   - 检查控制台是否有内容输出。
   
4. **AI 接口测试**：
   - 如果选择 `AI` 数据源，确保能够成功调用 AI API 获取文本，并返回正确的结果。

5. **打包测试**：
   - 在根目录运行 `php build.php` 生成 `.phar` 文件，检查是否能够正确打包并运行。
    
---

## 常见问题及解决方案

1. **问题**：`phar.readonly` 错误  
   **解决方案**：修改 `php.ini` 配置，关闭 `phar.readonly` 设置。

2. **问题**：`php.exe` 无法找到  
   **解决方案**：确保 `php.exe` 路径已正确添加到系统环境变量中，或者使用绝对路径指定。

---

## 结论

通过这个项目，你可以实现一个无需 GUI 的后台助手，自动生成并复制文案，提升效率并增加趣味性。通过打包为 `.phar` 或 `.exe`，你可以轻松部署到其他机器或分享给他人使用。

---
