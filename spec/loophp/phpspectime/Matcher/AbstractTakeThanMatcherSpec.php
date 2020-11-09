<?php

declare(strict_types=1);

namespace spec\loophp\phpspectime\Matcher;

use loophp\nanobench\Time\Duration;
use loophp\nanobench\Time\Time;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

abstract class AbstractTakeThanMatcherSpec extends ObjectBehavior
{
    protected function configureMockWithParameters($expected, $given, $presenter, $unwrapper, $benchmarkFactory, $benchmark, string $unit): void
    {
        $duration = new Duration(new Time(0, $unit), new Time($given, $unit), $unit);

        $benchmarkFactory
            ->fromCallable(Argument::cetera(), Argument::cetera())
            ->willReturn($benchmark);

        $benchmark
            ->run()
            ->willReturn($benchmark);

        $benchmark
            ->getDuration()
            ->willReturn($duration);

        $unwrapper
            ->unwrapAll(Argument::any())
            ->willReturn(['foo', $expected]);

        foreach ($expected as $value) {
            $presenter
                ->presentValue($value)
                ->willReturn($value);
        }

        $presenter
            ->presentValue($given)
            ->willReturn($given);

        $presenter
            ->presentValue(Argument::cetera())
            ->willReturn(Argument::cetera());
    }
}
