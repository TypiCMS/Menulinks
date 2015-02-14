<?php
namespace TypiCMS\Modules\Menulinks\Http\Controllers;

use Lang;
use View;
use Illuminate\Database\Eloquent\Model;
use Input;
use Redirect;
use TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface;
use TypiCMS\Modules\Menulinks\Services\Form\MenulinkForm;
use TypiCMS\Http\Controllers\AdminNestedController;

class AdminController extends AdminNestedController
{

    public function __construct(MenulinkInterface $menulink, MenulinkForm $menulinkform)
    {
        parent::__construct($menulink, $menulinkform);
        $this->title['parent'] = Lang::choice('menulinks::global.menulinks', 2);
    }

    /**
     * Redirect to menu edit form
     * 
     * @param  $parent
     * @return Redirect
     */
    public function index($parent = null)
    {
        return Redirect::route('admin.menus.edit', $parent->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  $parent
     * @return void
     */
    public function create($parent = null)
    {
        $this->title['child'] = trans('menulinks::global.New');
        $model = $this->repository->getModel();
        $menu = $parent;
        $selectPages = $this->repository->getPagesForSelect();
        $selectModules = $this->repository->getModulesForSelect();

        return view('menulinks::admin.create')
            ->with(compact('model', 'menu', 'selectPages', 'selectModules'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $parent
     * @param  $model
     * @return void
     */
    public function edit($parent = null, $model)
    {
        $this->title['child'] = trans('menulinks::global.Edit');
        $menu = $parent;
        $selectPages = $this->repository->getPagesForSelect();
        $selectModules = $this->repository->getModulesForSelect();

        return view('menulinks::admin.edit')
            ->with(compact('model', 'menu', 'selectPages', 'selectModules'));
    }

    /**
     * Show resource.
     *
     * @param  $parent
     * @param  $model
     * @return Redirect
     */
    public function show($parent = null, $model)
    {
        return Redirect::route('admin.menus.menulinks.edit', [$parent->id, $model->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $parent
     * @return Redirect
     */
    public function store($parent = null)
    {
        if ($model = $this->form->save(Input::all())) {
            $redirectUrl = Input::get('exit') ? $parent->editUrl() : $model->editUrl() ;
            return Redirect::to($redirectUrl);
        }

        return Redirect::route('admin.menus.menulinks.create', $parent->id)
            ->withInput()
            ->withErrors($this->form->errors());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $parent
     * @param  $model
     * @return Redirect
     */
    public function update($parent = null, $model)
    {

        if ($this->form->update(Input::all())) {
            $redirectUrl = Input::get('exit') ? $parent->editUrl() : $model->editUrl() ;
            return Redirect::to($redirectUrl);
        }

        return Redirect::to($model->editUrl())
            ->withInput()
            ->withErrors($this->form->errors());

    }
}
