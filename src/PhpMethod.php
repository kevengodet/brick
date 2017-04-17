<?php

namespace Adagio\Brick;

final class PhpMethod
{
    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var array
     */
    private $arguments = [];

    /**
     *
     * @var string
     */
    private $returnType;

    /**
     *
     * @var string
     */
    private $visibility = 'public';

    /**
     *
     * @var string
     */
    private $body;

    /**
     *
     * @var array
     */
    private $phpDoc;

    /**
     *
     * @var array
     */
    private $defaults = [];

    /**
     *
     * @param string $name
     * @param array $arguments
     * @param array $defaults
     * @param string $returnType
     * @param string $visibility
     * @param string $body
     * @param array $phpDoc
     */
    public function __construct(string $name, array $arguments = [], array $defaults = [], string $returnType = null, string $visibility = 'public', string $body = '', array $phpDoc = [])
    {
        $this->name       = $name;
        $this->arguments  = $arguments;
        $this->defaults   = $defaults;
        $this->returnType = $returnType;
        $this->visibility = $visibility;
        $this->body       = $body;
        $this->phpDoc     = $phpDoc;
    }

    /**
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     *
     * @param array $arguments
     *
     * @return PhpMethod
     */
    public function setArguments(array $arguments): PhpMethod
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     *
     * @param string $name
     * @param string $type
     * @param mixed $default
     *
     * @return PhpMethod
     */
    public function addArgument(string $name, string $type = null, $default = null): PhpMethod
    {
        $this->arguments[$name] = $type;

        if (func_num_args() > 2) {
            $this->defaults[$name] = $default;
        }

        return $this;
    }

    /**
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     *
     * @param array $defaults
     *
     * @return PhpMethod
     */
    public function setDefaults(array $defaults): PhpMethod
    {
        $this->defaults = $defaults;

        return $this;
    }

    /**
     *
     * @return array
     */
    public function getDefaults(): array
    {
        return $this->defaults;
    }

    /**
     *
     * @param string $argumentName
     *
     * @return bool
     */
    public function hasDefault(string $argumentName): bool
    {
        return isset($this->defaults[$argumentName]);
    }

    /**
     *
     * @param string $argumentName
     *
     * @return mixed
     *
     * @throws \LogicException
     */
    public function getDefault(string $argumentName)
    {
        if (!$this->hasDefault($argumentName)) {
            throw new \LogicException("$argumentName has no default value.");
        }

        return $this->defaults[$argumentName];
    }

    /**
     *
     * @param string $visibility
     *
     * @return PhpMethod
     */
    public function setVisibility(string $visibility): PhpMethod
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     *
     * @param string $type
     *
     * @return PhpMethod
     */
    public function setReturnType(string $type): PhpMethod
    {
        $this->returnType = $type;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getReturnType(): string
    {
        return $this->returnType;
    }

    /**
     *
     * @return bool
     */
    public function hasReturnType(): bool
    {
        return !is_null($this->returnType);
    }

    /**
     *
     * @param string $body
     *
     * @return PhpMethod
     */
    public function setBody(string $body): PhpMethod
    {
        $this->body = $body;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     *
     * @param array $phpDoc
     *
     * @return PhpMethod
     */
    public function setPhpDoc(array $phpDoc): PhpMethod
    {
        $this->phpDoc = $phpDoc;

        return $this;
    }

    /**
     *
     * @param string $name
     * @param string $value
     *
     * @return PhpMethod
     */
    public function addPhpDoc(string $name, string $value = ''): PhpMethod
    {
        $this->phpdocs[$name] = $value;

        return $this;
    }

    /**
     *
     * @return array
     */
    public function getPhpDoc(): array
    {
        return $this->phpDoc;
    }
}
