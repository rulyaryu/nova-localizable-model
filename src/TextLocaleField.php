<?php


namespace Rulya\NovaLocalizableModel;

use Laravel\Nova\Fields\Field;
use Rulya\NovaLocalizableModel\Actions\SaveValueByAttribute;
use Laravel\Nova\Http\Requests\NovaRequest;


class TextLocaleField extends Field
{

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'text-locale';



    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {

        SaveValueByAttribute::execute($request, $requestAttribute, $model, $attribute);

    }

}