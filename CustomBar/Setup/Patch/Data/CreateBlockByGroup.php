<?php

namespace Wdevs\CustomBar\Setup\Patch\Data;

use Exception;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Wdevs\CustomBar\Model\Customer\Source\Group as CustomerSource;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CreateBlockByGroup implements DataPatchInterface, PatchRevertableInterface
{
    const TITLE           = 'Custom Block For TopBar Customer Group - ';
    const ID              = 'custom_block_topbar_group_';
    const DEFAULT_CONTENT = 'This is content for custom block topbar customer group - ';

    /**
     * @var BlockFactory
     */
    protected BlockFactory $blockFactory;

    /**
     * @var CustomerSource
     */
    protected $customerSource;

    /**
     * @var WriterInterface
     */
    protected $configWriter;

    /**
     * @param CustomerSource  $customerSource
     * @param WriterInterface $writer
     * @param BlockFactory    $blockFactory
     */
    public function __construct(
        CustomerSource  $customerSource,
        WriterInterface $writer,
        BlockFactory    $blockFactory
    ) {
        $this->configWriter   = $writer;
        $this->customerSource = $customerSource;
        $this->blockFactory   = $blockFactory;
    }

    /**
     * @return void
     */
    public function apply()
    {
        $groups      = $this->customerSource->toOptionArray();
        $configArray = [];
        foreach ($groups as $group) {
            $_data['title']      = static::TITLE . $group['label'];
            $_data['content']    = static::DEFAULT_CONTENT . $group['label'];
            $_data['identifier'] = static::ID . $group['value'];
            $_data['is_active']  = 1;
            $_data['stores']     = [0];

            $cmsBlock = $this->blockFactory->create()
                                           ->load($_data['identifier'], 'identifier');

            if (!$cmsBlock->getId()) {
                $cmsBlock->setData($_data)->save();
            }
            $configArray[] = [
                'customer_group' => $group['value'],
                'block_id'       => $cmsBlock->getIdentifier(),
            ];
        }

        if ($configArray) {
            $this->configWriter->save('topbar/general/customer_content', json_encode($configArray));
        }
    }

    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @throws Exception
     */
    public function revert()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}
