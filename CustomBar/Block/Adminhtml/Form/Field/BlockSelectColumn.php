<?php

namespace Wdevs\CustomBar\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Context;
use Wdevs\CustomBar\Model\Block\Source\CmsBlock;
use Magento\Framework\Exception\LocalizedException;

class BlockSelectColumn extends AbstractColumn
{

    protected $blockSource;

    protected $width = 350;

    /**
     * @param Context  $context
     * @param CmsBlock $blockSource
     * @param array    $data
     */
    public function __construct(
        Context  $context,
        CmsBlock $blockSource,
        array    $data = []
    ) {
        $this->blockSource = $blockSource;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    protected function getSourceOptions()
    {
        return $this->blockSource->toOptionArray();
    }
}
