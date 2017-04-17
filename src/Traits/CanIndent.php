<?php

namespace Adagio\Brick\Traits;

trait CanIndent
{
    /**
     *
     * @param string $code
     * @param int $size
     * @param string $char
     *
     * @return string
     */
    private function indent(string $code, int $size = 4, string $char = ' '): string
    {
        $indent = str_repeat($char, $size);

        return $indent.str_replace("\n", "\n".$indent, $code);
    }
}
