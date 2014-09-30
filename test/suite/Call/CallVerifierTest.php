<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Call;

use Eloquent\Phony\Assertion\AssertionRecorder;
use Eloquent\Phony\Assertion\Renderer\AssertionRenderer;
use Eloquent\Phony\Integration\Phpunit\PhpunitMatcherDriver;
use Eloquent\Phony\Matcher\Factory\MatcherFactory;
use Eloquent\Phony\Matcher\Verification\MatcherVerifier;
use Eloquent\Phony\Test\TestAssertionRecorder;
use Exception;
use PHPUnit_Framework_TestCase;
use ReflectionMethod;
use RuntimeException;

class CallVerifierTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->reflector = new ReflectionMethod(__METHOD__);
        $this->arguments = array('argumentA', 'argumentB', 'argumentC');
        $this->argumentCount = count($this->arguments);
        $this->returnValue = 'returnValue';
        $this->sequenceNumber = 111;
        $this->startTime = 1.11;
        $this->endTime = 2.22;
        $this->duration = $this->endTime - $this->startTime;
        $this->exception = new RuntimeException('You done goofed.');
        $this->thisValue = (object) array();
        $this->call = new Call(
            $this->reflector,
            $this->arguments,
            $this->returnValue,
            $this->sequenceNumber,
            $this->startTime,
            $this->endTime,
            $this->exception,
            $this->thisValue
        );
        $this->matcherFactory = new MatcherFactory(array(new PhpunitMatcherDriver()));
        $this->matcherVerifier = new MatcherVerifier();
        $this->assertionRecorder = new TestAssertionRecorder();
        $this->assertionRenderer = new AssertionRenderer();
        $this->subject = new CallVerifier(
            $this->call,
            $this->matcherFactory,
            $this->matcherVerifier,
            $this->assertionRecorder,
            $this->assertionRenderer
        );

        $this->callNoException = new Call(
            $this->reflector,
            $this->arguments,
            $this->returnValue,
            $this->sequenceNumber,
            $this->startTime,
            $this->endTime,
            null,
            $this->thisValue
        );
        $this->subjectNoException = new CallVerifier(
            $this->callNoException,
            $this->matcherFactory,
            $this->matcherVerifier,
            $this->assertionRecorder,
            $this->assertionRenderer
        );

        $this->callNoArguments = new Call(
            $this->reflector,
            array(),
            $this->returnValue,
            $this->sequenceNumber,
            $this->startTime,
            $this->endTime,
            null,
            $this->thisValue
        );
        $this->subjectNoArguments = new CallVerifier(
            $this->callNoArguments,
            $this->matcherFactory,
            $this->matcherVerifier,
            $this->assertionRecorder,
            $this->assertionRenderer
        );

        $this->earlyCall = new Call(
            $this->reflector,
            $this->arguments,
            $this->returnValue,
            $this->sequenceNumber - 1,
            $this->startTime,
            $this->endTime
        );
        $this->lateCall = new Call(
            $this->reflector,
            $this->arguments,
            $this->returnValue,
            $this->sequenceNumber + 1,
            $this->startTime,
            $this->endTime
        );

        $this->argumentMatchers = $this->matcherFactory->adaptAll($this->arguments);
    }

    public function testConstructor()
    {
        $this->assertSame($this->call, $this->subject->call());
        $this->assertSame($this->duration, $this->subject->duration());
        $this->assertSame($this->argumentCount, $this->subject->argumentCount());
        $this->assertSame($this->matcherFactory, $this->subject->matcherFactory());
        $this->assertSame($this->matcherVerifier, $this->subject->matcherVerifier());
        $this->assertSame($this->assertionRecorder, $this->subject->assertionRecorder());
        $this->assertSame($this->assertionRenderer, $this->subject->assertionRenderer());
    }

    public function testConstructorDefaults()
    {
        $this->subject = new CallVerifier($this->call);

        $this->assertSame(MatcherFactory::instance(), $this->subject->matcherFactory());
        $this->assertSame(MatcherVerifier::instance(), $this->subject->matcherVerifier());
        $this->assertSame(AssertionRecorder::instance(), $this->subject->assertionRecorder());
        $this->assertSame(AssertionRenderer::instance(), $this->subject->assertionRenderer());
    }

    public function testProxyMethods()
    {
        $this->assertSame($this->reflector, $this->subject->reflector());
        $this->assertSame($this->arguments, $this->subject->arguments());
        $this->assertSame($this->returnValue, $this->subject->returnValue());
        $this->assertSame($this->sequenceNumber, $this->subject->sequenceNumber());
        $this->assertSame($this->startTime, $this->subject->startTime());
        $this->assertSame($this->endTime, $this->subject->endTime());
        $this->assertSame($this->exception, $this->subject->exception());
        $this->assertSame($this->thisValue, $this->subject->thisValue());
    }

    public function calledWithData()
    {
        //                                    arguments                                                  calledWith calledWithExactly
        return array(
            'Exact arguments'        => array(array('argumentA', 'argumentB', 'argumentC'),              true,      true),
            'First arguments'        => array(array('argumentA', 'argumentB'),                           true,      false),
            'Single argument'        => array(array('argumentA'),                                        true,      false),
            'Last arguments'         => array(array('argumentB', 'argumentC'),                           false,     false),
            'Last argument'          => array(array('argumentC'),                                        false,     false),
            'Extra arguments'        => array(array('argumentA', 'argumentB', 'argumentC', 'argumentD'), false,     false),
            'First argument differs' => array(array('argumentD', 'argumentB', 'argumentC'),              false,     false),
            'Last argument differs'  => array(array('argumentA', 'argumentB', 'argumentD'),              false,     false),
            'Unused argument'        => array(array('argumentD'),                                        false,     false),
        );
    }

    /**
     * @dataProvider calledWithData
     */
    public function testCalledWith(array $arguments, $calledWith, $calledWithExactly)
    {
        $matchers = $this->matcherFactory->adaptAll($arguments);

        $this->assertSame($calledWith, call_user_func_array(array($this->subject, 'calledWith'), $arguments));
        $this->assertSame($calledWith, call_user_func_array(array($this->subject, 'calledWith'), $matchers));
    }

    public function testCalledWithWithEmptyArguments()
    {
        $this->assertTrue($this->subject->calledWith());
    }

    public function testAssertCalledWith()
    {
        $this->assertNull($this->subject->assertCalledWith('argumentA', 'argumentB', 'argumentC'));
        $this->assertNull(
            $this->subject
                ->assertCalledWith($this->argumentMatchers[0], $this->argumentMatchers[1], $this->argumentMatchers[2])
        );
        $this->assertNull($this->subject->assertCalledWith('argumentA', 'argumentB'));
        $this->assertNull($this->subject->assertCalledWith($this->argumentMatchers[0], $this->argumentMatchers[1]));
        $this->assertNull($this->subject->assertCalledWith('argumentA'));
        $this->assertNull($this->subject->assertCalledWith($this->argumentMatchers[0]));
        $this->assertNull($this->subject->assertCalledWith());
        $this->assertSame(7, $this->assertionRecorder->successCount());
    }

    public function testAssertCalledWithFailure()
    {
        $expected = <<<'EOD'
Expected arguments to match:
    <'argumentB'>, <'argumentC'>, <any>*
The actual arguments were:
    'argumentA', 'argumentB', 'argumentC'
EOD;
        $this->setExpectedException('Eloquent\Phony\Assertion\Exception\AssertionException', $expected);
        $this->subject->assertCalledWith('argumentB', 'argumentC');
    }

    public function testAssertCalledWithFailureWithNoArguments()
    {
        $expected = <<<'EOD'
Expected arguments to match:
    <'argumentB'>, <'argumentC'>, <any>*
The actual arguments were:
    <none>
EOD;
        $this->setExpectedException('Eloquent\Phony\Assertion\Exception\AssertionException', $expected);
        $this->subjectNoArguments->assertCalledWith('argumentB', 'argumentC');
    }

    /**
     * @dataProvider calledWithData
     */
    public function testCalledWithExactly(array $arguments, $calledWith, $calledWithExactly)
    {
        $matchers = $this->matcherFactory->adaptAll($arguments);

        $this->assertSame(
            $calledWithExactly,
            call_user_func_array(array($this->subject, 'calledWithExactly'), $arguments)
        );
        $this->assertSame(
            $calledWithExactly,
            call_user_func_array(array($this->subject, 'calledWithExactly'), $matchers)
        );
    }

    public function testCalledWithWithExactlyEmptyArguments()
    {
        $this->assertFalse($this->subject->calledWithExactly());
    }

    public function testAssertCalledWithExactly()
    {
        $this->assertNull($this->subject->assertCalledWithExactly('argumentA', 'argumentB', 'argumentC'));
        $this->assertNull(
            $this->subject
                ->assertCalledWithExactly($this->argumentMatchers[0], $this->argumentMatchers[1], $this->argumentMatchers[2])
        );
        $this->assertSame(2, $this->assertionRecorder->successCount());
    }

    public function testAssertCalledWithExactlyFailure()
    {
        $expected = <<<'EOD'
Expected arguments to match:
    <'argumentA'>, <'argumentB'>
The actual arguments were:
    'argumentA', 'argumentB', 'argumentC'
EOD;
        $this->setExpectedException('Eloquent\Phony\Assertion\Exception\AssertionException', $expected);
        $this->subject->assertCalledWithExactly('argumentA', 'argumentB');
    }

    public function testAssertCalledWithExactlyFailureWithNoArguments()
    {
        $expected = <<<'EOD'
Expected arguments to match:
    <'argumentA'>, <'argumentB'>
The actual arguments were:
    <none>
EOD;
        $this->setExpectedException('Eloquent\Phony\Assertion\Exception\AssertionException', $expected);
        $this->subjectNoArguments->assertCalledWithExactly('argumentA', 'argumentB');
    }

    /**
     * @dataProvider calledWithData
     */
    public function testNotCalledWith(array $arguments, $calledWith, $calledWithExactly)
    {
        $matchers = $this->matcherFactory->adaptAll($arguments);

        $this->assertSame(!$calledWith, call_user_func_array(array($this->subject, 'notCalledWith'), $arguments));
        $this->assertSame(!$calledWith, call_user_func_array(array($this->subject, 'notCalledWith'), $matchers));
    }

    public function testNotCalledWithWithEmptyArguments()
    {
        $this->assertFalse($this->subject->notCalledWith());
    }

    public function testAssertNotCalledWith()
    {
        $this->assertNull($this->subject->assertNotCalledWith('argumentB', 'argumentC'));
        $this->assertNull($this->subject->assertNotCalledWith($this->argumentMatchers[1], $this->argumentMatchers[2]));
        $this->assertNull($this->subject->assertNotCalledWith('argumentC'));
        $this->assertNull($this->subject->assertNotCalledWith($this->argumentMatchers[2]));
        $this->assertNull($this->subject->assertNotCalledWith('argumentA', 'argumentB', 'argumentC', 'argumentD'));
        $this->assertNull(
            $this->subject->assertNotCalledWith(
                $this->argumentMatchers[0],
                $this->argumentMatchers[1],
                $this->argumentMatchers[2],
                $this->matcherFactory->adapt('argumentD')
            )
        );
        $this->assertNull($this->subject->assertNotCalledWith('argumentD', 'argumentB', 'argumentC'));
        $this->assertNull(
            $this->subject->assertNotCalledWith(
                $this->matcherFactory->adapt('argumentD'),
                $this->argumentMatchers[1],
                $this->argumentMatchers[2]
            )
        );
        $this->assertNull($this->subject->assertNotCalledWith('argumentA', 'argumentB', 'argumentD'));
        $this->assertNull(
            $this->subject->assertNotCalledWith(
                $this->argumentMatchers[0],
                $this->argumentMatchers[1],
                $this->matcherFactory->adapt('argumentD')
            )
        );
        $this->assertNull($this->subject->assertNotCalledWith('argumentD'));
        $this->assertNull($this->subject->assertNotCalledWith($this->matcherFactory->adapt('argumentD')));
        $this->assertSame(12, $this->assertionRecorder->successCount());
    }

    public function testAssertNotCalledWithFailure()
    {
        $expected = <<<'EOD'
Expected arguments not to match:
    <'argumentA'>, <'argumentB'>, <any>*
The actual arguments were:
    'argumentA', 'argumentB', 'argumentC'
EOD;
        $this->setExpectedException('Eloquent\Phony\Assertion\Exception\AssertionException', $expected);
        $this->subject->assertNotCalledWith('argumentA', 'argumentB');
    }

    public function testAssertNotCalledWithFailureWithNoArguments()
    {
        $expected = <<<'EOD'
Expected arguments not to match:
    <any>*
The actual arguments were:
    <none>
EOD;
        $this->setExpectedException('Eloquent\Phony\Assertion\Exception\AssertionException', $expected);
        $this->subjectNoArguments->assertNotCalledWith();
    }

    /**
     * @dataProvider calledWithData
     */
    public function testNotCalledWithExactly(array $arguments, $calledWith, $calledWithExactly)
    {
        $matchers = $this->matcherFactory->adaptAll($arguments);

        $this->assertSame(
            !$calledWithExactly,
            call_user_func_array(array($this->subject, 'notCalledWithExactly'), $arguments)
        );
        $this->assertSame(
            !$calledWithExactly,
            call_user_func_array(array($this->subject, 'notCalledWithExactly'), $matchers)
        );
    }

    public function testNotCalledWithExactlyWithEmptyArguments()
    {
        $this->assertTrue($this->subject->notCalledWithExactly());
    }

    public function testAssertNotCalledWithExactly()
    {
        $this->assertNull($this->subject->assertNotCalledWithExactly('argumentA', 'argumentB'));
        $this->assertNull($this->subject->assertNotCalledWithExactly($this->argumentMatchers[0], $this->argumentMatchers[1]));
        $this->assertNull($this->subject->assertNotCalledWithExactly('argumentA'));
        $this->assertNull($this->subject->assertNotCalledWithExactly($this->argumentMatchers[0]));
        $this->assertNull($this->subject->assertNotCalledWithExactly('argumentB', 'argumentC'));
        $this->assertNull($this->subject->assertNotCalledWithExactly($this->argumentMatchers[1], $this->argumentMatchers[2]));
        $this->assertNull($this->subject->assertNotCalledWithExactly('argumentC'));
        $this->assertNull($this->subject->assertNotCalledWithExactly($this->argumentMatchers[2]));
        $this->assertNull($this->subject->assertNotCalledWithExactly('argumentA', 'argumentB', 'argumentC', 'argumentD'));
        $this->assertNull(
            $this->subject->assertNotCalledWithExactly(
                $this->argumentMatchers[0],
                $this->argumentMatchers[1],
                $this->argumentMatchers[2],
                $this->matcherFactory->adapt('argumentD')
            )
        );
        $this->assertNull($this->subject->assertNotCalledWithExactly('argumentD', 'argumentB', 'argumentC'));
        $this->assertNull(
            $this->subject->assertNotCalledWithExactly(
                $this->matcherFactory->adapt('argumentD'),
                $this->argumentMatchers[1],
                $this->argumentMatchers[2]
            )
        );
        $this->assertNull($this->subject->assertNotCalledWithExactly('argumentA', 'argumentB', 'argumentD'));
        $this->assertNull(
            $this->subject->assertNotCalledWithExactly(
                $this->argumentMatchers[0],
                $this->argumentMatchers[1],
                $this->matcherFactory->adapt('argumentD')
            )
        );
        $this->assertNull($this->subject->assertNotCalledWithExactly('argumentD'));
        $this->assertNull($this->subject->assertNotCalledWithExactly($this->matcherFactory->adapt('argumentD')));
        $this->assertSame(16, $this->assertionRecorder->successCount());
    }

    public function testAssertNotCalledWithExactlyFailure()
    {
        $expected = <<<'EOD'
Expected arguments not to match:
    <'argumentA'>, <'argumentB'>, <'argumentC'>
The actual arguments were:
    'argumentA', 'argumentB', 'argumentC'
EOD;
        $this->setExpectedException('Eloquent\Phony\Assertion\Exception\AssertionException', $expected);
        $this->subject->assertNotCalledWithExactly('argumentA', 'argumentB', 'argumentC');
    }

    public function testAssertNotCalledWithExactlyFailureWithNoArguments()
    {
        $expected = <<<'EOD'
Expected arguments not to match:
    <none>
The actual arguments were:
    <none>
EOD;
        $this->setExpectedException('Eloquent\Phony\Assertion\Exception\AssertionException', $expected);
        $this->subjectNoArguments->assertNotCalledWithExactly();
    }

    public function testCalledBefore()
    {
        $this->assertTrue($this->subject->calledBefore($this->lateCall));
        $this->assertFalse($this->subject->calledBefore($this->earlyCall));
    }

    public function testAssertCalledBefore()
    {
        $this->assertNull($this->subject->assertCalledBefore($this->lateCall));
        $this->assertSame(1, $this->assertionRecorder->successCount());
    }

    public function testAssertCalledBeforeFailure()
    {
        $this->setExpectedException(
            'Eloquent\Phony\Assertion\Exception\AssertionException',
            "The call was not made before the supplied call."
        );
        $this->subject->assertCalledBefore($this->earlyCall);
    }

    public function testCalledAfter()
    {
        $this->assertTrue($this->subject->calledAfter($this->earlyCall));
        $this->assertFalse($this->subject->calledAfter($this->lateCall));
    }

    public function testAssertCalledAfter()
    {
        $this->assertNull($this->subject->assertCalledAfter($this->earlyCall));
        $this->assertSame(1, $this->assertionRecorder->successCount());
    }

    public function testAssertCalledAfterFailure()
    {
        $this->setExpectedException(
            'Eloquent\Phony\Assertion\Exception\AssertionException',
            "The call was not made after the supplied call."
        );
        $this->subject->assertCalledAfter($this->lateCall);
    }

    public function testCalledOn()
    {
        $this->assertTrue($this->subject->calledOn($this->thisValue));
        $this->assertTrue($this->subject->calledOn($this->identicalTo($this->thisValue)));
        $this->assertFalse($this->subject->calledOn((object) array('property' => 'value')));
    }

    public function testAssertCalledOn()
    {
        $this->assertNull($this->subject->assertCalledOn($this->thisValue));
        $this->assertNull($this->subject->assertCalledOn($this->identicalTo($this->thisValue)));
        $this->assertSame(2, $this->assertionRecorder->successCount());
    }

    public function testAssertCalledOnFailure()
    {
        $this->setExpectedException(
            'Eloquent\Phony\Assertion\Exception\AssertionException',
            "The call was not made on the expected object. The actual object was stdClass Object ()."
        );
        $this->subject->assertCalledOn((object) array());
    }

    public function testAssertCalledOnFailureWithMatcher()
    {
        $this->setExpectedException(
            'Eloquent\Phony\Assertion\Exception\AssertionException',
            "The call was not made on an object that matches <is identical to an object of class \"stdClass\">. " .
                "The actual object was stdClass Object ()."
        );
        $this->subject->assertCalledOn($this->identicalTo((object) array()));
    }

    public function testReturned()
    {
        $this->assertTrue($this->subject->returned($this->returnValue));
        $this->assertTrue($this->subject->returned($this->matcherFactory->adapt($this->returnValue)));
        $this->assertFalse($this->subject->returned('anotherValue'));
        $this->assertFalse($this->subject->returned($this->matcherFactory->adapt('anotherValue')));
    }

    public function testAssertReturned()
    {
        $this->assertNull($this->subject->assertReturned($this->returnValue));
        $this->assertNull($this->subject->assertReturned($this->matcherFactory->adapt($this->returnValue)));
        $this->assertSame(2, $this->assertionRecorder->successCount());
    }

    public function testAssertReturnedFailure()
    {
        $this->setExpectedException(
            'Eloquent\Phony\Assertion\Exception\AssertionException',
            "The return value did not match <'value'>. The actual return value was 'returnValue'."
        );
        $this->subject->assertReturned('value');
    }

    public function testThrew()
    {
        $this->assertTrue($this->subject->threw());
        $this->assertTrue($this->subject->threw('Exception'));
        $this->assertTrue($this->subject->threw('RuntimeException'));
        $this->assertTrue($this->subject->threw($this->exception));
        $this->assertTrue($this->subject->threw($this->identicalTo($this->exception)));
        $this->assertFalse($this->subject->threw('InvalidArgumentException'));
        $this->assertFalse($this->subject->threw(new Exception()));
        $this->assertFalse($this->subject->threw(new RuntimeException()));
        $this->assertFalse($this->subject->threw($this->identicalTo(new RuntimeException('You done goofed.'))));
        $this->assertFalse($this->subject->threw($this->isNull()));
        $this->assertFalse($this->subject->threw(111));

        $this->assertFalse($this->subjectNoException->threw());
        $this->assertFalse($this->subjectNoException->threw('Exception'));
        $this->assertFalse($this->subjectNoException->threw('RuntimeException'));
        $this->assertFalse($this->subjectNoException->threw($this->exception));
        $this->assertFalse($this->subjectNoException->threw($this->identicalTo($this->exception)));
        $this->assertFalse($this->subjectNoException->threw('InvalidArgumentException'));
        $this->assertFalse($this->subjectNoException->threw(new Exception()));
        $this->assertFalse($this->subjectNoException->threw(new RuntimeException()));
        $this->assertFalse($this->subjectNoException->threw($this->identicalTo(new RuntimeException('You done goofed.'))));
        $this->assertTrue($this->subjectNoException->threw($this->isNull()));
        $this->assertFalse($this->subjectNoException->threw(111));
    }

    public function testAssertThrew()
    {
        $this->assertNull($this->subject->assertThrew());
        $this->assertNull($this->subject->assertThrew('Exception'));
        $this->assertNull($this->subject->assertThrew('RuntimeException'));
        $this->assertNull($this->subject->assertThrew($this->exception));
        $this->assertNull($this->subject->assertThrew($this->identicalTo($this->exception)));
        $this->assertSame(5, $this->assertionRecorder->successCount());
    }

    public function testAssertThrewFailureExpectingAnyNoneThrown()
    {
        $this->setExpectedException(
            'Eloquent\Phony\Assertion\Exception\AssertionException',
            "Expected an exception, but no exception was thrown."
        );
        $this->subjectNoException->assertThrew();
    }

    public function testAssertThrewFailureTypeMismatch()
    {
        $this->setExpectedException(
            'Eloquent\Phony\Assertion\Exception\AssertionException',
            "Expected an exception of type 'InvalidArgumentException'. " .
                "The actual exception was RuntimeException('You done goofed.')."
        );
        $this->subject->assertThrew('InvalidArgumentException');
    }

    public function testAssertThrewFailureExpectingTypeNoneThrown()
    {
        $this->setExpectedException(
            'Eloquent\Phony\Assertion\Exception\AssertionException',
            "Expected an exception of type 'InvalidArgumentException', but no exception was thrown."
        );
        $this->subjectNoException->assertThrew('InvalidArgumentException');
    }

    public function testAssertThrewFailureExceptionMismatch()
    {
        $this->setExpectedException(
            'Eloquent\Phony\Assertion\Exception\AssertionException',
            "Expected an exception equal to RuntimeException(). " .
                "The actual exception was RuntimeException('You done goofed.')."
        );
        $this->subject->assertThrew(new RuntimeException());
    }

    public function testAssertThrewFailureExpectingExceptionNoneThrown()
    {
        $this->setExpectedException(
            'Eloquent\Phony\Assertion\Exception\AssertionException',
            "Expected an exception equal to RuntimeException(), but no exception was thrown."
        );
        $this->subjectNoException->assertThrew(new RuntimeException());
    }

    public function testAssertThrewFailureMatcherMismatch()
    {
        $this->setExpectedException(
            'Eloquent\Phony\Assertion\Exception\AssertionException',
            "Expected an exception matching <is identical to an object of class \"RuntimeException\">. " .
                "The actual exception was RuntimeException('You done goofed.')."
        );
        $this->subject->assertThrew($this->identicalTo(new RuntimeException('You done goofed.')));
    }

    public function testAssertThrewFailureInvalidInput()
    {
        $this->setExpectedException(
            'Eloquent\Phony\Assertion\Exception\AssertionException',
            "Unable to match exceptions against stdClass Object ()."
        );
        $this->subject->assertThrew((object) array());
    }
}
