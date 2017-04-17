<?php

namespace Adagio\Brick\Renderer;

use Adagio\Brick\PhpClass;
use Adagio\Brick\Traits\CanIndent;

final class ClassRenderer
{
    use CanIndent;

    const BLANK_LINE = '__renderer_blank_line';

    /**
     *
     * @param PhpClass $class
     */
    public function render(PhpClass $class): string
    {
        $lines = [];

        if ($ns = $class->getNamespaceName()) {
            $lines[] = "namespace $ns;";
        }

        $lines[] = self::BLANK_LINE;

        /* @var $related Namable */
        foreach ($class->getRelatedNamables() as $related) {
            $lines[] = 'use '.$related->getFullyQualifiedName().";";
        }

        $lines[] = self::BLANK_LINE;

        $code = '';
        if ($class->isFinal()) {
            $code = 'final ';
        }
        $code .= 'class '.$class->getShortName();

        if ($interfaces = $class->getImplementedInterfaces()) {
            $code .= ' implements ';
            $implements = [];
            /* @var $interface \Adagio\Brick\PhpInterface */
            foreach ($interfaces as $interface) {
                $implements[] = $interface->getShortName();
            }
            $code .= implode(', ', $implements);
        }
        $lines[] = $code."\n{";

        /* @var $trait \Adagio\Brick\PhpTrait */
        if ($class->getUsedTraits()) {
            foreach ($class->getUsedTraits() as $trait) {
                $lines[] = '    use '.$trait->getShortName().";";
            }
            $lines[] = self::BLANK_LINE;
        }

        if ($class->getConstants()) {
            foreach ($class->getConstants() as $name => $value) {
                $lines[] = '    const '.$name.' = '.var_export($value, true).";";
            }
            $lines[] = self::BLANK_LINE;
        }

        /* @var $method \Adagio\Brick\PhpMethod */
        foreach ($class->getMethods() as $method) {
            $lines[] = $this->indent((new MethodRenderer)->render($method));
            $lines[] = self::BLANK_LINE;
        }

        $lines[] = '}';

        // Generate code string
        $isBlank = false;
        $classCode = '';
        foreach($lines as $line) {
            if (self::BLANK_LINE === $line and $isBlank) {
                continue;
            }

            if (self::BLANK_LINE === $line) {
                $isBlank = true;
                $classCode .= "\n";
                continue;
            }

            $isBlank = false;
            $classCode .= $line."\n";
        }

        return $classCode."\n";
    }
}