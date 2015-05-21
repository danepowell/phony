<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2015 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Matcher;

use Eloquent\Phony\Exporter\ExporterInterface;
use Eloquent\Phony\Exporter\InlineExporter;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\Factory;

/**
 * A matcher that tests if the value is equal to (==) another value.
 *
 * @internal
 */
class EqualToMatcher extends AbstractMatcher
{
    /**
     * Construct a new equal to matcher.
     *
     * @param mixed $value The value to check against.
     * @param Factory|null The comparator factory to use.
     * @param ExporterInterface|null The exporter to use.
     */
    public function __construct(
        $value,
        Factory $comparatorFactory = null,
        ExporterInterface $exporter = null
    ) {
        if (null === $comparatorFactory) {
            $comparatorFactory = new Factory();
        }
        if (null === $exporter) {
            $exporter = InlineExporter::instance();
        }

        $this->value = $value;

        if (is_object($value)) {
            $this->valueClass = get_class($value);
        }

        $this->comparatorFactory = $comparatorFactory;
        $this->exporter = $exporter;
    }

    /**
     * Get the value.
     *
     * @return mixed The value.
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Get the comparator factory.
     *
     * @return Factory The comparator factory.
     */
    public function comparatorFactory()
    {
        return $this->comparatorFactory;
    }

    /**
     * Get the exporter.
     *
     * @return ExporterInterface The exporter.
     */
    public function exporter()
    {
        return $this->exporter;
    }

    /**
     * Returns true if the supplied value matches.
     *
     * @param mixed $value The value to check.
     *
     * @return boolean True if the value matches.
     */
    public function matches($value)
    {
        if ($value === $this->value) {
            return true;
        }

        if ($this->valueClass && !$value instanceof $this->valueClass) {
            return false;
        }

        $comparator = $this->comparatorFactory
            ->getComparatorFor($this->value, $value);

        try {
            $comparator->assertEquals($this->value, $value);
        } catch (ComparisonFailure $e) {
            return false;
        }

        return true;
    }

    /**
     * Describe this matcher.
     *
     * @return string The description.
     */
    public function describe()
    {
        return $this->exporter->export($this->value);
    }

    private $value;
    private $valueClass;
    private $comparatorFactory;
    private $exporter;
}
