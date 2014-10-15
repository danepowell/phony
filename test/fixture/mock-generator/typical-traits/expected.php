<?php

namespace Example;

/**
 * A mock class generated by Phony.
 *
 * @uses \Eloquent\Phony\Test\TestClassB
 * @uses \Iterator
 * @uses \Countable
 * @uses \ArrayAccess
 * @uses \Eloquent\Phony\Test\TestTraitA
 * @uses \Eloquent\Phony\Test\TestTraitB
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
class MockGeneratorTypicalTraits
extends \Eloquent\Phony\Test\TestClassB
implements \Eloquent\Phony\Mock\MockInterface,
           \Iterator,
           \Countable,
           \ArrayAccess
{
    use \Eloquent\Phony\Test\TestTraitA;
    use \Eloquent\Phony\Test\TestTraitB;

    const CONSTANT_A = 'constantValueA';
    const CONSTANT_B = 444;

    /**
     * Set the static stubs.
     *
     * @param array<string,\Eloquent\Phony\Stub\StubInterface>|null $staticStubs The stubs to use.
     */
    public static function _setStaticStubs(array $staticStubs)
    {
        self::$_staticStubs = $staticStubs;
    }

    /**
     * Custom static method 'methodA'.
     *
     * @param mixed $a0  Originally named 'first'.
     * @param mixed &$a1 Originally named 'second'.
     */
    public static function methodA(
        $a0,
        &$a1
    ) {
        if (isset(self::$_staticStubs[__FUNCTION__])) {
            return call_user_func_array(
                self::$_staticStubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Custom static method 'methodB'.
     *
     * @param mixed $a0 Originally named 'first'.
     * @param mixed $a1 Originally named 'second'.
     * @param mixed $a2 Originally named 'third'.
     * @param mixed $a3 Originally named 'fourth'.
     * @param mixed $a4 Originally named 'fifth'.
     */
    public static function methodB(
        $a0 = null,
        $a1 = 111,
        $a2 = array(),
        $a3 = array('valueA', 'valueB'),
        $a4 = array('keyA' => 'valueA', 'keyB' => 'valueB')
    ) {
        if (isset(self::$_staticStubs[__FUNCTION__])) {
            return call_user_func_array(
                self::$_staticStubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited static method 'testClassAStaticMethodA'.
     *
     * @uses \Eloquent\Phony\Test\TestTraitA::testClassAStaticMethodA()
     *
     * @param mixed &$a0 Originally named 'first'.
     */
    public static function testClassAStaticMethodA(
        &$a0 = null
    ) {
        if (isset(self::$_staticStubs[__FUNCTION__])) {
            return call_user_func_array(
                self::$_staticStubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited static method 'testClassAStaticMethodB'.
     *
     * @uses \Eloquent\Phony\Test\TestClassB::testClassAStaticMethodB()
     *
     * @param mixed $a0  Originally named 'first'.
     * @param mixed $a1  Originally named 'second'.
     * @param mixed &$a2 Originally named 'third'.
     */
    public static function testClassAStaticMethodB(
        $a0,
        $a1,
        &$a2 = null
    ) {
        if (isset(self::$_staticStubs[__FUNCTION__])) {
            return call_user_func_array(
                self::$_staticStubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited static method 'testClassBStaticMethodA'.
     *
     * @uses \Eloquent\Phony\Test\TestClassB::testClassBStaticMethodA()
     */
    public static function testClassBStaticMethodA()
    {
        if (isset(self::$_staticStubs[__FUNCTION__])) {
            return call_user_func_array(
                self::$_staticStubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited static method 'testClassBStaticMethodB'.
     *
     * @uses \Eloquent\Phony\Test\TestClassB::testClassBStaticMethodB()
     *
     * @param mixed $a0 Originally named 'first'.
     * @param mixed $a1 Originally named 'second'.
     */
    public static function testClassBStaticMethodB(
        $a0,
        $a1
    ) {
        if (isset(self::$_staticStubs[__FUNCTION__])) {
            return call_user_func_array(
                self::$_staticStubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Construct a mock.
     *
     * @param array<string,\Eloquent\Phony\Stub\StubInterface>|null $stubs The stubs to use.
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
     * Inherited method 'count'.
     *
     * @uses \Countable::count()
     */
    public function count()
    {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'current'.
     *
     * @uses \Iterator::current()
     */
    public function current()
    {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'key'.
     *
     * @uses \Iterator::key()
     */
    public function key()
    {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Custom method 'methodC'.
     *
     * @param \Eloquent\Phony\Test\TestClass      $a0 Originally named 'first'.
     * @param \Eloquent\Phony\Test\TestClass|null $a1 Originally named 'second'.
     * @param array                               $a2 Originally named 'third'.
     * @param array|null                          $a3 Originally named 'fourth'.
     */
    public function methodC(
        \Eloquent\Phony\Test\TestClass $a0,
        \Eloquent\Phony\Test\TestClass $a1 = null,
        array $a2 = array(),
        array $a3 = null
    ) {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Custom method 'methodD'.
     */
    public function methodD()
    {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'next'.
     *
     * @uses \Iterator::next()
     */
    public function next()
    {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'offsetExists'.
     *
     * @uses \ArrayAccess::offsetExists()
     *
     * @param mixed $a0 Originally named 'offset'.
     */
    public function offsetExists(
        $a0
    ) {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'offsetGet'.
     *
     * @uses \ArrayAccess::offsetGet()
     *
     * @param mixed $a0 Originally named 'offset'.
     */
    public function offsetGet(
        $a0
    ) {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'offsetSet'.
     *
     * @uses \ArrayAccess::offsetSet()
     *
     * @param mixed $a0 Originally named 'offset'.
     * @param mixed $a1 Originally named 'value'.
     */
    public function offsetSet(
        $a0,
        $a1
    ) {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'offsetUnset'.
     *
     * @uses \ArrayAccess::offsetUnset()
     *
     * @param mixed $a0 Originally named 'offset'.
     */
    public function offsetUnset(
        $a0
    ) {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'rewind'.
     *
     * @uses \Iterator::rewind()
     */
    public function rewind()
    {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'testClassAMethodA'.
     *
     * @uses \Eloquent\Phony\Test\TestClassA::testClassAMethodA()
     */
    public function testClassAMethodA()
    {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'testClassAMethodB'.
     *
     * @uses \Eloquent\Phony\Test\TestTraitB::testClassAMethodB()
     *
     * @param mixed $a0  Originally named 'first'.
     * @param mixed $a1  Originally named 'second'.
     * @param mixed &$a2 Originally named 'third'.
     * @param mixed &$a3 Originally named 'fourth'.
     * @param mixed &$a4 Originally named 'fifth'.
     */
    public function testClassAMethodB(
        $a0,
        $a1,
        &$a2 = null,
        &$a3 = null,
        &$a4 = null
    ) {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'testClassBMethodA'.
     *
     * @uses \Eloquent\Phony\Test\TestClassB::testClassBMethodA()
     */
    public function testClassBMethodA()
    {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'testClassBMethodB'.
     *
     * @uses \Eloquent\Phony\Test\TestClassB::testClassBMethodB()
     *
     * @param mixed $a0 Originally named 'first'.
     * @param mixed $a1 Originally named 'second'.
     */
    public function testClassBMethodB(
        $a0,
        $a1
    ) {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'valid'.
     *
     * @uses \Iterator::valid()
     */
    public function valid()
    {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    public static $propertyA = 'valueA';
    public static $propertyB = 222;
    public $propertyC = 'valueC';
    public $propertyD = 333;
    private static $_staticStubs = array();
    private $_stubs;
}
