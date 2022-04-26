<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Wdevs\CustomBar\Block;

use Magento\Customer\Model\Context as CustomerContext;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Serialize\Serializer\Json as Serialize;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Wdevs\CustomBar\Model\Customer\Source\Group as CustomerSource;
use Magento\Cms\Block\BlockByIdentifierFactory;
use Magento\Cms\Block\BlockByIdentifier;
use Magento\Framework\View\Element\Template;

class TopBar extends Template
{
    const XPATH_IS_ENABLED = 'topbar/general/enabled';
    const XPATH_BLOCK_DATA = 'topbar/general/customer_content';

    /**
     * @var HttpContext
     */
    protected $httpContext;

    /**
     * @var CustomerSource
     */
    protected $groupModel;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Serialize
     */
    protected $serialize;

    /**
     * @var BlockByIdentifierFactory
     */
    protected $blockByIdentifierFactory;

    /**
     * @param Context                  $context
     * @param HttpContext              $httpContext
     * @param CustomerSource           $groupModel
     * @param ScopeConfigInterface     $scopeConfig
     * @param Serialize                $serialize
     * @param BlockByIdentifierFactory $blockByIdentifierFactory
     * @param array                    $data
     */
    public function __construct(
        Context                  $context,
        HttpContext              $httpContext,
        CustomerSource           $groupModel,
        ScopeConfigInterface     $scopeConfig,
        Serialize                $serialize,
        BlockByIdentifierFactory $blockByIdentifierFactory,
        array                    $data = []
    ) {
        $this->blockByIdentifierFactory = $blockByIdentifierFactory;
        $this->serialize                = $serialize;
        $this->scopeConfig              = $scopeConfig;
        $this->groupModel               = $groupModel;
        $this->httpContext              = $httpContext;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function displayCustomBar()
    {
        $content      = '';
        $currentGroup = $this->getCurrentCustomerGroup();
        $config       = $this->getBlockContentConfig();

        if ($config && isset($config[$currentGroup])) {
            $content = $this->getCmsBlockContent($config[$currentGroup]['block_id']);
        }

        return $content;
    }

    protected function isEnabled()
    {
        return $this->scopeConfig->getValue(
            static::XPATH_IS_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    protected function getBlockContentConfig()
    {
        $value = $this->scopeConfig->getValue(static::XPATH_BLOCK_DATA, ScopeInterface::SCOPE_STORE);

        if ($value == '' || $value == null) {
            return [];
        }

        $unserializedata = $this->serialize->unserialize($value);

        $arrayValue = [];
        foreach ($unserializedata as $key => $row) {
            $arrayValue[$row['customer_group']] = [
                'customer_group' => $row['customer_group'],
                'block_id'       => $row['block_id'],
            ];
        }

        return $arrayValue;
    }

    /**
     * @param $blockId
     *
     * @return string
     */
    protected function getCmsBlockContent($blockId)
    {
        /** @var BlockByIdentifier $block */
        $block = $this->blockByIdentifierFactory->create();
        $block->setIdentifier($blockId);

        return $block->toHtml() ?: '';
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        return ($this->isEnabled() && $this->isRenderingAllowed() !== false) ? parent::_toHtml() : '';
    }

    /**
     * @return string|null
     */
    protected function isRenderingAllowed()
    {
        return $this->getCurrentCustomerGroup();
    }

    /**
     * @return string|null
     */
    protected function getCurrentCustomerGroup()
    {
        return $this->httpContext->getValue(
            CustomerContext::CONTEXT_GROUP
        );
    }
}
