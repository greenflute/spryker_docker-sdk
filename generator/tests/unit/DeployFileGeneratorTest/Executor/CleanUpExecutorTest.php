<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Unit\DeployFileGeneratorTest\Executor;

use Codeception\Test\Unit;
use DeployFileGenerator\DeployFileConstants;
use DeployFileGenerator\Executor\CleanUpExecutor;
use DeployFileGenerator\Executor\ExecutorInterface;
use DeployFileGenerator\Transfer\DeployFileTransfer;

class CleanUpExecutorTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testExecuteWithImportsKeyInResultData(): void
    {
        $resultData = [
            'some-key' => 'some-data',
            DeployFileConstants::YAML_IMPORTS_KEY => [
                1,
                2,
                3,
            ],
        ];

        $deployFileTransfer = $this->getCleanUpExecutor()->execute(
            $this->createDeployFileTransferWithResultData($resultData)
        );

        $this->tester->assertArrayNotHasKey(
            DeployFileConstants::YAML_IMPORTS_KEY,
            $deployFileTransfer->getResultData()
        );
    }

    /**
     * @return void
     */
    public function testExecuteWithoutImportsKeyInResultData(): void
    {
        $resultData = [
            'some-key' => 'some-data',
        ];

        $deployFileTransfer = $this->getCleanUpExecutor()->execute(
            $this->createDeployFileTransferWithResultData($resultData)
        );

        $this->tester->assertArrayNotHasKey(
            DeployFileConstants::YAML_IMPORTS_KEY,
            $deployFileTransfer->getResultData()
        );
    }

    /**
     * @param array $resultData
     *
     * @return \DeployFileGenerator\Transfer\DeployFileTransfer
     */
    protected function createDeployFileTransferWithResultData(array $resultData): DeployFileTransfer
    {
        $deployFileTransfer = new DeployFileTransfer();

        return $deployFileTransfer->setResultData($resultData);
    }

    /**
     * @return \DeployFileGenerator\Executor\ExecutorInterface
     */
    protected function getCleanUpExecutor(): ExecutorInterface
    {
        return new CleanUpExecutor();
    }
}