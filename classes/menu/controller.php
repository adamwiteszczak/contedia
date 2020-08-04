<?php
namespace Classes\Menu;

use Classes\Db;

class Controller
{
    private $db;
    private $menu_table = 'site_menu';
    private $menu_item_table = 'site_menu_item';

    public function __construct()
    {
        $this->db = new Db();
    }

    public function createMenu($name)
    {
        $menu_id = $this->db->insert(
            'INSERT INTO ' . $this->menu_table . '(name) values (:name)',
            array('name' => $name)
        );

        return $menu_id;
    }

    public function getMenuByName($name)
    {
        /**
         * grab all menu + submenu items out in one query and sort the data in code, which should be more efficient
         * than making multiple queries to get the structure:
         */
        $sql = 'SELECT sm.name as menu_name, sm.id, smi.id, smi.label, smi.parent_id, smi.menu_order, smi.menu_class FROM site_menu sm ' .
            'INNER JOIN site_menu_item smi on smi.menu_id = sm.id ' .
            'ORDER BY smi.menu_order';

        $result = $this->db->query($sql);
        $temp = array();

        //pull all data out into a flat array
        while ($row = $result->fetch()) {
            $temp = array_merge($temp, array($row));
        }

        return $this->getChildren($temp);
    }

    public function addMenuItem($menu_id, $label, $menu_order, $class = null, $parent = null)
    {
        $menu_item_id = $this->db->insert(
            'INSERT INTO ' . $this->menu_item_table . '(label, menu_id, parent_id, menu_order, menu_class) 
            values (:label, :menu_id, :parent, :order, :class)',
            array('label' => $label, 'menu_id' => $menu_id, 'parent' => $parent, 'order' => $menu_order, 'class' => $class)
        );

        return $menu_item_id;
    }

    private function getChildren($tmp, $parent_id = null)
    {
        $items = array();

        foreach($tmp as $key => $menu_item) {
            if ($menu_item['parent_id'] == $parent_id) {
                $items[$key] = $menu_item;
            }
        }

        if (!empty($items)) {
            foreach ($items as &$item) {
                $item['children'] = $this->getChildren($tmp, $item['id']);
            }
        }

        return $items;
    }

}