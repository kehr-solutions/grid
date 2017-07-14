<?php

/**
 * @package    Website
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace ContaoBootstrap\Grid\Component;

use Contao\BackendTemplate;
use Contao\ContentModel;
use ContaoBootstrap\Grid\GridIterator;
use ContaoBootstrap\Grid\GridProvider;

/**
 * Trait ComponentTrait.
 *
 * @package ContaoBootstrap\Grid\Component
 */
trait ComponentTrait
{
    /**
     * Get the grid provider.
     *
     * @return GridProvider
     */
    protected function getGridProvider()
    {
        return static::getContainer()->get('contao_bootstrap.grid.grid_provider');
    }

    /**
     * Render the backend view.
     *
     * @param ContentModel $start    Start element.
     * @param GridIterator $iterator Iterator.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function renderBackendView($start, GridIterator $iterator = null)
    {
        $template = new BackendTemplate('be_bs_grid');

        if ($start) {
            $colorRotate = static::getContainer()->get('contao_bootstrap.core.helper.color_rotate');

            $template->name  = $start->bs_grid_name;
            $template->color = $colorRotate->getColor('ce:' . $start->id);
        }

        if (!$start) {
            $template->error = $GLOBALS['TL_LANG']['ERR']['bsGridParentMissing'];
        }

        if ($iterator) {
            $template->classes = $iterator->current();
        }

        return $template->parse();
    }

    /**
     * Check if we are in backend mode.
     *
     * @return bool
     */
    protected function isBackendRequest()
    {
        $scopeMatcher   = static::getContainer()->get('contao.routing.scope_matcher');
        $currentRequest = static::getContainer()->get('request_stack')->getCurrentRequest();

        return $scopeMatcher->isBackendRequest($currentRequest);
    }

    /**
     * Get the iterator.
     *
     * @return GridIterator
     */
    abstract protected function getIterator();
}
