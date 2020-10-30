<?php

declare(strict_types=1);

namespace spec\loophp\phpspectime\Matcher;

use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Unwrapper;
use Prophecy\Argument;
use Ubench;

abstract class AbstractTakeThanMatcherSpec extends ObjectBehavior
{
    protected function configureMockWithParameters($expected, $given, Presenter $presenter, Unwrapper $unwrapper, Ubench $bench): void
    {
        $bench
            ->start()
            ->willReturn(0);

        $bench
            ->end()
            ->willReturn($given);

        $bench
            ->getTime(true)
            ->willReturn($given);

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
