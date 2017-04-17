<?php

namespace Adagio\Brick\Traits;

trait HasFQN
{
    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var string
     */
    private $namespace;

    /**
     *
     * @var string
     */
    private $shortName;

    /**
     *
     * @var string
     */
    private $fullNS;

    /**
     *
     * @var string
     */
    private $fqn;

    /**
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;
        $this->resolvedNS = null;
        $this->resolvedName = null;

        return $this;
    }

    /**
     *
     * @param string $namespace
     *
     * @return self
     */
    public function setNamespace(string $namespace)
    {
        $this->namespace = $namespace;
        $this->resolvedNS = null;
        $this->resolvedName = null;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getShortName(): string
    {
        if (!$this->isNameResolved()) {
            $this->resolveName();
        }

        return $this->shortName;
    }

    /**
     *
     * @return string
     */
    public function getNamespaceName(): string
    {
        if (!$this->isNameResolved()) {
            $this->resolveName();
        }

        return $this->fullNS;
    }

    /**
     *
     * @return string
     */
    public function getFullyQualifiedName(): string
    {
        if (!$this->isNameResolved()) {
            $this->resolveName();
        }

        return $this->fqn;
    }

    /**
     *
     * @return bool
     */
    private function isNameResolved(): bool
    {
        return !is_null($this->shortName);
    }

    private function resolveName()
    {
        $name = trim($this->name, '\\');

        if (false === $pos = strrpos($name, '\\')) {
            $this->shortName = $name;
            $ns = '';
        } else {
            $this->shortName = substr($name, $pos + 1);
            $ns = substr($name, 0, $pos);
        }

        $namespace = trim($this->namespace, '\\');

        if ($namespace and $ns) {
            $this->fullNS = $namespace.'\\'.$ns;
        } else {
            $this->fullNS = $namespace.$ns;
        }

        $this->fqn = $this->fullNS ?
                $this->fullNS.'\\'.$this->shortName :
                $this->shortName;
    }
}
