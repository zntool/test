<?php

namespace ZnTool\Test\Traits;

trait BaseUrlTrait
{

    protected $baseUrl;
    protected $basePath = '/';
    
    protected function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    protected function getBaseUrl(): string
    {
        $basePath = trim($this->basePath, '/');
        $baseUrl = $this->baseUrl . '/' . $basePath;
        $baseUrl = trim($baseUrl, '/');
        return $baseUrl;
    }
}