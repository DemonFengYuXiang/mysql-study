<?php


namespace App\Command;


use EasySwoole\EasySwoole\Command\CommandInterface;
use EasySwoole\Mysqli\Client;
use EasySwoole\Mysqli\Config;

class UserGenerate implements CommandInterface
{

    public function commandName(): string
    {
        return "user_gen";
    }

    public function exec(array $args): ?string
    {
        $config = new Config([
            'host'          => '119.29.133.254',
            'port'          => 3306,
            'user'          => 'root',
            'password'      => 'fengyuxiang',
            'database'      => 'study',
            'timeout'       => 5,
            'charset'       => 'utf8mb4',
        ]);
        $client = new Client($config);
        go(function () use ($client) {
             $builder = $client->queryBuilder();
            $alphaStr ='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $alphaStrLen = strlen($alphaStr) - 1;

            $numStr = '123456789';
            $numStrLen = strlen($numStr) - 1;
            $fp = fopen("statistical.txt", 'a+');

            $count = 0;
            $insertArr = [];
            $accumulative_total = 0;
            for ($index = 1; $index <= 10000000; ++$index) {
                $username = '';
                for ($j = 0; $j < 8; ++$j) {
                    $randInt = mt_rand(0, $alphaStrLen);
                    $tempAlpha = $alphaStr[$randInt];
                    $username .= $tempAlpha;
                }

                $phone = '';
                for ($k = 0; $k < 11; ++$k) {
                    $randNumInt = mt_rand(0, $numStrLen);
                    $tempNum = $numStr[$randNumInt];
                    $phone .= $tempNum;
                }
                $phone = (int)$phone;

                $password = '';
                for ($f = 0; $f < 5; ++$f) {
                    $rand = mt_rand(0, $numStrLen);
                    $tempNum = $numStr[$rand];
                    $password .= $tempNum;
                }
                $password = md5($password);

                $email = '';
                for ($q = 0; $q < 8; ++$q) {
                    $rand = mt_rand(0, $alphaStrLen);
                    $tempAlpha = $alphaStr[$rand];
                    $email .= $tempAlpha;
                }
                $email = $email.'@qq.com';

                $nickName = '';
                for ($u = 0; $u < 4; ++$u) {
                    $rand = mt_rand(0, $alphaStrLen);
                    $tempAlpha = $alphaStr[$rand];
                    $nickName .= $tempAlpha;
                }

                $avatar = '';
                for ($y = 0; $y < 20; ++$y) {
                    $rand = mt_rand(0, $alphaStrLen);
                    $tempAlpha = $alphaStr[$rand];
                    $avatar .= $tempAlpha;
                }
                $avatar = 'brand/'.$avatar;

                if ($count == 2000) {
                    $builder->insertAll('mysql_user', $insertArr);
                    $accumulative_total += $count;
                    ftruncate($fp, 0);
                    fwrite($fp, "共写入{$accumulative_total}个记录\n");
                    $count = 0;
                    $insertArr = [];
                    $client->execBuilder();
                }else {
                    $insertArr[] = [
                        'username' => $username,
                        'password' => $password,
                        'phone' => $phone,
                        'email' => $email,
                        'nickName' => $nickName,
                        'avatar' => $avatar,
                        'updated_at' => time(),
                        'created_at' => time()
                    ];
                    $count++;
                }
            }
            fclose($fp);
        });
        return "over";
    }

    public function help(array $args): ?string
    {
        return "生成千万级用户数据";
    }
}