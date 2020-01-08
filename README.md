# devlog
php 开发日志

# 用composer 下载该日志调试包
#composer require babulin/devlog

# 初始化[内部连接了数据库]
```
  Log::Init();
```
# 数据库[库:devlog][表:logs]
临时在init中配置,根据自己需要修改
# 使用
```
Log::debug("订单日志输出","_order");
Log::info("订单日志输出","_order");
Log::warn("订单日志输出","_order");
Log::error("订单日志输出","_order");
```
