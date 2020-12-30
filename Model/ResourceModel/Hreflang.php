<?php
/**
 * @author: Pasquale Convertini <pasqualeconvertini95@gmail.com>
 * @github: @Pasquale95
 *
 * This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 */

namespace Seo\Hreflang\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Seo\Hreflang\Api\Data\HreflangInterface;

class Hreflang extends AbstractDb
{
    /**
     * Table name
     */
    const TABLE_NAME = "hreflang";

    /**
     * Hreflang resource model constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Resource model constructor to define table name and primary key
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, HreflangInterface::HREFLANG_ID);
    }
}
