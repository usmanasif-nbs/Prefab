<?php
declare(strict_types=1);

namespace Neighborhoods\ReplaceThisWithTheNameOfYourProduct\Prefab5\HTTPBuildableDirectoryMap;

use Neighborhoods\ReplaceThisWithTheNameOfYourProduct\Prefab5\Protean;

interface ContainerBuilderInterface
{
    public function setRoute(string $route) : ContainerBuilderInterface;

    public function setBuildableDirectoryMap(array $buildableDirectoryMap) : ContainerBuilderInterface;

    public function getContainerBuilder() : Protean\Container\BuilderInterface;
}
