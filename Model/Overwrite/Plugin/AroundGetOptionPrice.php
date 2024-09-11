<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types = 1);

namespace MageWorx\HideOptionPrice\Model\Overwrite\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Pricing\Helper\Data as PricingHelper;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Magento\Tax\Helper\Data as TaxHelper;
use MageWorx\OptionBase\Helper\Data as BaseHelper;
use MageWorx\OptionBase\Helper\Price as BasePriceHelper;
use MageWorx\OptionFeatures\Helper\Data as Helper;
use MageWorx\OptionFeatures\Model\Price as AdvancedPricingPrice;
use MageWorx\OptionFeatures\Plugin\AroundGetOptionPrice as OptionFeaturesAroundGetOptionPrice;

/**
 * Overwrite original plugin to remove a price from the option
 */
class AroundGetOptionPrice extends OptionFeaturesAroundGetOptionPrice
{
    protected ScopeConfigInterface $scopeConfig;

    public function __construct(
        Helper               $helper,
        BaseHelper           $baseHelper,
        BasePriceHelper      $basePriceHelper,
        TaxHelper            $taxHelper,
        StoreManager         $storeManager,
        AdvancedPricingPrice $advancedPricingPrice,
        PricingHelper        $pricingHelper,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($helper, $baseHelper, $basePriceHelper, $taxHelper, $storeManager, $advancedPricingPrice, $pricingHelper);
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get extended option price as string
     *
     * @param \Magento\Catalog\Model\Product\Option|\Magento\Catalog\Model\Product\Option\Value $model
     * @param integer $qty
     * @return string
     */
    protected function getOptionPriceAsString($model, $qty): string
    {
        if ($this->scopeConfig->isSetFlag('mageworx_apo/optionfeatures/hide_selected_value_price')) {
            return '';
        }

        return parent::getOptionPriceAsString($model, $qty);
    }
}
