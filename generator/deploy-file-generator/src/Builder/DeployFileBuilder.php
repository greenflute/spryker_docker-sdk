<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace DeployFileGenerator\Builder;

use DeployFileGenerator\Processor\DeployFileProcessorInterface;
use DeployFileGenerator\Transfer\DeployFileTransfer;

class DeployFileBuilder implements DeployFileBuilderInterface
{
    /**
     * @var \DeployFileGenerator\Processor\DeployFileProcessorInterface
     */
    protected $deployFileBuildProcessor;

    /**
     * @param \DeployFileGenerator\Processor\DeployFileProcessorInterface $deployFileBuildProcessor
     */
    public function __construct(DeployFileProcessorInterface $deployFileBuildProcessor)
    {
        $this->deployFileBuildProcessor = $deployFileBuildProcessor;
    }

    /**
     * @param string $inputFilePath
     * @param string|null $outputFilePath
     *
     * @return \DeployFileGenerator\Transfer\DeployFileTransfer
     */
    public function build(string $inputFilePath, ?string $outputFilePath = null): DeployFileTransfer
    {
        $deployFileTransfer = new DeployFileTransfer();
        $outputFilePath = $outputFilePath ?? $inputFilePath;

        $deployFileTransfer = $deployFileTransfer->setInputFilePath($inputFilePath);
        $deployFileTransfer = $deployFileTransfer->setOutputFilePath($outputFilePath);

        return $this->deployFileBuildProcessor->process($deployFileTransfer);
    }
}
