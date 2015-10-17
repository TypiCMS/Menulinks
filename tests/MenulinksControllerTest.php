<?php

use TypiCMS\Modules\Menulinks\Models\Menulink;

class MenulinksControllerTest extends TestCase
{
    public function testStoreFails()
    {
        $input = [];
        $this->call('POST', 'admin/menus/1/menulinks', $input);
        $this->assertRedirectedToRoute('admin.menus.menulinks.create', ['menu_id' => 1]);
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new Menulink();
        $object->menu_id = 1;
        $object->id = 1;
        Menulink::shouldReceive('create')->once()->andReturn($object);
        $input = ['fr.title' => 'test', 'menu_id' => '1'];
        $this->call('POST', 'admin/menus/1/menulinks', $input);
        $this->assertRedirectedToRoute('admin.menus.menulinks.edit', ['menu_id' => 1, 'id' => 1]);
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new Menulink();
        $object->id = 1;
        Menulink::shouldReceive('create')->once()->andReturn($object);
        $input = ['fr.title' => 'test', 'menu_id' => '1', 'exit' => true];
        $this->call('POST', 'admin/menus/1/menulinks', $input);
        $this->assertRedirectedToRoute('admin.menus.edit', ['menu_id' => 1]);
    }
}
