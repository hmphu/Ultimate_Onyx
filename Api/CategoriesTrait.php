<?php

namespace Ultimate\Onyx\Api;

use GuzzleHttp\Client;
use Magento\Framework\App\ObjectManager;

/**
 * Onyx ERP categories management
 */
trait CategoriesTrait
{
    /**
     * Get Onyx ERP categories.
     *
     * @return $categories
     */
    public function getOnyxCategories()
    {
        $onyxClient = new Client([
            // 'base_uri' => 'http://196.218.192.248:2000/OnyxShopMarket/Service.svc/'
            'base_uri' => getenv('API_URL')
        ]);

        $response = $onyxClient->request(
            'GET',
            'GetGroupDetails',
            [
                'query' => [
                    'type'           => 'ORACLE',
                    'year'           => getenv('ACCOUNTING_YEAR'),
                    'activityNumber' => getenv('ACTIVITY_NUMBER'),
                    'languageID'     => getenv('LANGUAGE_ID'),
                    'searchValue'    => -1,
                    'pageNumber'     => -1,
                    'rowsCount'      => -1,
                    'orderBy'        => -1,
                    'sortDirection'  => -1
                ]
            ]
        );

        $categories = json_decode($response->getBody())->MultipleObjectHeader;

        // echo json_encode($categories);
        return $categories;
    }

    /**
     * Get Magento store categories.
     *
     * @return \Magento\Catalog\Model\Category $categories
     */
    public function getStoreCategories()
    {
        $categories = ObjectManager::getInstance()->get('Magento\Catalog\Model\CategoryFactory')
                                                  ->create()
                                                  ->getCollection()
                                                  ->addAttributeToSelect(['*']); //->getData();

        return $categories;
    }

    /**
     * Sync Onyx ERP categories.
     *
     * @param \Ultimate\Onyx\Log\Logger $logger
     */
    public function syncCategories($logger)
    {
        foreach ($this->getOnyxCategories() as $category) {
            $url = $category->Code;
            $categoryId = $this->addStoreCategory(
                $category,
                $url,
                1,
                $logger
            );

            if (!empty($category->IAS_MAIN_SUB_GRP_DTL_List)) {
                foreach ($category->IAS_MAIN_SUB_GRP_DTL_List as $subGroup) {
                    $url = $category->Code . '-' . $subGroup->Code;
                    $subGroupId = $this->addStoreCategory(
                        $subGroup,
                        $url,
                        $categoryId,
                        $logger
                    );

                    if (!empty($subGroup->IAS_SUB_GRP_DTL_List)) {
                        foreach ($subGroup->IAS_SUB_GRP_DTL_List as $assistGroup) {
                            $url = $category->Code . '-' . $subGroup->Code . '-' . $assistGroup->Code;
                            $assistGroupId = $this->addStoreCategory(
                                $assistGroup,
                                $url,
                                $subGroupId,
                                $logger
                            );

                            if (!empty($assistGroup->IAS_ASSISTANT_GRP_DTL_List)) {
                                foreach ($assistGroup->IAS_ASSISTANT_GRP_DTL_List as $detailGroup) {
                                    $url = $category->Code . '-' . $subGroup->Code . '-' .
                                           $assistGroup->Code . '-' . $detailGroup->Code;
                                    $detailGroupId = $this->addStoreCategory(
                                        $detailGroup,
                                        $url,
                                        $assistGroupId,
                                        $logger
                                    );

                                    if (!empty($detailGroup->IAS_DETAIL_GRP_List)) {
                                        foreach ($detailGroup->IAS_DETAIL_GRP_List as $final) {
                                            $url = $category->Code . '-' . $subGroup->Code . '-' .
                                                   $assistGroup->Code . '-' . $detailGroup->Code . '-' . $final->Code;
                                            $this->addStoreCategory(
                                                $final,
                                                $url,
                                                $detailGroupId,
                                                $logger
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Get Magento store category by url
     *
     * @param string $url
     * @return \Magento\Catalog\Model\Category $category
     */
    public function getStoreCategoryByUrl($url)
    {
        $category = ObjectManager::getInstance()->get('Magento\Catalog\Model\CategoryFactory')
                                                ->create()
                                                ->getCollection()
                                                ->addAttributeToFilter('url_key', $url)
                                                ->addAttributeToSelect(['*'])
                                                ->getFirstItem();

        if ($category->getId()) {
            return $category;
        }

        return null;
    }

    /**
     * Create Magento Store category.
     *
     * @param $category
     * @param string $url
     * @param \Ultimate\Onyx\Log\Logger $logger
     * @return integer $categoryId
     */
    public function addStoreCategory($category, $url, $parentId, $logger)
    {
        // Code -> GroupCode -> MainGroupCode -> SubGroupCode -> AssistantGroupCode

        // if exists return categoryId
        $storeCategory = $this->getStoreCategoryByUrl($url);

        if ($storeCategory) {
            if ($storeCategory->getName() !== $category->Name) {
                $storeCategory->setName($category->Name);
                $storeCategory->setStoreId(0);

                try {
                    $storeCategory->save();
                    $logger->info('Category with name: `' . $storeCategory->getName() . '` has been updated.');
                } catch (\Exception $e) {
                    $logger->error($e->getMessage());
                }
            }

            return $storeCategory->getId();
        }
        // else create
        $catalogCategory = ObjectManager::getInstance()->create('Magento\Catalog\Model\Category');

        $parentCategory = ObjectManager::getInstance()->create('Magento\Catalog\Model\Category')->load($parentId);

        $catalogCategory->setName($category->Name);
        $catalogCategory->setParentId($parentId);
        $catalogCategory->setIsActive(true);
        $catalogCategory->setUrlKey($url);
        // $catalogCategory->setStoreId(1); // $this->storeManagerInterface->getStore()->getId()
        $catalogCategory->setPath($parentCategory->getPath());

        try {
            $catalogCategory->save();
            $logger->info('Category with name: `' . $catalogCategory->getName() . '` has been created.');
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
        }

        return $catalogCategory->getId();
    }

    /**
     * Delete all Magento store categories.
     *
     * @param \Ultimate\Onyx\Log\Logger $logger
     */
    public function deleteStoreCategories($logger)
    {
        $categories = ObjectManager::getInstance()->get('Magento\Catalog\Model\CategoryFactory')
                                                  ->create()
                                                  ->getCollection();
        // $objectManager->get('Magento\Framework\Registry')->register('isSecureArea', true);

        foreach ($categories as $category) {
            if ($category->getId() <= 2) {
                continue;
            }

            try {
                $category->delete();
                $logger->info('Category with name: ' . $category->getName() . ' has been deleted.');
            } catch (\Exception $e) {
                $logger->error($e->getMessage());
            }
        }
    }
}
