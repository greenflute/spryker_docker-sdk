<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Unit\DeployFileGeneratorTest\Executor;

use Codeception\Test\Unit;
use DeployFileGenerator\Executor\ExportDeployFileTransferToYamlExecutor;
use DeployFileGenerator\Transfer\DeployFileTransfer;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

class ExportDeployFileTransferToYamlExecutorTest extends Unit
{
    /**
     * @var string
     */
    protected const EXPORT_FILE_PATH = './tests/_output/ExportDeployFileTransferToYamlExecutorTest.yml';

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @return void
     */
    protected function _after(): void
    {
        unlink(static::EXPORT_FILE_PATH);
    }

    /**
     * @return void
     */
    public function testExecute(): void
    {
        $deployFileTransfer = $this->createExportDeployFileTransferToYamlExecutor()
            ->execute($this->createDeployFileTransfer());

        $this->tester->assertFileExists(static::EXPORT_FILE_PATH);
        $this->tester->assertEquals(
            $this->getResultData(),
            $this->createParser()->parseFile($deployFileTransfer->getOutputFilePath())
        );
    }

    /**
     * @return \DeployFileGenerator\Transfer\DeployFileTransfer
     */
    protected function createDeployFileTransfer(): DeployFileTransfer
    {
        $deployFileTransfer = new DeployFileTransfer();
        $deployFileTransfer = $deployFileTransfer->setResultData($this->getResultData());

        return $deployFileTransfer->setOutputFilePath(static::EXPORT_FILE_PATH);
    }

    /**
     * @return string[]
     */
    protected function getResultData(): array
    {
        return [
            'some-data' => 'some-value',
        ];
    }

    /**
     * @return \DeployFileGenerator\Executor\ExportDeployFileTransferToYamlExecutor
     */
    protected function createExportDeployFileTransferToYamlExecutor(): ExportDeployFileTransferToYamlExecutor
    {
        return new ExportDeployFileTransferToYamlExecutor(new Dumper());
    }

    /**
     * @return \Symfony\Component\Yaml\Parser
     */
    protected function createParser(): Parser
    {
        return new Parser();
    }
}
