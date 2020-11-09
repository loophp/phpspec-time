<?php

declare(strict_types=1);

namespace loophp\phpspectime\Matcher;

use loophp\nanobench\BenchmarkFactoryInterface;
use PhpSpec\Exception\Example\MatcherException;
use PhpSpec\Exception\Fracture\MethodNotFoundException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Matcher\Matcher;
use PhpSpec\Wrapper\DelayedCall;
use PhpSpec\Wrapper\Unwrapper;

use function call_user_func;
use function count;
use function get_class;
use function in_array;

abstract class AbstractTakeThanMatcher implements Matcher
{
    /**
     * @var BenchmarkFactoryInterface
     */
    protected $benchmarkFactory;

    protected $keywords;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var \PhpSpec\Formatter\Presenter\Presenter
     */
    protected $presenter;

    /**
     * @var \PhpSpec\Wrapper\Unwrapper
     */
    protected $unwrapper;

    public function __construct(
        Unwrapper $unwrapper,
        Presenter $presenter,
        BenchmarkFactoryInterface $benchmarkFactory,
        array $params
    ) {
        $this->unwrapper = $unwrapper;
        $this->presenter = $presenter;
        $this->benchmarkFactory = $benchmarkFactory;
        $this->params = $params;
    }

    /**
     * @return float|string
     */
    public function bench(callable $callable, array $arguments)
    {
        return $this
            ->benchmarkFactory
            ->fromCallable($callable, ...$arguments)
            ->run()
            ->getDuration()
            ->as($this->params['timeunit']);
    }

    public function getPriority(): int
    {
        return 1;
    }

    public function negativeMatch(string $name, $subject, array $arguments): DelayedCall
    {
        return $this->getDelayedCall([$this, 'verifyNegative'], $subject, $arguments);
    }

    public function positiveMatch(string $name, $subject, array $arguments): DelayedCall
    {
        return $this->getDelayedCall([$this, 'verifyPositive'], $subject, $arguments);
    }

    /**
     * @psalm-suppress UndefinedDocblockClass
     *
     * @param mixed $subject
     */
    public function supports(string $name, $subject, array $arguments): bool
    {
        return in_array($name, $this->keywords, true) && 1 === count($arguments);
    }

    protected function getDelayedCall(callable $check, $subject, array $arguments): DelayedCall
    {
        $timeInSeconds = $this->getParameters($arguments);
        $unwrapper = $this->unwrapper;

        return new DelayedCall(
            static function ($method, $arguments) use ($check, $subject, $timeInSeconds, $unwrapper) {
                $arguments = $unwrapper->unwrapAll($arguments);

                $methodName = $arguments[0];
                $arguments = $arguments[1] ?? [];
                $callable = [$subject, $methodName];

                [$class, $methodName] = [$subject, $methodName];

                if (!method_exists($class, $methodName) && !method_exists($class, '__call')) {
                    throw new MethodNotFoundException(
                        sprintf('Method %s::%s not found.', get_class($class), $methodName),
                        $class,
                        $methodName,
                        $arguments
                    );
                }

                return call_user_func($check, $callable, $arguments, $timeInSeconds);
            }
        );
    }

    /**
     * @return float
     */
    protected function getParameters(array $arguments)
    {
        $timeInSeconds = current($arguments);

        if (!is_numeric($timeInSeconds)) {
            throw new MatcherException(
                sprintf(
                    "Wrong argument provided in throw matcher.\n" .
                    "Fully qualified classname or exception instance expected,\n" .
                    'Got %s.',
                    $this->presenter->presentValue($arguments[0])
                )
            );
        }

        return $timeInSeconds;
    }
}
