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
class MockGeneratorParameterConstant
implements \Eloquent\Phony\Mock\MockInterface
{
    /**
     * Custom method 'methodA'.
     *
     * @param mixed $a0 Was 'first'.
     */
    public function methodA(
        $a0 = \ReflectionMethod::IS_PUBLIC
    ) {
        $argumentCount = func_num_args();
        $arguments = array();

        if ($argumentCount > 0) $arguments[] = $a0;

        for ($i = 1; $i < $argumentCount; $i++) {
            $arguments[] = func_get_arg($i);
        }

        return $this->_proxy->spy(__FUNCTION__)->invokeWith(
            new \Eloquent\Phony\Call\Argument\Arguments($arguments)
        );
    }

    private static $_customMethods = array();
    private static $_staticProxy;
    private $_proxy;
}
