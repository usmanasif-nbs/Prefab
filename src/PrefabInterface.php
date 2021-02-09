<?php

namespace Neighborhoods\Prefab;

interface PrefabInterface
{
    public function generate(): PrefabInterface;
    public function setProjectDir($project_dir): PrefabInterface;
    public function setApplicationRootDirectoryPath(string $applicationRootDirectoryPath): PrefabInterface;
}
