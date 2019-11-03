<?php
declare(strict_types=1);

namespace Neighborhoods\Prefab\AnnotationProcessorRecord\StaticContextRecord\Actor\Map\Repository\RepositoryUpdateElementIdentityField;

use Neighborhoods\Prefab\BuildConfigurationInterface;
use Neighborhoods\Prefab\AnnotationProcessorRecord\StaticContextRecord\BuilderInterface;
use Neighborhoods\Prefab\AnnotationProcessor\Actor\RepositoryUpdateElementIdentityField;

class Builder implements BuilderInterface
{
    protected $buildConfiguration;

    public function build() : array
    {
        if (!$this->getBuildConfiguration()->hasDaoIdentityField()) {
            return [];
        }

        return [
            RepositoryUpdateElementIdentityField::KEY_IDENTITY_FIELD => $this->getBuildConfiguration()->getDaoIdentityField()
        ];
    }

    protected function getBuildConfiguration() : BuildConfigurationInterface
    {
        if ($this->buildConfiguration === null) {
            throw new \LogicException('Builder buildConfiguration has not been set.');
        }
        return $this->buildConfiguration;
    }

    public function setBuildConfiguration(BuildConfigurationInterface $buildConfiguration) : BuilderInterface
    {
        if ($this->buildConfiguration !== null) {
            throw new \LogicException('Builder buildConfiguration is already set.');
        }
        $this->buildConfiguration = $buildConfiguration;
        return $this;
    }
}
