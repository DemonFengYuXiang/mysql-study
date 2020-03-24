<?php
namespace EasySwoole\EasySwoole;

use EasySwoole\Component\Di;
use EasySwoole\HotReload\HotReloadOptions;
use EasySwoole\HotReload\HotReload;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Mysqli\Client;
use EasySwoole\Mysqli\Config;
use EasySwoole\Mysqli\QueryBuilder;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');

        $di = Di::getInstance();
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
        $di->set('client', $client);

    }

    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.
        $hotReloadOptions = new HotReloadOptions;
        $hotReload = new HotReload($hotReloadOptions);
        $hotReloadOptions->setMonitorFolder([EASYSWOOLE_ROOT . '/App']);
        $server = ServerManager::getInstance()->getSwooleServer();
        $hotReload->attachToServer($server);
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}