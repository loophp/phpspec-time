<?php

declare(strict_types=1);

namespace loophp\phpspectime\Matcher;

use loophp\phpspectime\TimeMatcherException;

final class TakeMoreThanMatcher extends AbstractTakeThanMatcher
{
    protected $keywords = [
        'takeMoreThan',
        'lastMoreThan',
    ];

    public function verifyNegative(callable $callable, array $arguments, float $timeInSeconds): bool
    {
        $elapsedTime = $this->bench($callable, $arguments);

        if (false === $timeInSeconds <= $elapsedTime) {
            return true;
        }

        throw TimeMatcherException::tooSlowMatcherException(
            $this->presenter,
            $elapsedTime,
            $timeInSeconds
        );
    }

    public function verifyPositive(callable $callable, array $arguments, float $timeInSeconds): bool
    {
        $elapsedTime = $this->bench($callable, $arguments);

        if (false === $timeInSeconds > $elapsedTime) {
            return true;
        }

        throw TimeMatcherException::tooFastMatcherException(
            $this->presenter,
            $elapsedTime,
            $timeInSeconds
        );
    }
}
