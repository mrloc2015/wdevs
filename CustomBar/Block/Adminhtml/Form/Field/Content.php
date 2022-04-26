<?php

namespace Wdevs\CustomBar\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class Content extends AbstractFieldArray
{
    private $customerGroupRenderer;
    private $blockIdRenderer;

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     *
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $group = $row->getCustomerGroup();
        if ($group !== null) {
            $options['option_' . $this->getCustomerGroupRenderer()->calcOptionHash($group)] = 'selected="selected"';
        }
        $block = $row->getBlockId();
        if ($block != null) {
            $options['option_' . $this->getBlockIdRenderer()->calcOptionHash($block)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('customer_group', [
            'label'    => __('Customer Group'),
            'renderer' => $this->getCustomerGroupRenderer(),
        ]);
        $this->addColumn('block_id', [
            'label'    => __('Block Content'),
            'renderer' => $this->getBlockIdRenderer(),
        ]);
        $this->_addAfter       = true;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * @return BlockSelectColumn
     * @throws LocalizedException
     */
    private function getBlockIdRenderer()
    {
        if (!$this->blockIdRenderer) {
            $this->blockIdRenderer = $this->getLayout()->createBlock(
                BlockSelectColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->blockIdRenderer;
    }

    /**
     * @return CustomerGroupColumn
     * @throws LocalizedException
     */
    private function getCustomerGroupRenderer()
    {
        if (!$this->customerGroupRenderer) {
            $this->customerGroupRenderer = $this->getLayout()->createBlock(
                CustomerGroupColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->customerGroupRenderer;
    }
}
