<?php

namespace app\Interfaces;

interface RouterInterface
{
    public const GET = "GET";
    public const POST = "POST";

    public function get(string $path, $handler): void;
    public function post(string $path, $handler): void;

    public function run(): void;
    public function addNotFoundHandler($handler): void;
}