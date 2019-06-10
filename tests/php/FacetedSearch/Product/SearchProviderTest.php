<?php
/**
 * 2007-2019 PrestaShop.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\Module\FacetedSearch\Tests\Product;

use Ps_Facetedsearch;
use Db;
use Context;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PrestaShop\Module\FacetedSearch\Filters\Converter;
use PrestaShop\Module\FacetedSearch\URLSerializer;
use PrestaShop\Module\FacetedSearch\Product\SearchProvider;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchResult;

class SearchProviderTest extends MockeryTestCase
{
    /**
     * @var Search
     */
    private $provider;

    /**
     * @var Db
     */
    private $database;

    /**
     * @var Context
     */
    private $context;

    protected function setUp()
    {
        $this->database = Mockery::mock(Db::class);
        $this->context = Mockery::mock(Context::class);
        $this->converter = Mockery::mock(Converter::class);
        $this->serializer = Mockery::mock(URLSerializer::class);
        $this->module = Mockery::mock(Ps_Facetedsearch::class);
        $this->module->shouldReceive('getDatabase')
            ->andReturn($this->database);
        $this->module->shouldReceive('getContext')
            ->andReturn($this->context);

        $this->provider = new SearchProvider(
            $this->module,
            $this->converter,
            $this->serializer
        );
    }

    public function testRenderFacetsWithoutFacetsCollection()
    {
        $context = Mockery::mock(ProductSearchContext::class);
        $productSearchResult = Mockery::mock(ProductSearchResult::class);
        $productSearchResult->shouldReceive('getFacetCollection')
            ->once()
            ->andReturn([]);

        $this->assertEquals(
            '',
            $this->provider->renderFacets(
                $context,
                $productSearchResult
            )
        );
    }
}
