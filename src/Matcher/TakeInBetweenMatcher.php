<?php

declare(strict_types=1);

namespace loophp\phpspectime\Matcher;

use loophp\phpspectime\TimeMatcherException;
use PhpSpec\Exception\Example\MatcherException;

use function count;
use function in_array;

final class TakeInBetweenMatcher extends AbstractTakeThanMatcher
{
    protected $keywords = [
        'takeInBetween',
        'lastInBetween',
    ];

    /**
     * @psalm-suppress UndefinedDocblockClass
     *
     * @param mixed $subject
     */
    public function supports(string $name, $subject, array $arguments): bool
    {
        return in_array($name, $this->keywords, true) && 2 === count($arguments);
    }

    public function verifyNegative(callable $callable, array $arguments, array $parameters): bool
    {
        [$from, $to] = $parameters;

        $elapsedTime = $this->bench($callable, $arguments);

        if ($elapsedTime < $from || $elapsedTime > $to) {
            return true;
        }

        throw TimeMatcherException::notInRangeMatcherException(
            $this->presenter,
            $elapsedTime,
            $from,
            $to
        );
    }

    public function verifyPositive(callable $callable, array $arguments, array $parameters): bool
    {
        [$from, $to] = $parameters;

        $elapsedTime = $this->bench($callable, $arguments);

        if ($elapsedTime >= $from && $elapsedTime <= $to) {
            return true;
        }

        throw TimeMatcherException::notInRangeMatcherException(
            $this->presenter,
            $elapsedTime,
            $from,
            $to
        );
    }

    protected function getParameters(array $arguments): array
    {
        $from = current($arguments);
        $to = end($arguments);

        if (!is_numeric($from)) {
            throw new MatcherException(
                sprintf(
                    "Wrong 'from' argument provided in TakeInBetween matcher.\n" .
                    "Numeric value expected,\n" .
                    'Got %s.',
                    $this->presenter->presentValue($arguments[0])
                )
            );
        }

        if (!is_numeric($to)) {
            throw new MatcherException(
                sprintf(
                    "Wrong 'to' argument provided in TakeInBetween matcher.\n" .
                    "Numeric value expected,\n" .
                    'Got %s.',
                    $this->presenter->presentValue($arguments[0])
                )
            );
        }

        if ($to < $from) {
            throw new MatcherException(
                sprintf(
                    "Wrong argument provided in TakeInBetween matcher.\n" .
                    "First argument should be equal or greater to second argument.\n"
                )
            );
        }

        return [$from, $to];
    }
}
