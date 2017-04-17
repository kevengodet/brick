<?php

namespace Adagio\Brick;

use Adagio\Brick\Api\Namable;
use Adagio\Brick\Traits\HasFQN;

final class PhpInterface implements Namable
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
     * @param string|PhpInterface $interface
     *
     * @return PhpInterface
     *
     * @throws \InvalidArgumentException
     */
    static public function create($interface): PhpInterface
    {
        if ($interface instanceof self) {
            return $interface;
        }

        if (is_string($interface)) {
            return new self($interface);
        }

        throw new \InvalidArgumentException('Unrecognized interface format.');
    }
}
