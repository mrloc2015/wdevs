<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Wdevs\CustomBar\Block;

use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Customer\Model\Context as CustomerContext;

class TopBar extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Wdevs\CustomBar\Helper\Data
     */
    protected $helper;

    /**
     * @var HttpContext
     */
    protected $httpContext;

    /**
     * @var \Wdevs\CustomBar\Model\Customer\Source\Group
     */
    protected $groupModel;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Wdevs\CustomBar\Helper\Data                     $helper
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wdevs\CustomBar\Helper\Data                     $helper,
        HttpContext                                      $httpContext,
        \Wdevs\CustomBar\Model\Customer\Source\Group     $groupModel,
        array                                            $data = []
    ) {
        $this->groupModel  = $groupModel;
        $this->httpContext = $httpContext;
        $this->helper      = $helper;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function displayCustomBar()
    {
        return __('Hello, your customer group is: %1', $this->getText());
    }

    protected function getText()
    {
        $groups = $this->groupModel->toArrayByKey();
        if ($groups && isset($groups[$this->getCurrentCustomerGroup()])) {
            return $groups[$this->getCurrentCustomerGroup()];
        }
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        return ($this->helper->isEnabled() && $this->isRenderingAllowed() !== false) ? parent::_toHtml() : '';
    }

    /**
     * @return bool
     */
    protected function isRenderingAllowed()
    {
        return $this->getCurrentCustomerGroup();
    }

    /**
     * @return mixed|null
     */
    protected function getCurrentCustomerGroup()
    {
        return $this->httpContext->getValue(
            CustomerContext::CONTEXT_GROUP
        );
    }

}

