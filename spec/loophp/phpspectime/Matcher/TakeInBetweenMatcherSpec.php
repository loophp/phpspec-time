<?php

declare(strict_types=1);

namespace spec\loophp\phpspectime\Matcher;

use loophp\nanobench\BenchmarkFactoryInterface;
use loophp\nanobench\BenchmarkInterface;
use loophp\nanobench\Time\TimeUnit;
use loophp\phpspectime\Matcher\TakeInBetweenMatcher;
use PhpSpec\Exception\Example\MatcherException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Wrapper\Unwrapper;

class TakeInBetweenMatcherSpec extends AbstractTakeThanMatcherSpec
{
    public function it_can_checks_if_matcher_supports_provided_subject_and_matcher_name()
    {
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

    public function it_detect_when_a_call_is_not_within_the_defined_timespan(Presenter $presenter, Unwrapper $unwrapper, BenchmarkFactoryInterface $benchmarkFactory, BenchmarkInterface $benchmark)
    {
        $expected = [5.0, 15.0];
        $given = 20.0;

        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $unit = TimeUnit::SECOND;

        $this->configureMockWithParameters($expected, $given, $presenter, $unwrapper, $benchmarkFactory, $benchmark, $unit);

        $this
            ->beConstructedWith($unwrapper, $presenter, $benchmarkFactory, ['timeunit' => $unit]);

        $this
            ->negativeMatch('foo', $subject, $expected)()
            ->shouldReturn(true);
    }

    public function it_detect_when_a_call_within_the_defined_timespan(Presenter $presenter, Unwrapper $unwrapper, BenchmarkFactoryInterface $benchmarkFactory, BenchmarkInterface $benchmark)
    {
        $expected = [5.0, 15.0];
        $given = 10.0;

        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $unit = TimeUnit::SECOND;

        $this->configureMockWithParameters($expected, $given, $presenter, $unwrapper, $benchmarkFactory, $benchmark, $unit);

        $this
            ->beConstructedWith($unwrapper, $presenter, $benchmarkFactory, ['timeunit' => $unit]);

        $this
            ->positiveMatch('foo', $subject, $expected)()
            ->shouldReturn(true);
    }

    public function it_is_initializable()
    {
        $this
            ->shouldHaveType(TakeInBetweenMatcher::class);
    }

    public function it_throws_when_a_call_is_not_within_the_defined_timespan(Presenter $presenter, Unwrapper $unwrapper, BenchmarkFactoryInterface $benchmarkFactory, BenchmarkInterface $benchmark)
    {
        $expected = [5.0, 15.0];
        $given = 10.0;

        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $unit = TimeUnit::SECOND;

        $this->configureMockWithParameters($expected, $given, $presenter, $unwrapper, $benchmarkFactory, $benchmark, $unit);

        $this
            ->beConstructedWith($unwrapper, $presenter, $benchmarkFactory, ['timeunit' => $unit]);

        $this
            ->negativeMatch('foo', $subject, $expected)
            ->shouldThrow(MatcherException::class)
            ->during('__invoke');
    }

    public function it_throws_when_a_call_within_the_defined_timespan(Presenter $presenter, Unwrapper $unwrapper, BenchmarkFactoryInterface $benchmarkFactory, BenchmarkInterface $benchmark)
    {
        $expected = [5.0, 15.0];
        $given = 20.0;

        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $unit = TimeUnit::SECOND;

        $this->configureMockWithParameters($expected, $given, $presenter, $unwrapper, $benchmarkFactory, $benchmark, $unit);

        $this
            ->beConstructedWith($unwrapper, $presenter, $benchmarkFactory, ['timeunit' => $unit]);

        $this
            ->positiveMatch('foo', $subject, $expected)
            ->shouldThrow(MatcherException::class)
            ->during('__invoke');
    }

    public function it_throws_when_parameters_are_wrong(Presenter $presenter, Unwrapper $unwrapper, BenchmarkFactoryInterface $benchmarkFactory, BenchmarkInterface $benchmark)
    {
        // Inverted parameters.
        $expected = [15.0, 5.0];
        $given = 20.0;

        $subject = new class() {
            public function foo()
            {
                return 'bar';
            }
        };

        $unit = TimeUnit::SECOND;

        $this->configureMockWithParameters($expected, $given, $presenter, $unwrapper, $benchmarkFactory, $benchmark, $unit);

        $this
            ->beConstructedWith($unwrapper, $presenter, $benchmarkFactory, ['timeunit' => $unit]);

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

    public function let(Presenter $presenter, Unwrapper $unwrapper, BenchmarkFactoryInterface $benchmarkFactory)
    {
        $this
            ->beConstructedWith($unwrapper, $presenter, $benchmarkFactory, ['timeunit' => TimeUnit::SECOND]);
    }
}
