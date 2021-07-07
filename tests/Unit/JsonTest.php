<?php

namespace Tests\Unit;

use Exception;
use JsonException;
use PHPUnit\Framework\TestCase;
use stdClass;
use function json_decode;
use function json_encode;
use function utf8_encode;

class JsonTest extends TestCase
{


    public function test_json_encode(): void
    {
        $array = [
            1,
            'one',
            'я',
        ];
        $json  = json_encode($array);
        $this->assertSame('[1,"one","\u044f"]', $json);


        $array = [
            1,
            'one',
            html_entity_decode('&nbsp;'),
        ];
        $json  = json_encode($array);
        $this->assertSame('[1,"one","\u00a0"]', $json);


        $array = [
            1,
            'one',
            chr(160),
        ];
        $json  = json_encode($array);
        $this->assertSame(false, $json);


        $array = [
            1,
            'one',
            'я',
            utf8_encode(chr(160)),
        ];
        $json  = json_encode($array);
        $this->assertSame('[1,"one","\u044f","\u00a0"]', $json);


        try {
            $ex    = null;
            $array = [chr(160)];
            $json  = json_encode($array, JSON_THROW_ON_ERROR);
        } catch (Exception $ex) {
            
        }
        $this->assertNotNull($ex);
        $this->assertSame(JsonException::class, get_class($ex));
        $this->assertSame('Malformed UTF-8 characters, possibly incorrectly encoded', $ex->getMessage());
        $this->assertSame(JSON_ERROR_UTF8, $ex->getCode());

        $array = [
            1,
            'one',
            chr(160),
        ];
        $json  = json_encode($array, JSON_INVALID_UTF8_SUBSTITUTE);
        $this->assertSame('[1,"one","\ufffd"]', $json); //Unicode Character 'REPLACEMENT CHARACTER' (U+FFFD)


        $array = [];
        $json  = json_encode($array);
        $this->assertSame('[]', $json);


        $array = null;
        $json  = json_encode($array);
        $this->assertSame('null', $json);


        $array = 0;
        $json  = json_encode($array);
        $this->assertSame('0', $json);

        $array = false;
        $json  = json_encode($array);
        $this->assertSame('false', $json);

        $array = new stdClass();
        $json  = json_encode($array);
        $this->assertSame('{}', $json);

        $array = 's';
        $json  = json_encode($array);
        $this->assertSame('"s"', $json);
    }


    public function test_json_decode(): void
    {
        $value = json_decode('false');
        $this->assertSame(false, $value);

        $value = json_decode('null');
        $this->assertSame(null, $value);

        $value = json_decode('0');
        $this->assertSame(0, $value);

        $value = json_decode('[]');
        $this->assertSame([], $value);

        $value = json_decode('{}');
        $this->assertSame(stdClass::class, get_class($value));


        $value = json_decode('false', true);
        $this->assertSame(false, $value);

        $value = json_decode('null', true);
        $this->assertSame(null, $value);

        $value = json_decode('0', true);
        $this->assertSame(0, $value);

        $value = json_decode('[]', true);
        $this->assertSame([], $value);

        $value = json_decode('{}', true);
        $this->assertSame([], $value);


        $value = json_decode('s');
        $this->assertSame(null, $value);

        $value = json_decode('s');
        $this->assertSame(null, $value);

        try {
            $ex    = null;
            $value = json_decode('s', null, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $ex) {
            
        }
        $this->assertNotNull($ex);
        $this->assertSame(JsonException::class, get_class($ex));
        $this->assertSame('Syntax error', $ex->getMessage());
        $this->assertSame(JSON_ERROR_SYNTAX, $ex->getCode());


        try {
            $ex    = null;
            $value = json_decode('"' . chr(160) . '"', null, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $ex) {
            
        }
        $this->assertNotNull($ex);
        $this->assertSame(JsonException::class, get_class($ex));
        $this->assertSame('Malformed UTF-8 characters, possibly incorrectly encoded', $ex->getMessage());
        $this->assertSame(JSON_ERROR_UTF8, $ex->getCode());
    }


}
