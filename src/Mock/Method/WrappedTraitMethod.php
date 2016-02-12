<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Mock\Method;

use Eloquent\Phony\Call\Argument\Arguments;
use Eloquent\Phony\Call\Argument\ArgumentsInterface;
use Eloquent\Phony\Mock\Handle\HandleInterface;
use Error;
use Exception;
use ReflectionMethod;

/**
 * A wrapper that allows calling of the trait method in mocks.
 */
class WrappedTraitMethod extends AbstractWrappedMethod
{
    /**
     * Construct a new wrapped trait method.
     *
     * @param ReflectionMethod $callTraitMethod The _callTrait() method.
     * @param string           $traitName       The trait name.
     * @param ReflectionMethod $method          The method.
     * @param HandleInterface  $handle          The handle.
     */
    public function __construct(
        ReflectionMethod $callTraitMethod,
        $traitName,
        ReflectionMethod $method,
        HandleInterface $handle
    ) {
        $this->callTraitMethod = $callTraitMethod;
        $this->traitName = $traitName;

        parent::__construct($method, $handle);
    }

    /**
     * Get the _callTrait() method.
     *
     * @return ReflectionMethod The _callTrait() method.
     */
    public function callTraitMethod()
    {
        return $this->callTraitMethod;
    }

    /**
     * Get the trait name.
     *
     * @return string The trait name.
     */
    public function traitName()
    {
        return $this->traitName;
    }

    /**
     * Invoke this object.
     *
     * This method supports reference parameters.
     *
     * @param ArgumentsInterface|array $arguments The arguments.
     *
     * @return mixed           The result of invocation.
     * @throws Exception|Error If an error occurs.
     */
    public function invokeWith($arguments = array())
    {
        return $this->callTraitMethod->invoke(
            $this->mock,
            $this->traitName,
            $this->name,
            Arguments::adapt($arguments)
        );
    }

    private $callTraitMethod;
    private $traitName;
}
