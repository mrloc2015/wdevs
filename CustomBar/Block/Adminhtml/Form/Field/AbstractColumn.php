<?php

namespace Wdevs\CustomBar\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;

abstract class AbstractColumn extends Select
{

    protected $width = 0;

    /**
     * Set "name" for <select> element
     *
     * @param string $value
     *
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param $value
     *
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        if ($this->width) {
            $this->setExtraParams('style="width:' . $this->width . 'px;"');
        }

        return parent::_toHtml();
    }

    /**
     * @return array
     */
    protected function getSourceOptions()
    {
        return [];
    }
}
