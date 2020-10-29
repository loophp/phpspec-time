<?php

declare(strict_types=1);

namespace loophp\phpspectime;

use loophp\phpspectime\Matcher\TakeInBetweenMatcher;
use loophp\phpspectime\Matcher\TakeLessThanMatcher;
use loophp\phpspectime\Matcher\TakeMoreThanMatcher;
use PhpSpec\Extension as ExtensionInterface;
use PhpSpec\ServiceContainer;
use PhpSpec\ServiceContainer\IndexedServiceContainer;
use Ubench;

final class Extension implements ExtensionInterface
{
    /**
     * @return void
     */
    public function load(ServiceContainer $container, array $params)
    {
        $container->define(
            'matchers.takeMoreThan',
            static function (IndexedServiceContainer $c) {
                return new TakeMoreThanMatcher($c->get('unwrapper'), $c->get('formatter.presenter'), new Ubench());
            },
            ['matchers']
        );

        $container->define(
            'matchers.takeLessThan',
            static function (IndexedServiceContainer $c) {
                return new TakeLessThanMatcher($c->get('unwrapper'), $c->get('formatter.presenter'), new Ubench());
            },
            ['matchers']
        );

        $container->define(
            'matchers.takeInBetween',
            static function (IndexedServiceContainer $c) {
                return new TakeInBetweenMatcher($c->get('unwrapper'), $c->get('formatter.presenter'), new Ubench());
            },
            ['matchers']
        );
    }
}
