<?php

namespace Adagio\Brick;

use Adagio\Brick\Api\Namable;
use Adagio\Brick\Traits\HasFQN;

final class PhpClass implements Namable
{
    use HasFQN;

    /**
     *
     * @var bool
     */
    private $final = true;

//    /**
//     * Array of FQCN to use
//     *
//     * @var PhpClass[]
//     */
//    private $useClasses = [];

    /**
     * Array of FQCN traits to use
     *
     * @var PhpTrait[]
     */
    private $traits = [];

    /**
     *
     * @var PhpInterface[]
     */
    private $implements = [];

    /**
     *
     * @var array
     */
    private $related = [];

    /**
     *
     * @var array
     */
    private $constants = [];

    /**
     *
     * @var PhpMethod[]
     */
    private $methods = [];

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
     * @param string|PhpClass $class
     *
     * @return PhpClass
     *
     * @throws \InvalidArgumentException
     */
    static public function create($class): PhpClass
    {
        if ($class instanceof self) {
            return $class;
        }

        if (is_string($class)) {
            return new self($class);
        }

        throw new \InvalidArgumentException('Unrecognized class format.');
    }

    /**
     *
     * @param string $name
     * @param mixed $value
     *
     * @return self
     */
    public function addConstant(string $name, $value): PhpClass
    {
        $this->constants[$name] = $value;

        return $this;
    }

    /**
     *
     * @return array
     */
    public function getConstants(): array
    {
        return $this->constants;
    }

//    /**
//     *
//     * @param string|PhpClass $class
//     *
//     * @return PhpClass
//     *
//     * @throws \InvalidArgumentException
//     */
//    public function useClass($class): PhpClass
//    {
//        $this->useClasses[] = self::create($class);
//
//        return self;
//    }

    /**
     *
     * @param string|PhpTrait $trait
     *
     * @return PhpClass
     *
     * @throws \InvalidArgumentException
     */
    public function useTrait($trait): PhpClass
    {
        $this->traits[] = $trait = PhpTrait::create($trait);
        $this->related[] = $trait;

        return $this;
    }

    /**
     *
     * @return PhpTrait[]
     */
    public function getUsedTraits(): array
    {
        return $this->traits;
    }

    /**
     *
     * @param string|Phpinterface $interface
     *
     * @return PhpClass
     *
     * @throws \InvalidArgumentException
     */
    public function implementsInterface($interface): PhpClass
    {
        $this->implements[] = $interface = PhpInterface::create($interface);
        $this->related[] = $interface;

        return $this;
    }

    /**
     *
     * @return PhpInterface[]
     */
    public function getImplementedInterfaces(): array
    {
        return $this->implements;
    }

    /**
     *
     * @return Namable[]
     */
    public function getRelatedNamables(): array
    {
        return $this->related;
    }

    /**
     *
     * @param bool $isFinal
     *
     * @return PhpClass
     */
    public function setFinal(bool $isFinal): PhpClass
    {
        $this->final = $isFinal;

        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isFinal(): bool
    {
        return $this->final;
    }

    /**
     *
     * @param PhpMethod $method
     *
     * @return PhpClass
     */
    public function addMethod(PhpMethod $method): PhpClass
    {
        $this->methods[] = $method;

        return $this;
    }

    public function addMethods(PhpMethod ...$methods): PhpClass
    {
        array_walk($methods, [$this, 'addMethod']);

        return $this;
    }

    /**
     *
     * @param string $name
     * @param array $arguments
     * @param string $returnType
     * @param string $body
     * @param array $phpDoc
     *
     * @return PhpClass
     */
    public function createMethod(string $name, array $arguments = [], string $returnType = null, string $body = '', array $phpDoc = []): PhpClass
    {
        $this->methods[] = (new PhpMethod($name))
                ->setArguments($arguments)
                ->setReturnType($returnType)
                ->setBody($body)
                ->setPhpDoc($phpDoc);

        return $this;
    }

    /**
     *
     * @return PhpMethod[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}
