<?php

/**
 * A mock class generated by Phony.
 *
 * This file is part of the Phony package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with the Phony source code.
 *
 * @link https://github.com/eloquent/phony
 */
class PhonyMock_stdClass_111
extends stdClass
implements Eloquent\Phony\Mock\MockInterface,
           Iterator,
           Countable,
           ArrayAccess
{
    const CONSTANT_A = 'constantValueA';
    const CONSTANT_B = 444;
    const CONSTANT_C = array();
    const CONSTANT_D = array('valueA', 'valueB');
    const CONSTANT_E = array('keyA' => 'valueA', 'keyB' => 'valueB');

    public static function methodA(
        $a0,
        &$a1
    ) {
    }

    public static function methodB(
        $a0 = null,
        $a1 = 111,
        $a2 = array(),
        $a3 = array('valueA', 'valueB'),
        $a4 = array('keyA' => 'valueA', 'keyB' => 'valueB')
    ) {
    }

    /**
     * Construct a mock.
     *
     * @param array<string,Eloquent\Phony\Stub\StubInterface>|null $stubs The stubs to use.
     */
    public function __construct(
        array $stubs = null
    ) {
        if (null === $stubs) {
            $stubs = array();
        }

        $this->_stubs = $stubs;
    }

    /**
     * Call the parent constructor.
     */
    public function _constructParent()
    {
        parent::__construct();
    }

    public function count()
    {
    }

    public function current()
    {
    }

    public function key()
    {
    }

    public function methodC(
        Eloquent\Phony\Test\TestClass $a0,
        Eloquent\Phony\Test\TestClass $a1 = null,
        array $a2,
        array $a3 = null
    ) {
    }

    public function methodD()
    {
    }

    public function next()
    {
    }

    public function offsetExists()
    {
    }

    public function offsetGet()
    {
    }

    public function offsetSet(
        $a0
    ) {
    }

    public function offsetUnset()
    {
    }

    public function rewind()
    {
    }

    public function valid()
    {
    }

    public static $propertyA = 'valueA';
    public static $propertyB = 222;
    public $propertyC = 'valueC';
    public $propertyD = 333;
    private $_stubs;
}
