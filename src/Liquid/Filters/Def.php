<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 21.3.2019 г.
 * Time: 17:35 ч.
 */

namespace Liquid\Filters;

class Def
{

    /**
     * Default
     *
     * @param string $input
     * @param string $default_value
     *
     * @return string
     */
    public static function default($input, $default_value)
    {
        $isBlank = $input == '' || $input === false || $input === null;
        return $isBlank ? $default_value : $input;
    }

}