<?php
/**
 * @author: Pasquale Convertini <pasqualeconvertini95@gmail.com>
 * @github: @Pasquale95
 *
 * This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 */

namespace Paskel\Seo\Model\SocialMarkup;

use Magento\CatalogGraphQl\Model\Resolver\Products\DataProvider\Image\Placeholder as PlaceholderProvider;
use Magento\Framework\Exception\LocalizedException;
use Magento\StoreGraphQl\Model\Resolver\Store\StoreConfigDataProvider;
use Paskel\Seo\Api\Data\SocialMarkupInterface;
use Paskel\Seo\Helper\Hreflang as HreflangHelper;

/**
 * Class AbstractSocialMarkup
 * @package Paskel\Seo\Model\Resolver\SocialMarkup
 */
abstract class AbstractSocialMarkup implements SocialMarkupInterface
{
    protected $socialMarkups = [];

    /**
     * @var StoreConfigDataProvider
     */
    protected $storeConfigDataProvider;

    /**
     * @var HreflangHelper
     */
    protected $hreflangHelper;

    /**
     * @var PlaceholderProvider
     */
    protected $placeholderProvider;

    /**
     * AbstractSocialMarkup constructor.
     *
     * @param StoreConfigDataProvider $storeConfigsDataProvider
     * @param HreflangHelper $hreflangHelper
     * @param PlaceholderProvider $placeholderProvider
     */
    public function __construct(
        StoreConfigDataProvider $storeConfigsDataProvider,
        HreflangHelper $hreflangHelper,
        PlaceholderProvider $placeholderProvider
    ) {
        $this->storeConfigDataProvider = $storeConfigsDataProvider;
        $this->hreflangHelper = $hreflangHelper;
        $this->placeholderProvider = $placeholderProvider;
    }

    /**
     * @inheritDoc
     */
    public function setType($type) {
        $this->wrapSocialMarkup(self::TYPE, $type);
    }

    /**
     * @inheritDoc
     */
    public function setLocale($locale) {
        $this->wrapSocialMarkup(self::LOCALE, $locale);
    }

    /**
     * @inheritDoc
     */
    public function setSitename($sitename) {
        $this->wrapSocialMarkup(self::SITENAME, $sitename);
    }

    /**
     * @inheritDoc
     */
    public function setUrl($url) {
        $this->wrapSocialMarkup(self::URL, $url);
    }

    /**
     * @inheritDoc
     */
    public function setTitle($title) {
        $this->wrapSocialMarkup(self::TITLE, $title);
    }

    /**
     * @inheritDoc
     */
    public function setDescription($description) {
        $this->wrapSocialMarkup(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function setImage($image) {
        $this->wrapSocialMarkup(self::IMAGE, $image);
    }

    /**
     * Returns the specific property-content properly wrapped
     *
     * @param $property
     * @param $content
     * TODO: add config to set/unset null values in graphql
     */
    public function wrapSocialMarkup($property, $content) {
        if ($content != null) {
            array_push($this->socialMarkups,
                [
                    self::PROPERTY => $property,
                    self::CONTENT => $content
                ]
            );
        }
    }

    /**
     * Retrieve full url using hreflang table.
     *
     * @param $entityId
     * @param $entityType
     * @param $storeId
     * @return string|null
     */
    public function retrieveUrl($entityId, $entityType, $storeId) {
        try {
            $hreflang = $this->hreflangHelper->getStoreHreflang(
                $entityId,
                $entityType,
                $storeId
            );
            return $hreflang->getUrl();
        }
        catch (LocalizedException $e) {
            return null;
        }
    }
}
