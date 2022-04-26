<?php

namespace Wdevs\CustomBar\Model\Block\Source;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Exception\LocalizedException;

class CmsBlock implements OptionSourceInterface
{
    /**
     * @var BlockRepositoryInterface
     */
    protected BlockRepositoryInterface $blockRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * CmsBlocks constructor.
     *
     * @param BlockRepositoryInterface $blockRepository
     * @param SearchCriteriaBuilder    $searchCriteriaBuilder
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        SearchCriteriaBuilder    $searchCriteriaBuilder
    ) {
        $this->blockRepository       = $blockRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    public function toOptionArray(): array
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $cmsBlocks      = $this->blockRepository->getList($searchCriteria)->getItems();

        $blocks = [];

        foreach ($cmsBlocks as $block) {
            $blocks[] = ['value' => $block->getIdentifier(), 'label' => $block->getTitle()];
        }

        return $blocks;
    }
}
