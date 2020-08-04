<?php
namespace Api\Endpoint;

class Menu extends \Classes\Api
{
    //method name => request type (get/post)
    protected $available_methods = array(
        'getbyname' => 'GET'
    );

    public function getByName($request)
    {
        $menu_name = $request->requireParam('menu_name');
        $menu_controller = new \Classes\Menu\Controller();
        return $menu_controller->getMenuByName($menu_name);
    }
}