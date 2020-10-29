<?php

declare(strict_types=1);

namespace spec\loophp\phpspectime;

use Exception;
use loophp\phpspectime\Extension;
use loophp\phpspectime\Matcher\TakeInBetweenMatcher;
use loophp\phpspectime\Matcher\TakeLessThanMatcher;
use loophp\phpspectime\Matcher\TakeMoreThanMatcher;
use PhpSpec\ObjectBehavior;
use PhpSpec\ServiceContainer\IndexedServiceContainer;

final class ExtensionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Extension::class);
    }

    public function it_set_extension_matchers(): void
    {
        $container = new IndexedServiceContainer();

        $this
            ->load($container, []);

        $services = [
            'matchers.takeMoreThan' => TakeMoreThanMatcher::class,
            'matchers.takeLessThan' => TakeLessThanMatcher::class,
            'matchers.takeInBetween' => TakeInBetweenMatcher::class,
        ];

        foreach ($services as $id => $service) {
            if (false === $container->has($id)) {
                throw new Exception(sprintf('Matcher %s not found.', $service));
            }
        }
    }
}
