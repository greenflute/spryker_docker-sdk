<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace DeployFileGeneratorTest\Executor;

use Codeception\Test\Unit;
use DeployFileGenerator\DeployFileConstants;
use DeployFileGenerator\Executor\PrepareDeployFileTransferExecutor;
use DeployFileGenerator\FileFinder\FileFinder;
use DeployFileGenerator\FileFinder\FileFinderInterface;
use DeployFileGenerator\Transfer\DeployFileTransfer;
use Symfony\Component\Yaml\Parser;

class PrepareDeployFileTransferExecutorTest extends Unit
{
    /**
     * @var string
     */
    protected const PROJECT_YML_FILE_NAME = 'project.yml';
    /**
     * @var string
     */
    protected const BASE_YML_FILE_NAME = 'base.yml';

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testExecuteWithImportInData(): void
    {
        $yamlData = [
            DeployFileConstants::YAML_IMPORTS_KEY => [
                static::PROJECT_YML_FILE_NAME => null,
                static::BASE_YML_FILE_NAME => null,
            ],
        ];

        $executor = new PrepareDeployFileTransferExecutor(
            $this->createYamlParserMock($yamlData),
            $this->createFileFinderMock(),
        );

        $deployFileTransfer = $executor->execute($this->createDeployFileTransfer());

        $this->tester->assertArrayHasKey(static::PROJECT_YML_FILE_NAME, $deployFileTransfer->getProjectImports());
        $this->tester->assertArrayHasKey(static::BASE_YML_FILE_NAME, $deployFileTransfer->getBaseImports());
    }

    /**
     * @return void
     */
    public function testExecuteIfFileNotExist(): void
    {
        $yamlData = [
            DeployFileConstants::YAML_IMPORTS_KEY => [
                static::PROJECT_YML_FILE_NAME => null,
                static::BASE_YML_FILE_NAME => null,
            ],
        ];

        $executor = new PrepareDeployFileTransferExecutor(
            $this->createYamlParserMock($yamlData),
            $this->createNullableFileFinderMock(),
        );

        $deployFileTransfer = $executor->execute($this->createDeployFileTransfer());

        $this->tester->assertArrayNotHasKey(static::PROJECT_YML_FILE_NAME, $deployFileTransfer->getProjectImports());
        $this->tester->assertArrayNotHasKey(static::BASE_YML_FILE_NAME, $deployFileTransfer->getBaseImports());
    }

    /**
     * @return void
     */
    public function testExecuteWithoutImportInData(): void
    {
        $yamlData = [];

        $executor = new PrepareDeployFileTransferExecutor(
            $this->createYamlParserMock($yamlData),
            $this->createFileFinderMock(),
        );

        $deployFileTransfer = $executor->execute($this->createDeployFileTransfer());

        $this->tester->assertArrayNotHasKey(static::PROJECT_YML_FILE_NAME, $deployFileTransfer->getProjectImports());
        $this->tester->assertArrayNotHasKey(static::BASE_YML_FILE_NAME, $deployFileTransfer->getBaseImports());
    }

    /**
     * @return \DeployFileGenerator\Transfer\DeployFileTransfer
     */
    protected function createDeployFileTransfer(): DeployFileTransfer
    {
        return new DeployFileTransfer();
    }

    /**
     * @param array $yamlData
     *
     * @return \Symfony\Component\Yaml\Parser
     */
    protected function createYamlParserMock(array $yamlData): Parser
    {
        return $this->make(Parser::class, [
            'parseFile' => $yamlData,
        ]);
    }

    /**
     * @return \DeployFileGenerator\FileFinder\FileFinderInterface
     */
    protected function createFileFinderMock(): FileFinderInterface
    {
        return $this->make(FileFinder::class, [
            'getFilePathOnBaseLayer' => function ($path) {
                return $path;
            },
            'getFilePathOnProjectLayer' => function ($path) {
                return $path;
            },
        ]);
    }

    /**
     * @return \DeployFileGenerator\FileFinder\FileFinderInterface
     */
    protected function createNullableFileFinderMock(): FileFinderInterface
    {
        return $this->make(FileFinder::class, [
            'getFilePathOnBaseLayer' => null,
            'getFilePathOnProjectLayer' => null,
        ]);
    }
}