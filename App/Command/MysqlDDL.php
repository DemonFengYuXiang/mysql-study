<?php

namespace App\Command;

use EasySwoole\EasySwoole\Command\CommandInterface;
use EasySwoole\DDL\Blueprint\Table;

class MysqlDDL implements CommandInterface
{

    public function commandName(): string
    {
        return "mysql_gen";
    }

    public function exec(array $args): ?string
    {
       $sql = \EasySwoole\DDL\DDLBuilder::table('mysql_user', function (Table $table) {
           $table->setTableEngine(\EasySwoole\DDL\Enum\Engine::INNODB);
           $table->setTableCharset(\EasySwoole\DDL\Enum\Character::UTF8MB4_TURKISH_CI);
           $table->colInt('id')->setColumnLimit(11)->setIsNotNull()->setIsAutoIncrement()->setIsPrimaryKey();
           $table->colVarChar('username')->setColumnLimit(200)->setIsNotNull()->setColumnComment('用户名');
           $table->colVarChar('password')->setColumnLimit(255)->setIsNotNull()->setColumnComment('密码');
           $table->colBigInt('phone')->setColumnLimit(11)->setIsNotNull()->setColumnComment('手机号');
           $table->colVarChar('email')->setColumnLimit(100)->setIsNotNull()->setColumnComment('邮箱');
           $table->colVarChar('nickName')->setColumnLimit(100)->setIsNotNull()->setColumnComment('昵称');
           $table->colVarChar('avatar')->setColumnLimit(255)->setIsNotNull()->setColumnComment('头像');
           $table->colInt('updated_at')->setColumnLimit(11)->setIsNotNull()->setColumnComment('更新时间');
           $table->colInt('created_at')->setColumnLimit(11)->setIsNotNull()->setColumnComment('创建时间');
       });

       $f = fopen('my.sql', 'w');
       fwrite($f, $sql);
       fclose($f);

       return "over";
    }

    public function help(array $args): ?string
    {
        return "生成数据库测试所需要的数据库表结构";
    }
}