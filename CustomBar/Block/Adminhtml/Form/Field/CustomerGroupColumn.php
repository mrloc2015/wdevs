<?php

namespace Wdevs\CustomBar\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Context;
use Wdevs\CustomBar\Model\Customer\Source\Group as CustomerSource;

class CustomerGroupColumn extends AbstractColumn
{

    /**
     * @var CustomerSource
     */
    protected $customerSource;

    public function __construct(
        CustomerSource $customerSource,
        Context        $context,
        array          $data = []
    ) {
        $this->customerSource = $customerSource;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    protected function getSourceOptions()
    {
        return $this->customerSource->toOptionArray();
    }
}
