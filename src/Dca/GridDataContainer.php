<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace ContaoBootstrap\Grid\Dca;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use ContaoBootstrap\Core\Config;
use ContaoBootstrap\Grid\Model\GridModel;

class GridDataContainer
{
    /**
     * @var Config
     */
    private $config;

    /**
     * GridDataContainer constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function initializePalette()
    {
        if (\Input::get('act') === 'edit') {
            $model = GridModel::findByPk(\Input::get('id'));
            $sizes = array_map(
                function ($value) {
                    return $value . 'Size';
                },
                deserialize($model->sizes, true)
            );

            PaletteManipulator::create()
                ->addField($sizes, 'sizes')
                ->applyToPalette('default', 'tl_grid');

        }
    }

    public function generateLabel($row)
    {
        return sprintf(
            '%s <div class="tl_gray">%s</div>',
            $row['title'],
            $row['description']
        );
    }

    /**
     *
     */
    public function getWidths()
    {
        $columns = $this->getColumns();
        $values  = ['auto'];

        return array_merge($values, range(0, $columns));
    }

    /**
     * @return array
     */
    public function getOrders()
    {
        $columns = $this->getColumns();
        $values  = [
            'flex' => ['unordered', 'first', 'last'],
            'push' => [],
            'pull' => [],
        ];

        for ($i = 0; $i <= $columns; $i++) {
            $values['push'][] = 'push-' . $i;
            $values['pull'][] = 'pull-' . $i;
        }

        return $values;
    }

    /**
     * @return array
     */
    public function getOffsets()
    {
        $columns = $this->getColumns();
        $values  = array_merge(
            ['null'],
            range(1, $columns)
        );

        return $values;
    }

    /**
     * @return mixed
     */
    private function getColumns()
    {
        return $this->config->get('grid.columns', 12);
    }
}
