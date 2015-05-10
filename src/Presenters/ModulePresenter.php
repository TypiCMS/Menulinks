<?php
namespace TypiCMS\Modules\Menulinks\Presenters;

use Laracasts\Presenter\Presenter;

class ModulePresenter extends Presenter
{

    public function menuclass()
    {
        return $this->entity->menuclass;
    }
}
