<?php

/**
 * @package    Website
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace ContaoBootstrap\Grid\Component\ContentElement;

use Contao\ContentElement;

class GridStopElement extends ContentElement
{
    protected $strTemplate = 'ce_grid_stop';

    public function generate()
    {
        // TODO: Rewrite using ScopeMatcher since Contao 4.4. is released
        if (TL_MODE === 'BE') {
            return '';
        }

        return parent::generate();
    }

    protected function compile()
    {
    }
}
