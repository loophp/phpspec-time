<?php

declare(strict_types=1);

namespace spec\loophp\phpspectime\Matcher;

use loophp\phpspectime\Matcher\TakeLessThanMatcher;
use PhpSpec\Exception\Example\MatcherException;
use PhpSpec\Exception\Fracture\MethodNotFoundException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Wrapper\Unwrapper;
use Prophecy\Argument;
use Ubench;

class TakeLessThanMatcherSpec extends AbstractTakeThanMatcherSpec
{
    public function it_can_checks_if_matcher_supports_provided_subject_and_matcher_name(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->supports('takeLessThan', 'bar', [3])
            ->shouldReturn(true);

        $this
            ->supports('lastLessThan', 'bar', [3])
            ->shouldReturn(true);

        $this
            ->supports('lastLessThan', 'bar', [3, 5])
            ->shouldReturn(false);

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

    public function it_is_initializable(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->shouldHaveType(TakeLessThanMatcher::class);
    }

    // Inverted now

    public function it_returns_true_when_a_call_is_not_shorter_than_expected(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $expected = [10];
        $given = 20.0;

        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $this->configureMockWithParameters($expected, $given, $presenter, $unwrapper, $bench);

        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->negativeMatch('foo', $subject, $expected)()
            ->shouldReturn(true);
    }

    public function it_returns_true_when_a_call_is_shorter_than_expected(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $expected = [10];
        $given = 5.0;

        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $this->configureMockWithParameters($expected, $given, $presenter, $unwrapper, $bench);

        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->positiveMatch('foo', $subject, $expected)()
            ->shouldReturn(true);
    }

    public function it_throws_when_a_call_is_not_shorter_than_expected(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $expected = [20];
        $given = 10.0;

        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $this->configureMockWithParameters($expected, $given, $presenter, $unwrapper, $bench);

        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->negativeMatch('foo', $subject, $expected)
            ->shouldThrow(MatcherException::class)
            ->during('__invoke');
    }

    public function it_throws_when_a_call_is_shorter_than_expected(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $expected = [10];
        $given = 20.0;

        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $this->configureMockWithParameters($expected, $given, $presenter, $unwrapper, $bench);

        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->positiveMatch('foo', $subject, $expected)
            ->shouldThrow(MatcherException::class)
            ->during('__invoke');
    }

    public function it_throws_when_method_is_not_found(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $expected = [10];
        $given = 20.0;

        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $this->configureMockWithParameters($expected, $given, $presenter, $unwrapper, $bench);

        $unwrapper
            ->unwrapAll(Argument::any())
            ->willReturn(['plop', [$expected]]);

        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->positiveMatch('plop', $subject, [10])
            ->shouldThrow(MethodNotFoundException::class)
            ->during('__invoke');
    }

    public function it_throws_when_parameters_are_wrong(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $expected = ['foo'];
        $given = 20.0;

        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $this->configureMockWithParameters($expected, $given, $presenter, $unwrapper, $bench);

        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->shouldThrow(MatcherException::class)
            ->during('positiveMatch', ['foo', $subject, [$expected]]);
    }

    public function let(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);
    }
}
