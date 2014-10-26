<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Mock\Proxy;

use Eloquent\Phony\Call\Argument\Arguments;
use Eloquent\Phony\Call\Argument\ArgumentsInterface;
use Eloquent\Phony\Matcher\WildcardMatcherInterface;
use Eloquent\Phony\Mock\MockInterface;
use Eloquent\Phony\Stub\Factory\StubFactoryInterface;
use Eloquent\Phony\Stub\Factory\StubVerifierFactoryInterface;
use ReflectionClass;
use stdClass;

/**
 * An abstract base class for implementing instance proxies.
 *
 * @internal
 */
abstract class AbstractInstanceProxy extends AbstractProxy implements
    InstanceProxyInterface
{
    /**
     * Construct a new instance proxy.
     *
     * @param MockInterface                     $mock                The mock.
     * @param stdClass|null                     $stubs               The stubs.
     * @param boolean|null                      $isFull              True if the mock is a full mock.
     * @param string|null                       $id                  The identifier.
     * @param StubFactoryInterface|null         $stubFactory         The stub factory to use.
     * @param StubVerifierFactoryInterface|null $stubVerifierFactory The stub verifier factory to use.
     * @param WildcardMatcherInterface|null     $wildcardMatcher     The wildcard matcher to use.
     */
    public function __construct(
        MockInterface $mock,
        stdClass $stubs = null,
        $isFull = null,
        $id = null,
        StubFactoryInterface $stubFactory = null,
        StubVerifierFactoryInterface $stubVerifierFactory = null,
        WildcardMatcherInterface $wildcardMatcher = null
    ) {
        $class = new ReflectionClass($mock);

        if ($class->hasMethod('_callParent')) {
            $callParentMethod = $class->getMethod('_callParent');
            $callParentMethod->setAccessible(true);
        } else {
            $callParentMethod = null;
        }

        if ($class->hasMethod('_callMagic')) {
            $callMagicMethod = $class->getMethod('_callMagic');
            $callMagicMethod->setAccessible(true);
        } else {
            $callMagicMethod = null;
        }

        $this->mock = $mock;
        $this->id = $id;
        $this->class = $class;
        $this->callParentMethod = $callParentMethod;

        parent::__construct(
            $class,
            $stubs,
            $isFull,
            $callParentMethod,
            $callMagicMethod,
            $mock,
            $stubFactory,
            $stubVerifierFactory,
            $wildcardMatcher
        );
    }

    /**
     * Get the mock.
     *
     * @return MockInterface The mock.
     */
    public function mock()
    {
        return $this->mock;
    }

    /**
     * Call the original constructor.
     *
     * @param mixed $arguments,... The arguments.
     */
    public function construct()
    {
        $this->constructWith(func_get_args());
    }

    /**
     * Call the original constructor.
     *
     * @param ArgumentsInterface|array<integer,mixed>|null $arguments The arguments.
     */
    public function constructWith($arguments = null)
    {
        if ($this->callParentMethod) {
            $parentClass = $this->class->getParentClass();

            if ($constructor = $parentClass->getConstructor()) {
                $this->callParentMethod->invoke(
                    $this->mock,
                    $constructor->getName(),
                    Arguments::adapt($arguments)
                );
            }
        }
    }

    /**
     * Get the identifier.
     *
     * @return string|null The identifier.
     */
    public function id()
    {
        return $this->id;
    }

    private $mock;
    private $id;
    private $class;
    private $callParentMethod;
}
