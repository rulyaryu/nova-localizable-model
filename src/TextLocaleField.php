<?php


namespace Rulya\NovaLocalizableModel;

use Laravel\Nova\Fields\Field;
use Rulya\NovaLocalizableModel\Actions\SaveValueByAttribute;
use Laravel\Nova\Http\Requests\NovaRequest;
use Rulya\NovaLocalizableModel\Traits\FillAttribute;


class TextLocaleField extends Field
{

    use FillAttribute;
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'text-locale';


    public function emitValue(string $eventName): TextLocaleField
    {
        return $this->withMeta(compact('eventName'));
    }

}