<?php


namespace Rulya\NovaLocalizableModel;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;
use Rulya\NovaLocalizableModel\Traits\FillAttribute;

class BooleanLocaleField extends Boolean
{

    use FillAttribute;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'boolean-locale';


}