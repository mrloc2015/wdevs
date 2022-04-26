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
use Magento\Framework\View\Element\Template\Context;
use Wdevs\CustomBar\Model\Customer\Source\Group as CustomerSource;
use Magento\Store\Model\ScopeInterface;

class TopBar extends \Magento\Framework\View\Element\Template
{
    const XPATH_IS_ENABLED = 'topbar/general/enabled';

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
     * @param Context              $context
     * @param HttpContext          $httpContext
     * @param CustomerSource       $groupModel
     * @param ScopeConfigInterface $scopeConfig
     * @param array                $data
     */
    public function __construct(
        Context              $context,
        HttpContext          $httpContext,
        CustomerSource       $groupModel,
        ScopeConfigInterface $scopeConfig,
        array                $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->groupModel  = $groupModel;
        $this->httpContext = $httpContext;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function displayCustomBar()
    {
        return __('Hello, your customer group is: %1');
    }

    protected function isEnabled()
    {
        return $this->scopeConfig->getValue(
            static::XPATH_IS_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
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
