<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Mock\Builder\Exception;

use Exception;

/**
 * Unable to modify a finalized mock.
 *
 * @internal
 */
final class FinalizedMockException extends Exception implements
    MockBuilderExceptionInterface
{
    /**
     * Construct a finalized mock exception.
     *
     * @param Exception|null $cause The cause, if available.
     */
    public function __construct(Exception $cause = null)
    {
        parent::__construct('Unable to modify a finalized mock.', 0, $cause);
    }
}
