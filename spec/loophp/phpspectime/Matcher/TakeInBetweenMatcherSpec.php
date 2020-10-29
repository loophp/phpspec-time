<?php

declare(strict_types=1);

namespace spec\loophp\phpspectime\Matcher;

use loophp\phpspectime\Matcher\TakeInBetweenMatcher;
use PhpSpec\Exception\Example\MatcherException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Unwrapper;
use Prophecy\Argument;
use Ubench;

class TakeInBetweenMatcherSpec extends ObjectBehavior
{
    public function it_can_checks_if_matcher_supports_provided_subject_and_matcher_name(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->supports('takeInBetween', 'bar', [3])
            ->shouldReturn(false);

        $this
            ->supports('takeInBetween', 'bar', [3, 9])
            ->shouldReturn(true);

        $this
            ->supports('foo', 'bar', [3])
            ->shouldReturn(false);
    }

    public function it_can_get_priority()
    {
        $this
            ->getPriority()
            ->shouldReturn(1);
    }

    // Inverted

    public function it_detect_when_a_call_is_not_within_the_defined_timespan(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $expected = [5.0, 15.0];
        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $bench
            ->start()
            ->willReturn(0);

        $bench
            ->end()
            ->willReturn(10);

        $bench
            ->getTime(true)
            ->willReturn(20.0);

        $unwrapper
            ->unwrapAll(Argument::any())
            ->willReturn(['foo', [$expected]]);

        $presenter
            ->presentValue(20.0)
            ->willReturn(20.0);

        $presenter
            ->presentValue(5.0)
            ->willReturn(5.0);

        $presenter
            ->presentValue(15.0)
            ->willReturn(15.0);

        $presenter
            ->presentValue(Argument::cetera())
            ->willReturn(Argument::cetera());

        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->negativeMatch('foo', $subject, $expected)()
            ->shouldReturn(true);
    }

    public function it_detect_when_a_call_within_the_defined_timespan(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $expected = [5.0, 15.0];
        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $bench
            ->start()
            ->willReturn(0);

        $bench
            ->end()
            ->willReturn(10);

        $bench
            ->getTime(true)
            ->willReturn(10.0);

        $unwrapper
            ->unwrapAll(Argument::any())
            ->willReturn(['foo', [$expected]]);

        $presenter
            ->presentValue(10.0)
            ->willReturn(10.0);

        $presenter
            ->presentValue(5.0)
            ->willReturn(5.0);

        $presenter
            ->presentValue(15.0)
            ->willReturn(15.0);

        $presenter
            ->presentValue(Argument::cetera())
            ->willReturn(Argument::cetera());

        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->positiveMatch('foo', $subject, $expected)()
            ->shouldReturn(true);
    }

    public function it_is_initializable(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->shouldHaveType(TakeInBetweenMatcher::class);
    }

    public function it_throws_when_a_call_is_not_within_the_defined_timespan(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $expected = [5.0, 15.0];
        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $bench
            ->start()
            ->willReturn(0);

        $bench
            ->end()
            ->willReturn(10);

        $bench
            ->getTime(true)
            ->willReturn(10.0);

        $unwrapper
            ->unwrapAll(Argument::any())
            ->willReturn(['foo', [$expected]]);

        $presenter
            ->presentValue(10.0)
            ->willReturn(10.0);

        $presenter
            ->presentValue(5.0)
            ->willReturn(5.0);

        $presenter
            ->presentValue(15.0)
            ->willReturn(15.0);

        $presenter
            ->presentValue(Argument::cetera())
            ->willReturn(Argument::cetera());

        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->negativeMatch('foo', $subject, $expected)
            ->shouldThrow(MatcherException::class)
            ->during('__invoke');
    }

    public function it_throws_when_a_call_within_the_defined_timespan(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $expected = [5.0, 15.0];
        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $bench
            ->start()
            ->willReturn(0);

        $bench
            ->end()
            ->willReturn(20);

        $bench
            ->getTime(true)
            ->willReturn(20.0);

        $unwrapper
            ->unwrapAll(Argument::any())
            ->willReturn(['foo', [$expected]]);

        $presenter
            ->presentValue(10.0)
            ->willReturn(20.0);

        $presenter
            ->presentValue(5.0)
            ->willReturn(5.0);

        $presenter
            ->presentValue(15.0)
            ->willReturn(15.0);

        $presenter
            ->presentValue(Argument::cetera())
            ->willReturn(Argument::cetera());

        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->positiveMatch('foo', $subject, $expected)
            ->shouldThrow(MatcherException::class)
            ->during('__invoke');
    }

    public function it_throws_when_parameters_are_wrong(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        // Inverted parameters.
        $expected = [15.0, 5.0];
        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $bench
            ->start()
            ->willReturn(0);

        $bench
            ->end()
            ->willReturn(20);

        $bench
            ->getTime(true)
            ->willReturn(20.0);

        $unwrapper
            ->unwrapAll(Argument::any())
            ->willReturn(['foo', [$expected]]);

        $presenter
            ->presentValue(10.0)
            ->willReturn(20.0);

        $presenter
            ->presentValue(5.0)
            ->willReturn(5.0);

        $presenter
            ->presentValue(15.0)
            ->willReturn(15.0);

        $presenter
            ->presentValue(Argument::cetera())
            ->willReturn(Argument::cetera());

        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->shouldThrow(MatcherException::class)
            ->during('positiveMatch', ['foo', $subject, $expected]);

        $expected = ['foo', 5.0];

        $this
            ->shouldThrow(MatcherException::class)
            ->during('positiveMatch', ['foo', $subject, $expected]);

        $expected = [15.0, 'bar'];

        $this
            ->shouldThrow(MatcherException::class)
            ->during('positiveMatch', ['foo', $subject, $expected]);
    }

    public function let(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);
    }
}
