# LTPP-CODE-RUN

> **LTPP 判题机后端** —— 配合 [主服务 eastspire/LTPP](https://github.com/eastspire/LTPP) 使用的代码沙箱执行与判题组件
>
> 基于 [PHP webman](https://www.workerman.net/doc/webman/) 框架，监听 `8787` 端口，可独立扩缩容。

---

## 📖 项目定位

`LTPP-CODE-RUN` 是 LTPP 生态中的**判题机**，负责在线代码沙箱执行与判题，与主服务解耦：

```
┌─────────────┐     HTTP      ┌──────────────────┐
│  LTPP 主服务 │  ──────────▶  │  LTPP-CODE-RUN   │
│  :47272     │   判题请求    │  :8787           │
└─────────────┘               └──────────────────┘
```

主服务只负责业务逻辑（题目录入、用户、Web 控制台等），把"跑代码 / 判题"这类 CPU 密集 + 安全敏感的工作交给本组件。

部署、启动本组件的方式见 [`eastspire/LTPP`](https://github.com/eastspire/LTPP) 主仓的 `install.sh` —— `--component main+coderun` 或 `--component all` 会一并拉起判题机。

---

## 🛠️ 技术栈

- **语言**：PHP ≥ 7.2
- **Web 框架**：[`workerman/webman-framework ^1.5.0`](https://github.com/walkor/webman)
- **核心依赖**：
  - `monolog/monolog ^2.9.2` —— 日志
  - `illuminate/pagination ^10.46` —— 分页
  - `illuminate/events ^10.46` —— 事件系统
  - `symfony/var-dumper ^7.0` —— 调试输出
  - `webman/console ^1.3` —— webman 命令行
- **打包工具**：`webman/console` 内置的 `build:bin`（基于 [`php-micro`](https://github.com/easysoft/php-micro)），把整个 webman 应用打成单文件二进制

---

## 📦 仓库结构

```
LTPP-CODE-RUN/
├── start.php                # webman 启动入口（开发模式）
├── windows.bat              # Windows 启动脚本
├── windows.php              # Windows 启动包装
├── composer.json            # 依赖声明（name: ltpp/coderun）
├── composer.lock
├── webman                   # webman CLI 入口
├── app/
│   ├── controller/
│   │   ├── Base.php         #   控制器基类（37 KB，含大量判题业务）
│   │   └── Index.php
│   ├── middleware/
│   │   └── CrossDomain.php  #   跨域中间件
│   └── functions.php
├── config/                  # webman 17 个配置文件
│   ├── app.php / autoload.php / bootstrap.php
│   ├── container.php / database.php / dependence.php
│   ├── exception.php / log.php / middleware.php
│   ├── plugin/ / process.php / redis.php / route.php
│   ├── server.php / session.php / static.php
│   ├── translation.php / view.php
├── support/                 # 自定义支持层
│   ├── bootstrap.php
│   ├── helpers.php          #   全局辅助函数
│   ├── LTPPErrorHandler.php #   错误处理
│   ├── Plugin.php           #   composer 插件钩子
│   ├── Request.php / Response.php
├── sh/                      # 运维脚本
│   ├── init.sh              #   初始化（首次部署）
│   ├── bin_build.sh         #   编译单文件二进制（php webman build:bin 8.2）
│   ├── bin_up.sh            #   scp 推到 root@ltpp.vip
│   └── push.sh
├── build/                   # 编译产物（不入版本控制，但提供下载）
│   ├── LTPP-CODE-RUN        #   Linux 单文件二进制（≈ 36 MB）
│   ├── LTPP-CODE-RUN.phar
│   ├── php8.2.micro.sfx
│   └── php8.2.micro.sfx.zip
├── vendor/                  # composer 依赖
├── LICENSE                  # MIT
└── README.md
```

---

## 🚀 快速开始

### 开发模式

```bash
# 需要 PHP >= 7.2 与 composer
composer install
php start.php start       # 默认监听 8787 端口
```

### 生产模式（单文件二进制）

```bash
# 编译（在能跑 PHP 8.2 的主机上）
composer install
php webman build:bin 8.2
# 产物在 build/LTPP-CODE-RUN（≈ 36 MB，自带 PHP 运行时 + webman + 应用代码）

# 部署
./build/LTPP-CODE-RUN start -d          # 后台启动
./build/LTPP-CODE-RUN stop              # 停止
./build/LTPP-CODE-RUN status            # 查看状态
```

### 集成部署（推荐）

直接用 [`eastspire/LTPP`](https://github.com/eastspire/LTPP) 主仓的 `install.sh` 一次性拉起主服务 + 判题机 + SSH 隧道：

```bash
curl -fLO https://raw.githubusercontent.com/eastspire/LTPP/master/install.sh
sudo bash install.sh --component all --yes
```

---

## ⚙️ 配置

主配置文件 `config/server.php` —— 监听端口、进程数、协议等。
主控制器 `app/controller/Base.php` —— 判题请求的业务逻辑入口。

具体配置项与判题 API 的协议，参见文档站 [docs.ltpp.vip/LTPP-CODE-RUN](https://docs.ltpp.vip/LTPP-CODE-RUN)。

---

## 🩺 常见问题

- **`php webman build:bin` 编译失败**：要求 PHP 8.2 + `phar.readonly=0`，参考 [webman 官方文档](https://www.workerman.net/doc/webman/others/bin.html)。
- **8787 端口被占用**：改 `config/server.php` 的 `listen`，并同步主服务侧的反向代理配置。
- **判题任务卡死**：检查 `build/LTPP-CODE-RUN` 是否带 `--with-watchdog` 参数；webman 的 `process/Monitor.php` 已在 support 里。

---

## 🧩 与 LTPP 生态的关系

- 主服务：[`eastspire/LTPP`](https://github.com/eastspire/LTPP) —— 业务核心
- 判题机：**本仓 `LTPP-CODE-RUN`**
- 内网穿透：[`eastspire/LTPP-SSH`](https://github.com/eastspire/LTPP-SSH)
- 桌面客户端：[`eastspire/VUE-EXE`](https://github.com/eastspire/VUE-EXE)（Electron + Tauri 双实现）
- 文档站：[docs.ltpp.vip/LTPP-CODE-RUN](https://docs.ltpp.vip/LTPP-CODE-RUN)

---

## 📜 版权

主程序、配置与文档版权归原作者 [eastspire](https://github.com/eastspire) 所有。许可证见 [LICENSE](./LICENSE)。
