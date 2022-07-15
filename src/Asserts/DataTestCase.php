<?php

namespace ZnTool\Test\Asserts;

use ZnCore\Collection\Interfaces\Enumerable;
use ZnCore\Collection\Helpers\CollectionHelper;

class DataTestCase extends BaseAssert
{

    public static function loadFromJsonFile(string $fileName)
    {
        return json_decode(file_get_contents($fileName), JSON_OBJECT_AS_ARRAY);
    }

    public static function saveToJsonFile(string $fileName, $data)
    {
        if ($data instanceof Enumerable) {
            $data = CollectionHelper::toArray($data);
        }
        file_put_contents(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}
