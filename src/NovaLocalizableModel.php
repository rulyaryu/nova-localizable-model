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

    private $isCreateMode = false;

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->localeAttribute(config('nova-localizable-model.locale_attribute'))
            ->localeVariants(config('nova-localizable-model.locale_variants'))
            ->localesRelation(config('nova-localizable-model.locales_relation'))
            ->creationDefaultLocale(config('nova-localizable-model.creation_default_locale'));

        $request = new NovaRequest(request()->all());

        $this->isCreateMode = $request->isCreateOrAttachRequest();

    }

    public function localeAttribute(string $localeAttribute = 'locale'): NovaLocalizableModel
    {
        return $this->withMeta(compact('localeAttribute'));
    }

    public function creationDefaultLocale(string $creationDefaultLocale = 'ru'): NovaLocalizableModel
    {
        return $this->withMeta(compact('creationDefaultLocale'));
    }


    public function localeVariants(array $localeVariants = [['lang' => 'ru', 'label' => 'Русский']]): NovaLocalizableModel
    {
        return $this->withMeta(compact('localeVariants'));
    }

    public function localesRelation(string $defaultLocalesRelationName = 'locales'): NovaLocalizableModel
    {
        return $this->withMeta(compact('defaultLocalesRelationName'));
    }


    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {


        $relationName = $request->get('default_locales_relation_name');

        $currentLocale = $request->get("{$relationName}_selected_locale");

        $localeRequest = json_decode($request->get($attribute), true);

        $localeAttr = $request->get('default_locale_attr');

        $localeData = collect($localeRequest)->except(['id', 'created_at'])->toArray();

        if($request->isCreateOrAttachRequest()) {

            $class = get_class($model);

            $class::saved(function ($model) use ($localeData, $currentLocale, $localeAttr, $relationName) {
                $model->{$relationName}()->create(
                    array_merge([$localeAttr => $currentLocale], $localeData)
                );
            });

        } else {
            $model->{$attribute}()->where($localeAttr, $currentLocale)->update(
                $localeData
            );
        }

    }

    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'isCreateMode' => $this->isCreateMode
        ]);
    }

}
