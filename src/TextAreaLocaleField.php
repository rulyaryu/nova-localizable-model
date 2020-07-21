<?php


namespace Rulya\NovaLocalizableModel;

use Laravel\Nova\Fields\Textarea;
use Rulya\NovaLocalizableModel\Actions\SaveValueByAttribute;
use Laravel\Nova\Http\Requests\NovaRequest;
use Rulya\NovaLocalizableModel\Traits\FillAttribute;

class TextAreaLocaleField extends Textarea
{
    use FillAttribute;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'textarea-locale';





}