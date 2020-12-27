<?php
/**
 * @author Pasquale Convertini (@Pasquale95)
 *
 * This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 */

namespace Seo\Hreflang\Model\Resolver\CmsPage;

use Magento\Cms\Api\Data\PageInterface;
use Magento\CmsUrlRewrite\Model\CmsPageUrlRewriteGenerator;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Seo\Hreflang\Helper\Hreflang as HreflangHelper;

/**
 * Class to resolve hreflang field in CmsPage GraphQL query
 */
class Hreflang implements ResolverInterface
{
    /**
     * @var HreflangHelper
     */
    protected $hreflangHelper;

    /**
     * @param HreflangHelper $hreflangHelper
     */
    public function __construct(
        HreflangHelper $hreflangHelper
    ) {
        $this->hreflangHelper = $hreflangHelper;
    }

    /**
     * Fetches the data from persistence models and format it according to the GraphQL schema.
     *
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|Value
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $hreflang = $this->hreflangHelper->getStoresHrefLang(
            $value[PageInterface::IDENTIFIER],
            CmsPageUrlRewriteGenerator::ENTITY_TYPE
        );
        $hreflangList = [];
        foreach ($hreflang as $code => $url) {
            array_push(
                $hreflangList,
                [
                    'code' => $code,
                    'href' => $url
                ]
            );
        }
        return empty($hreflangList) ? null : $hreflangList;
    }
}
