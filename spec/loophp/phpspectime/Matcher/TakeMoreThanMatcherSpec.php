<?php

declare(strict_types=1);

namespace spec\loophp\phpspectime\Matcher;

use loophp\phpspectime\Matcher\TakeMoreThanMatcher;
use PhpSpec\Exception\Example\MatcherException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Wrapper\Unwrapper;
use Ubench;

class TakeMoreThanMatcherSpec extends AbstractTakeThanMatcherSpec
{
    public function it_can_checks_if_matcher_supports_provided_subject_and_matcher_name(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->supports('takeMoreThan', 'bar', [3])
            ->shouldReturn(true);

        $this
            ->supports('lastMoreThan', 'bar', [3])
            ->shouldReturn(true);

        $this
            ->supports('lastMoreThan', 'bar', [3, 5])
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

    public function it_detect_when_a_call_is_longer_than_expected(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $expected = [1];
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
            ->positiveMatch('foo', $subject, $expected)()
            ->shouldReturn(true);
    }

    // Inverted now

    public function it_detect_when_a_call_is_not_longer_than_expected(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $expected = [1];
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

    public function it_detect_when_a_call_is_not_shorter_than_expected(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
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
            ->negativeMatch('foo', $subject, $expected)()
            ->shouldReturn(true);
    }

    public function it_detect_when_a_call_is_shorter_than_expected(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
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
            ->positiveMatch('foo', $subject, $expected)
            ->shouldThrow(MatcherException::class)
            ->during('__invoke');
    }

    public function it_is_initializable(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);

        $this
            ->shouldHaveType(TakeMoreThanMatcher::class);
    }

    public function let(Presenter $presenter, Unwrapper $unwrapper, Ubench $bench)
    {
        $this
            ->beConstructedWith($unwrapper, $presenter, $bench);
    }
}
