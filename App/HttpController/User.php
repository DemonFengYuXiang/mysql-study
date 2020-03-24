<?php


namespace App\HttpController;


use EasySwoole\Component\Di;
use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Mysqli\QueryBuilder;

class User extends Controller
{

    function generate()
    {

        $client = Di::getInstance()->get('client');
        $builder = $client->queryBuilder();
        $builder->insertAll('mysql_user', [
            [
                'username' => 'ff',
                'password' => 'ff',
                'phone' => 12121,
                'email' => '121212',
                'nickName' => 'asasas',
                'avatar' => 'aaa',
                'updated_at' => time(),
                'created_at' => time()
            ],
            [
                'username' => 'ffff',
                'password' => 'dsjdjal',
                'phone' => 2323232,
                'email' => 'dsjdajlsd',
                'nickName' => 'jdjadlsa',
                'avatar' => 'djksdjla',
                'updated_at' => time(),
                'created_at' => time()
            ],
        ]);

       $alphaStr ='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $alphaStrLen = strlen($alphaStr) - 1;

       $numStr = '123456789';
       $numStrLen = strlen($numStr) - 1;

       $count = 0;
       $insertArr = [];
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
                $tempNum = $numStrLen[$rand];
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

            if ($count == 1000) {
                $builder->insertAll('mysql_user', $insertArr);
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

        $this->response()->write('ok');
    }

    function index()
    {
        // TODO: Implement index() method.
    }
}