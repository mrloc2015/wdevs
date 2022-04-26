<?php

namespace Wdevs\CustomBar\Block\Adminhtml\Form\Field;

class BlockSelectColumn extends AbstractColumn
{
    /**
     * @return array
     */
    protected function getSourceOptions()
    {
        return [
            ['label' => 'Yes', 'value' => 1],
            ['label' => 'No', 'value' => 0],
        ];
    }
}
