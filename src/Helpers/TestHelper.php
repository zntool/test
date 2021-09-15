<?php

namespace ZnTool\Test\Helpers;

class TestHelper
{

    public static function isRewriteData(): bool
    {
        return !empty($_ENV['TEST_IS_REWRITE_DATA']);
    }
}
