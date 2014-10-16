<?php

namespace Example;

/**
 * A mock class generated by Phony.
 *
 * @uses \Eloquent\Phony\Test\TestClassB
 * @uses \Iterator
 * @uses \Countable
 * @uses \ArrayAccess
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
class MockGeneratorTypical
extends \Eloquent\Phony\Test\TestClassB
implements \Eloquent\Phony\Mock\MockInterface,
           \Iterator,
           \Countable,
           \ArrayAccess
{
    const CONSTANT_A = 'constantValueA';
    const CONSTANT_B = 444;

    /**
     * Custom method 'methodA'.
     *
     * @param mixed $a0  Was 'first'.
     * @param mixed &$a1 Was 'second'.
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
     * Custom method 'methodB'.
     *
     * @param mixed $a0 Was 'first'.
     * @param mixed $a1 Was 'second'.
     * @param mixed $a2 Was 'third'.
     * @param mixed $a3 Was 'fourth'.
     * @param mixed $a4 Was 'fifth'.
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
     * Inherited method 'testClassAStaticMethodA'.
     *
     * @uses \Eloquent\Phony\Test\TestClassA::testClassAStaticMethodA()
     */
    public static function testClassAStaticMethodA()
    {
        if (isset(self::$_staticStubs[__FUNCTION__])) {
            return call_user_func_array(
                self::$_staticStubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'testClassAStaticMethodB'.
     *
     * @uses \Eloquent\Phony\Test\TestClassB::testClassAStaticMethodB()
     *
     * @param mixed $a0  Was 'first'.
     * @param mixed $a1  Was 'second'.
     * @param mixed &$a2 Was 'third'.
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
     * Inherited method 'testClassBStaticMethodA'.
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
     * Inherited method 'testClassBStaticMethodB'.
     *
     * @uses \Eloquent\Phony\Test\TestClassB::testClassBStaticMethodB()
     *
     * @param mixed $a0 Was 'first'.
     * @param mixed $a1 Was 'second'.
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
     * @param \Eloquent\Phony\Test\TestClassA      $a0 Was 'first'.
     * @param \Eloquent\Phony\Test\TestClassA|null $a1 Was 'second'.
     * @param array                                $a2 Was 'third'.
     * @param array|null                           $a3 Was 'fourth'.
     */
    public function methodC(
        \Eloquent\Phony\Test\TestClassA $a0,
        \Eloquent\Phony\Test\TestClassA $a1 = null,
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
     * @param mixed $a0 Was 'offset'.
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
     * @param mixed $a0 Was 'offset'.
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
     * @param mixed $a0 Was 'offset'.
     * @param mixed $a1 Was 'value'.
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
     * @param mixed $a0 Was 'offset'.
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
     * @uses \Eloquent\Phony\Test\TestClassB::testClassAMethodB()
     *
     * @param mixed $a0  Was 'first'.
     * @param mixed $a1  Was 'second'.
     * @param mixed &$a2 Was 'third'.
     */
    public function testClassAMethodB(
        $a0,
        $a1,
        &$a2 = null
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
     * @param mixed $a0 Was 'first'.
     * @param mixed $a1 Was 'second'.
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

    /**
     * Inherited method 'testClassAStaticMethodC'.
     *
     * @uses \Eloquent\Phony\Test\TestClassA::testClassAStaticMethodC()
     */
    protected static function testClassAStaticMethodC()
    {
        if (isset(self::$_staticStubs[__FUNCTION__])) {
            return call_user_func_array(
                self::$_staticStubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'testClassAStaticMethodD'.
     *
     * @uses \Eloquent\Phony\Test\TestClassA::testClassAStaticMethodD()
     *
     * @param mixed $a0 Was 'first'.
     * @param mixed $a1 Was 'second'.
     */
    protected static function testClassAStaticMethodD(
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
     * Inherited method 'testClassAMethodC'.
     *
     * @uses \Eloquent\Phony\Test\TestClassA::testClassAMethodC()
     */
    protected function testClassAMethodC()
    {
        if (isset($this->_stubs[__FUNCTION__])) {
            return call_user_func_array(
                $this->_stubs[__FUNCTION__],
                func_get_args()
            );
        }
    }

    /**
     * Inherited method 'testClassAMethodD'.
     *
     * @uses \Eloquent\Phony\Test\TestClassA::testClassAMethodD()
     *
     * @param mixed &$a0 Was 'first'.
     * @param mixed &$a1 Was 'second'.
     */
    protected function testClassAMethodD(
        &$a0,
        &$a1
    ) {
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
    private $_stubs = array();
}
