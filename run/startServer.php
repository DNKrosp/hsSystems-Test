<?php

require_once("../vendor/autoload.php");

use controller\CatController;
use model\Cat;
use Swoole\Coroutine\Http\Server;
use view\CatUtils;

Co\run(function () {
    $server = new Server('127.0.0.1', 9202, false);

    $server->handle('/', function (Swoole\Http\Request $request, Swoole\Http\Response $response) {
        $contr = new CatController();
        $catsHierarchyRender = CatUtils::getCatHierarchyRender($contr->listStructByParent());
        $template = file_get_contents(__DATA__."/index.html");
        $templateWithVars = str_replace("{{main}}", $catsHierarchyRender, $template);
        $html = "<h1>Hello</h1>$templateWithVars";
        $response->end($html);
    });

    $server->handle('/json', function (Swoole\Http\Request $request, Swoole\Http\Response $response) {
        $cats = Cat::list("id", true);
        $response->end($cats);
    });

    $server->start();
});