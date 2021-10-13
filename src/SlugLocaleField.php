<?php


namespace Rulya\NovaLocalizableModel;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Rulya\NovaLocalizableModel\Traits\FillAttribute;


class SlugLocaleField extends Field
{

    use FillAttribute;
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'slug-locale';
    public $canBeUpdated = true;

    public function jsonSerialize()
    {
        /** @var NovaRequest $request */
        $request = app(NovaRequest::class);

        return array_merge([
            'canBeUpdated' => $this->canBeUpdated,
        ], parent::jsonSerialize());
    }


    public function eventName(string $eventName): SlugLocaleField
    {
        return $this->withMeta(compact('eventName'));
    }

    /**
     * @param bool $canBeUpdated
     * @return SlugLocaleField
     */
    public function setCanBeUpdated(bool $canBeUpdated = true): SlugLocaleField
    {
        $this->canBeUpdated = $canBeUpdated;
        return $this;
    }

}