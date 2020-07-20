<?php


namespace Rulya\NovaLocalizableModel;

use Laravel\Nova\Fields\Textarea;
use Rulya\NovaLocalizableModel\Actions\SaveValueByAttribute;
use Laravel\Nova\Http\Requests\NovaRequest;

class TextAreaLocaleField extends Textarea
{

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'textarea-locale';



    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {

        SaveValueByAttribute::execute($request, $requestAttribute, $model, $attribute);

    }

}