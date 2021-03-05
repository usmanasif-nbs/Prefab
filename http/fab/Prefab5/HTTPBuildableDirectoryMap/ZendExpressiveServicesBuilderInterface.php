<?php
declare(strict_types=1);

namespace ReplaceThisWithTheNameOfYourVendor\ReplaceThisWithTheNameOfYourProduct\Prefab5\HTTPBuildableDirectoryMap;

interface ZendExpressiveServicesBuilderInterface
{
    public function setHTTPBuildableDirectoryMapFilesystemProperties(FilesystemPropertiesInterface $proteanContainerBuilderFilesystemProperties);

    public function buildDIYAMLFile(): string;
}
