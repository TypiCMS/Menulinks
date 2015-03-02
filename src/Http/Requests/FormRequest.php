<?php
namespace TypiCMS\Modules\Menulinks\Http\Requests;

use TypiCMS\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest {

    public function rules()
    {
        $rules = [
            'menu_id'    => 'required',
            'class'      => 'max:255',
            'icon_class' => 'max:255',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.title'] = 'max:255';
            $rules[$locale . '.url']   = 'max:255|url';
        }
        return $rules;
    }

    /**
     * Sanitize inputs
     * 
     * @return array
     */
    public function sanitize()
    {
        $input = $this->all();

        // Checkboxes
        $input['parent_id'] = $this->get('parent_id') ? : null ;
        $input['has_categories'] = $this->get('has_categories', 0);
        foreach (config('translatable.locales') as $locale) {
            $input[$locale]['status'] = $this->has($locale . '.status');
        }

        $this->replace($input);
        return $this->all();
    }
}
