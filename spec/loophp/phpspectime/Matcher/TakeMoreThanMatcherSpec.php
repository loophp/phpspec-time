<?php

declare(strict_types=1);

namespace spec\loophp\phpspectime\Matcher;

use loophp\nanobench\BenchmarkFactoryInterface;
use loophp\nanobench\BenchmarkInterface;
use loophp\nanobench\Time\TimeUnit;
use loophp\phpspectime\Matcher\TakeMoreThanMatcher;
use PhpSpec\Exception\Example\MatcherException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Wrapper\Unwrapper;

class TakeMoreThanMatcherSpec extends AbstractTakeThanMatcherSpec
{
    public function it_can_checks_if_matcher_supports_provided_subject_and_matcher_name()
    {
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

    public function it_detect_when_a_call_is_longer_than_expected(Presenter $presenter, Unwrapper $unwrapper, BenchmarkFactoryInterface $benchmarkFactory, BenchmarkInterface $benchmark)
    {
        $expected = [1];
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

    // Inverted now

    public function it_detect_when_a_call_is_not_longer_than_expected(Presenter $presenter, Unwrapper $unwrapper, BenchmarkFactoryInterface $benchmarkFactory, BenchmarkInterface $benchmark)
    {
        $expected = [1];
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

    public function it_detect_when_a_call_is_not_shorter_than_expected(Presenter $presenter, Unwrapper $unwrapper, BenchmarkFactoryInterface $benchmarkFactory, BenchmarkInterface $benchmark)
    {
        $expected = [20];
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
            ->negativeMatch('foo', $subject, $expected)()
            ->shouldReturn(true);
    }

    public function it_detect_when_a_call_is_shorter_than_expected(Presenter $presenter, Unwrapper $unwrapper, BenchmarkFactoryInterface $benchmarkFactory, BenchmarkInterface $benchmark)
    {
        $expected = [20];
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
            ->positiveMatch('foo', $subject, $expected)
            ->shouldThrow(MatcherException::class)
            ->during('__invoke');
    }

    public function it_is_initializable()
    {
        $this
            ->shouldHaveType(TakeMoreThanMatcher::class);
    }

    public function let(Presenter $presenter, Unwrapper $unwrapper, BenchmarkFactoryInterface $benchmarkFactory)
    {
        $this
            ->beConstructedWith($unwrapper, $presenter, $benchmarkFactory, ['timeunit' => TimeUnit::SECOND]);
    }
}
