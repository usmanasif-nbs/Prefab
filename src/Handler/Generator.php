<?php
declare(strict_types=1);

namespace Neighborhoods\Prefab\Handler;

use Neighborhoods\Prefab\ClassSaverInterface;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Reflection\ClassReflection;

class Generator implements GeneratorInterface
{
    protected $namespace;
    protected $version;
    protected $generator;
    protected $daoName;
    protected $varName;
    protected $projectName;
    protected $classSaver;
    protected $entityName;

    protected const CLASS_NAME = 'Handler';

    public function generate() : GeneratorInterface
    {
        $this->setGenerator();

        $this->getGenerator()->setNamespaceName($this->getNamespace());
        $this->getGenerator()->setImplementedInterfaces([$this->getNamespace() . '\HandlerInterface']);
        $this->getGenerator()->setName(self::CLASS_NAME);

        $this->getGenerator()->addTraits(
            [
                'Neighborhoods\\' . $this->getProjectName() . $this->getEntityName() . '\Repository\AwareTrait',
                'Neighborhoods\\' . $this->getProjectName() . '\Psr\Http\Message\ServerRequest\AwareTrait',
                'Neighborhoods\\' . $this->getProjectName() . '\SearchCriteria\ServerRequest\Builder\Factory\AwareTrait',
            ]
        );

        $file = new FileGenerator();
        $file->setClass($this->getGenerator());

        $builtFile = $this->replaceEntityPlaceholders($file->generate());

        $this->getClassSaver()
            ->setNamespace($this->getNamespace())
            ->setClassName(self::CLASS_NAME)
            ->setGeneratedClass($builtFile)
            ->saveClass();

        return $this;
    }

    protected function getEntityName() : string
    {
        if ($this->entityName === null) {
           $namespaceArray = explode('\\', $this->getNamespace()) ;
           $this->entityName = $namespaceArray[count($namespaceArray) - 2];
        }

        return $this->entityName;
    }

    protected function getProjectName() : string
    {
        if ($this->projectName === null) {
            $this->projectName = explode('\\', $this->getNamespace())[1];
        }
        return $this->projectName;
    }

    protected function replaceReturnTypePlaceHolders()
    {
        $methods = $this->getGenerator()->getMethods();

        foreach ($methods as $method) {
            $returnType = $method->getReturnType();
            if ($returnType && strpos($returnType->generate(), 'DAONAMEPLACEHOLDERInterface')) {
                $method->setReturnType($this->getNamespace() . 'Interface');
            }
        }
    }

    protected function replaceEntityPlaceholders($fileContent) : string
    {
        $fileContent = str_replace('DAONAMEPLACEHOLDER', $this->getNamespace(), $fileContent);
        $methodVarName = implode('', explode('\\', $this->getNamespace()));
        $fileContent = str_replace('DAOVARNAMEPLACEHOLDER', $methodVarName, $fileContent);
        $fileContent = str_replace('PROJECTNAMEPLACEHOLDER', $this->getProjectName(), $fileContent);
        $fileContent = str_replace('NAMESPACEPLACEHOLDER', $this->getNamespace(), $fileContent);

        return $fileContent;
    }

    protected function getVersion() : string
    {
        if ($this->version === null) {
            throw new \LogicException('Generator version has not been set.');
        }
        return $this->version;
    }

    public function setVersion(string $version) : GeneratorInterface
    {
        if ($this->version !== null) {
            throw new \LogicException('Generator version is already set.');
        }
        $this->version = $version;
        return $this;
    }

    protected function setGenerator() : GeneratorInterface
    {
        $template = new ClassReflection(Template::class);
        $this->generator = ClassGenerator::fromReflection($template);
        return $this;
    }

    protected function getGenerator() : ClassGenerator
    {
        if ($this->generator === null) {
            throw new \LogicException('Generator generator has not been set');
        }

        return $this->generator;
    }

    public function getNamespace() : string
    {
        if ($this->namespace === null) {
            throw new \LogicException('Generator namespace has not been set.');
        }
        return $this->namespace;
    }

    public function setNamespace(string $namespace) : GeneratorInterface
    {
        if ($this->namespace !== null) {
            throw new \LogicException('Generator namespace is already set.');
        }
        $this->namespace = $namespace;
        return $this;
    }

    protected function getDaoName() : string
    {
        if ($this->daoName === null) {
            throw new \LogicException('Generator daoName has not been set.');
        }
        return $this->daoName;
    }

    public function setDaoName(string $daoName) : GeneratorInterface
    {
        if ($this->daoName !== null) {
            throw new \LogicException('Generator daoName is already set.');
        }
        $this->daoName = $daoName;
        return $this;
    }

    public function getVarName() : string
    {
        if ($this->varName === null) {
            throw new \LogicException('Generator varName has not been set.');
        }
        return $this->varName;
    }

    public function setVarName(string $varName) : GeneratorInterface
    {
        if ($this->varName !== null) {
            throw new \LogicException('Generator varName is already set.');
        }
        $this->varName = $varName;
        return $this;
    }

    protected function getClassSaver() : ClassSaverInterface
    {
        if ($this->classSaver === null) {
            throw new \LogicException('Generator classSaver has not been set.');
        }
        return $this->classSaver;
    }

    public function setClassSaver(ClassSaverInterface $classSaver) : GeneratorInterface
    {
        if ($this->classSaver !== null) {
            throw new \LogicException('Generator classSaver is already set.');
        }
        $this->classSaver = $classSaver;
        return $this;
    }
}
