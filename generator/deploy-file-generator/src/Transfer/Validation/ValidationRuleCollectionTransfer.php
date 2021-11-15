<?php
/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace DeployFileGenerator\Transfer\Validation;

use DeployFileGenerator\Validator\Rule\RuleInterface;

class ValidationRuleCollectionTransfer
{
    /**
     * @var array<RuleInterface>
     */
    protected $validationRules = [];

    /**
     * @return array<RuleInterface>
     */
    public function getValidationRules(): array
    {
        return $this->validationRules;
    }

    /**
     * @param array<RuleInterface> $validationRules
     *
     * @return $this
     */
    public function setValidationRules(array $validationRules)
    {
        $this->validationRules = $validationRules;

        return $this;
    }

    /**
     * @param \DeployFileGenerator\Validator\Rule\RuleInterface $validationRule
     *
     * @return $this
     */
    public function addRule(RuleInterface $validationRule)
    {
        $this->validationRules[] = $validationRule;

        return $this;
    }
}
