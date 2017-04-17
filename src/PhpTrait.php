<?php

namespace Adagio\Brick;

use Adagio\Brick\Api\Namable;
use Adagio\Brick\Traits\HasFQN;

final class PhpTrait implements Namable
{
    use HasFQN;

    /**
     *
     * @param string $name
     */
    public function __construct(string $name = '')
    {
        $this->setName($name);
    }

    /**
     *
     * @param string|PhpTrait $trait
     *
     * @return PhpTrait
     *
     * @throws \InvalidArgumentException
     */
    static public function create($trait): PhpTrait
    {
        if ($trait instanceof self) {
            return $trait;
        }

        if (is_string($trait)) {
            return new self($trait);
        }

        throw new \InvalidArgumentException('Unrecognized trait format.');
    }
}
