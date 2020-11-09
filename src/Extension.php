<?php

declare(strict_types=1);

namespace loophp\phpspectime;

use loophp\nanobench\BenchmarkFactory;
use loophp\nanobench\Time\TimeUnit;
use loophp\phpspectime\Matcher\TakeInBetweenMatcher;
use loophp\phpspectime\Matcher\TakeLessThanMatcher;
use loophp\phpspectime\Matcher\TakeMoreThanMatcher;
use PhpSpec\Extension as ExtensionInterface;
use PhpSpec\ServiceContainer;
use PhpSpec\ServiceContainer\IndexedServiceContainer;

final class Extension implements ExtensionInterface
{
    /**
     * @return void
     */
    public function load(ServiceContainer $container, array $params)
    {
        $params += [
            'timeunit' => TimeUnit::SECOND,
        ];

        $container->define(
            'matchers.takeMoreThan',
            static function (IndexedServiceContainer $c) use ($params) {
                return new TakeMoreThanMatcher(
                    $c->get('unwrapper'),
                    $c->get('formatter.presenter'),
                    new BenchmarkFactory(),
                    $params
                );
            },
            ['matchers']
        );

        $container->define(
            'matchers.takeLessThan',
            static function (IndexedServiceContainer $c) use ($params) {
                return new TakeLessThanMatcher(
                    $c->get('unwrapper'),
                    $c->get('formatter.presenter'),
                    new BenchmarkFactory(),
                    $params
                );
            },
            ['matchers']
        );

        $container->define(
            'matchers.takeInBetween',
            static function (IndexedServiceContainer $c) use ($params) {
                return new TakeInBetweenMatcher(
                    $c->get('unwrapper'),
                    $c->get('formatter.presenter'),
                    new BenchmarkFactory(),
                    $params
                );
            },
            ['matchers']
        );
    }
}
