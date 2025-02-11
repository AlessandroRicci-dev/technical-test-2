<?
declare(strict_types=1);

namespace App;

class ClassWithARiskyDependencyYouCantChange
{
    public function __construct(
        private BadlyWrittenLegacyClass $riskyDependency
    )
    {

    }

    public function getCircleArea(int $radius): float
    {
        return $this->riskyDependency->getPi() * ($radius * $radius);
    }
}
