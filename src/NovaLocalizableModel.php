<?php

namespace Rulya\NovaLocalizableModel;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class NovaLocalizableModel extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-localizable-model';

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->localeAttribute(config('nova-localizable-model.locale_attribute'))
            ->localeVariants(config('nova-localizable-model.locale_variants'))
            ->localesRelation(config('nova-localizable-model.locales_relation'));

    }

    public function localeAttribute(string $localeAttribute = 'locale')
    {
        return $this->withMeta(compact('localeAttribute'));
    }


    public function localeVariants(array $localeVariants = [
        ['lang' => 'ru', 'label' => 'Русский'],
        ['lang' => 'en', 'label' => 'Английский']
    ])
    {
        return $this->withMeta(compact('localeVariants'));
    }

    public function localesRelation(string $defaultLocalesRelationName = 'locales')
    {
        return $this->withMeta(compact('defaultLocalesRelationName'));
    }


    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {


//        $currentLocale = $request->get("{$attribute}_selected_locale");

//        $localeRequest = json_decode($request->get($attribute), true);
//
//        $localeData = collect($localeRequest)->except(['id', 'created_at'])->toArray();
//
//        $model->{$attribute}()->where('locale', $currentLocale)->update(
//            $localeData
//        );

    }

}
