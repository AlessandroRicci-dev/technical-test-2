<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\BadlyWrittenLegacyClass;
use App\BadlyWrittenLegacyClassYouCantRefactor;
use App\ClassWithARiskyDependencyYouCantChange;

class MyTest extends TestCase
{


    //Note: Add a @covers annotation above the test to define a coverage target, otherwise phpUnit complain about it.

    /**
     * @covers \App\ClassWithARiskyDependencyYouCantChange::getCircleArea
     */

    public function testCircleArea(): void
    {

        //Note: Using an extended class and mock it, let the method getPi be defined
        //SOLVES: PHPUnit\Framework\MockObject\MethodCannotBeConfiguredException: Trying to configure method "getPi" which cannot be configured because it does not exist, has not been specified, is final, or is static

        $mockDependency = $this->getMockBuilder(ExtendedLegacyClass::class)
            ->disableOriginalConstructor()
            ->getMock();

        //Note: Stub the getPi method to return 3.14

        $mockDependency->method('getPi')->willReturn(3.14);

        //Note: construct a new Mock for ClassWithARiskyDependencyYouCantChange

        $testMePlease = $this->getMockBuilder(ClassWithARiskyDependencyYouCantChange::class)
            ->disableOriginalConstructor()
            // we need to disable the OriginalConstructor as the constructor expect App\BadlyWrittenLegacyClass That is undefined
            // SOLVES TypeError: App\ClassWithARiskyDependencyYouCantChange::__construct(): Argument #1 ($riskyDependency) must be of type App\BadlyWrittenLegacyClass, MockObject_ExtendedLegacyClass_a31fe91e given
            ->setConstructorArgs([$mockDependency]) //injecting the mock dependency.
            ->getMock();

        $radius = 12;

        //Note: Stub the getCircleArea method to return a callback

        $testMePlease->method('getCircleArea')->willReturnCallback(function () use ($mockDependency, $radius) {
            return $mockDependency->getPi() * ($radius * $radius);
        });

        $area = $testMePlease->getCircleArea($radius);
        self::assertSame(3.14 * ($radius * $radius), $area);
    }
}

class ExtendedLegacyClass extends BadlyWrittenLegacyClassYouCantRefactor
{
    public $variable;

    public function getPi()
    {
        return 3.14;
    }
}
