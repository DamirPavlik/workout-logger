<?php

namespace app\Support;

use app\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    protected array $handlers;
    private $notFoundHandler;
    private const METHOD_POST = "POST";
    private const METHOD_GET = "GET";

    public function get(string $path, $handler): void
    {
        $this->addHandler(method: self::METHOD_GET, path: $path, handler: $handler);
    }

    public function post(string $path, $handler): void
    {
        $this->addHandler(method: self::METHOD_POST, path: $path, handler: $handler);
    }

    private function addHandler(string $method, string $path, $handler): void
    {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler
        ];
    }

    public function addNotFoundHandler($handler): void
    {
        $this->notFoundHandler = $handler;
    }

    public function run(): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];

        $callback = $this->findHandler($requestPath, $method);

        if (!$callback) {
            $callback = $this->notFoundHandler;
            http_response_code(response_code: 404);
        }

        call_user_func_array($callback, [array_merge($_GET, $_POST)]);
    }

    private function findHandler(string $requestPath, string $method): ?callable
    {
        foreach ($this->handlers as $handler) {
            if ($handler['path'] === $requestPath && $handler['method'] === $method) {
                if(is_string($handler['handler'])) {
                    [$className, $method] = explode(separator: "::", string: $handler['handler']);
                    $handler['handler'] = [new $className, $method];
                }
                return $handler['handler'];
            }
        }
        return null;
    }
}