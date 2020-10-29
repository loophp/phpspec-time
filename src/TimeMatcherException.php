<?php

declare(strict_types=1);

namespace loophp\phpspectime;

use PhpSpec\Exception\Example\MatcherException;
use PhpSpec\Formatter\Presenter\Presenter;

final class TimeMatcherException
{
    public static function notInRangeMatcherException(Presenter $presenter, $result, $from, $to): MatcherException
    {
        return new MatcherException(
            sprintf(
                "Method call not in the expected timespan.\n" .
                "From %s to %s second(s) expected,\n" .
                'Got %s.',
                $presenter->presentValue($from),
                $presenter->presentValue($to),
                $presenter->presentValue($result)
            )
        );
    }

    public static function tooFastMatcherException(Presenter $presenter, $result, float $expected): MatcherException
    {
        return new MatcherException(
            sprintf(
                "Method call too fast to complete.\n" .
                "%s second(s) expected,\n" .
                'Got %s.',
                $presenter->presentValue($expected),
                $presenter->presentValue($result)
            )
        );
    }

    public static function tooSlowMatcherException(Presenter $presenter, $result, float $expected): MatcherException
    {
        return new MatcherException(
            sprintf(
                "Method call too slow to complete.\n" .
                "%s second(s) expected,\n" .
                'Got %s.',
                $presenter->presentValue($expected),
                $presenter->presentValue($result)
            )
        );
    }
}
