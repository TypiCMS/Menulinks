<?php
namespace TypiCMS\Modules\Menulinks\Http\Requests;

use TypiCMS\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest {

    public function rules()
    {
        $rules = [
            'menu_id'  => 'required',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.url'] = 'url';
            $rules[$locale . '.uri'] = 'regex:/^[\pL\pM\pN\/_-]+$/'; // AlphaDash + '/'
        }
        return $rules;
    }
}
