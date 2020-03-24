<?php


// 注册命令
\EasySwoole\EasySwoole\Command\CommandContainer::getInstance()->set(new \App\Command\MysqlDDL());
\EasySwoole\EasySwoole\Command\CommandContainer::getInstance()->set(new \App\Command\UserGenerate());
