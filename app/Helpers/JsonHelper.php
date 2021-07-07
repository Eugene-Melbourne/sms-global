<?php

namespace App\Helpers;

use function json_decode;
use function json_encode;

/**
 * @property integer    $options
 * @property boolean    $isAssociative
 */
class JsonHelper
{

    private $options;
    private $isAssociative;


    public function __construct()
    {
        $this->options       = JSON_THROW_ON_ERROR;
        $this->isAssociative = true;
    }


    public function setAsAssociative(bool $isAssociative): self
    {
        $this->isAssociative = $isAssociative;

        return $this;
    }


    public function addOption(int $option): self
    {
        $this->options = $this->options | $option;

        return $this;
    }


    /**
     * @param mixed $in
     */
    public function json_encode($in): ?string
    {
        $json = json_encode($in, $this->options);

        $haystack = ['null', '[]', '{}', '""'];

        if (in_array($json, $haystack)) {

            return null;
        }

        return $json;
    }


    /**
     * @return mixed
     */
    public function json_decode(?string $in)
    {
        $haystack = [null, 'null', '[]', '{}', '""'];

        if (in_array($in, $haystack)) {

            return null;
        }

        $value = json_decode($in, $this->isAssociative, 512, $this->options);

        return $value;
    }


}
