<?php

namespace Adagio\Brick\Renderer;

use Adagio\Brick\PhpMethod;
use Adagio\Brick\Traits\CanIndent;

final class MethodRenderer
{
    use CanIndent;

    /**
     *
     * @param PhpMethod $method
     *
     * @return string
     */
    public function render(PhpMethod $method): string
    {
        $code = $method->getVisibility().' function '.$method->getName().'(';
        $args = [];
        foreach ($method->getArguments() as $name => $type) {
            $arg = "$type \$$name";
            if ($method->hasDefault($name)) {
                $arg .= ' = '.var_export($method->getDefault($name), true);
            }
            $args[] = $arg;
        }
        $code .= implode(', ', $args).')';
        if ($method->hasReturnType()) {
            $code .= ': '.$method->getReturnType();
        }
        $code .= "\n{\n".$this->indent($method->getBody())."\n}";

        return $code;
    }
}
