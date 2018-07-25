<?php

declare(strict_types=1);

namespace Neighborhoods\~~PROJECT NAME~~\Doctrine\DBAL\Connection;

use Doctrine\DBAL\Connection;
use Neighborhoods\~~PROJECT NAME~~\PDO\Builder\FactoryInterface;

interface DecoratorInterface
{
    public const ID_CORE = 'core';
    public const ID_SCHEMA = 'schema';

    public function getDoctrineConnection(): Connection;

    public function setPDOBuilderFactory(FactoryInterface $dbPDOBuilderFactory);

    public function setId(string $id): Decorator;

    public function getId(): string;

    public function setPDO(\PDO $pdo): DecoratorInterface;
}
