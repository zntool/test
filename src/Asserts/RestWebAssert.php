<?php

namespace ZnTool\Test\Asserts;


use ZnCore\Base\Text\Helpers\TextHelper;
use ZnTool\Test\Helpers\RestHelper;
use Psr\Http\Message\ResponseInterface;

class RestWebAssert extends RestAssert
{

    public function __construct(ResponseInterface $response = null)
    {
        parent::__construct($response);
        $this->body = $this->rawBody;
    }

    public function assertSubsetText($actualString, ResponseInterface $response = null)
    {
        $response = $response ?? $this->response;
        //$body = StringHelper::removeAllSpace($body);
        $exp = '#[^а-яА-ЯёЁa-zA-Z]+#u';
        $body = TextHelper::filterChar($this->rawBody, $exp);
        //$actualString = StringHelper::removeAllSpace($actualString);
        $actualString = TextHelper::filterChar($actualString, $exp);
        $isFail = mb_strpos($body, $actualString) === false;
        if ($isFail) {
            $this->expectExceptionMessage('Subset string not found in text!');
        }
        $this->assertEquals(false, $isFail);
        return $this;
    }

}
