<?php
declare(strict_types=1);

namespace Neighborhoods\Prefab\BuildConfiguration;


use Neighborhoods\Prefab\BuildConfigurationInterface;
use Neighborhoods\Prefab\BuildConfiguration;
use Symfony\Component\Yaml\Yaml;

class Builder implements BuilderInterface
{
    use BuildConfiguration\Factory\AwareTrait;

    protected $yamlFilePath;
    protected $projectName;
    /** @var string */
    protected $daoNamespace;

    public function build() : BuildConfigurationInterface
    {
        $buildConfiguration = $this->getBuildConfigurationFactory()->create();
        $configArray = $this->getConfigFromYaml();

        $buildConfiguration->setTableName($configArray['dao']['table_name'])
            ->setDaoIdentityField($configArray['dao']['identity_field'])
            ->setHttpRoute($configArray['dao']['http_route'])
            ->setRootSaveLocation($this->getFabDirFromYamlPath())
            ->setProjectDir($this->getProjectDirFromYamlPath())
            ->setProjectName($this->getProjectName());

        foreach ($configArray['dao']['properties'] as $key => $values) {
            $buildConfiguration->appendDaoProperty($key, $values);
        }

        return $buildConfiguration;
    }

    protected function getFabDirFromYamlPath() : string
    {
        $pathArray = explode('/src/', $this->getYamlFilePath());
        return $pathArray[0] . '/src/' . $pathArray[1] . '/fab/' . $pathArray[2];
    }

    protected function getProjectDirFromYamlPath() : string
    {
        $pathArray = explode('/src/', $this->getYamlFilePath());
        return $pathArray[0] . '/src/' . $pathArray[1] . '/';
    }

    protected function getConfigFromYaml() : array
    {
        return Yaml::parseFile($this->getYamlFilePath());
    }

    protected function getYamlFilePath() : string
    {
        if ($this->yamlFilePath === null) {
            throw new \LogicException('Builder yamlFilePath has not been set.');
        }
        return $this->yamlFilePath;
    }

    public function setYamlFilePath(string $yamlFilePath) : BuilderInterface
    {
        if ($this->yamlFilePath !== null) {
            throw new \LogicException('Builder yamlFilePath is already set.');
        }
        $this->yamlFilePath = $yamlFilePath;
        return $this;
    }

    protected function getProjectName() : string
    {
        if ($this->projectName === null) {
            throw new \LogicException('Builder projectName has not been set.');
        }
        return $this->projectName;
    }

    public function setProjectName(string $projectName) : BuilderInterface
    {
        if ($this->projectName !== null) {
            throw new \LogicException('Builder projectName is already set.');
        }
        $this->projectName = $projectName;
        return $this;
    }
}