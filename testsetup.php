<?php
require 'bootstrap.php';
$db = new Classes\Db();

/**
 * In a production environment, I'd have some kind of upgrade system in place to be able to make changes like this,
 * but for the purposes of this test, I'll just hard code in the tables here:
 * ~~Adam~~
 */

$site_menu = 'CREATE TABLE site_menu (id INT NOT NULL AUTO_INCREMENT, name VARCHAR(255) NOT NULL , PRIMARY KEY (id))';
$site_menu_item = 'CREATE TABLE site_menu_item 
    (id INT NOT NULL AUTO_INCREMENT, 
    label VARCHAR(255) NOT NULL, 
    menu_id INT NOT NULL,
    parent_id INT NULL,
    menu_order INT NOT NULL,
    menu_class VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    )';

//create tables:
$db->raw($site_menu);
$db->raw($site_menu_item);

//create menu structure:
$menu_controller = new \Classes\Menu\Controller();

$main_menu_id = $menu_controller->createMenu('main_menu');
$menu1 = $menu_controller->addMenuItem($main_menu_id, 'main_menu_sample_1', '1', 'mdi-plus-circle-outline', null);
$menu2 = $menu_controller->addMenuItem($main_menu_id, 'main_menu_sample_2', '2', 'mdi-magnify', null);
$menu3 = $menu_controller->addMenuItem($main_menu_id, 'main_menu_sample_3', '3', 'mdi-medical-bag', null);

//menu3 submenus
//since they are all the same, let's cheat and use a loop:
for ($i = 0; $i < 5; $i++) {
    $menu_controller->addMenuItem($main_menu_id, 'main_menu_submenu_' . $i, $i, null, $menu3);
}

echo "tables and test data created!";
