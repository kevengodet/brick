<?php

namespace Adagio\Brick\Api;

interface Namable
{
    public function getShortName();
    public function getNamespaceName();
    public function getFullyQualifiedName();
}