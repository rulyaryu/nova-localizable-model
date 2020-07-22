<?php

namespace Rulya\NovaLocalizableModel;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Rulya\NovaLocalizableModel\Helpers\RequestLocaleData;

class NovaLocalizableModel extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-localizable-model';

    private $isCreateMode = false;

    private $additionalLocalesToCreate = [];
    private $duplicateDataForLocalesOnCreate = true;

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->localeAttribute(config('nova-localizable-model.locale_attribute'))
            ->localeVariants(config('nova-localizable-model.locale_variants'))
            ->localesRelation(config('nova-localizable-model.locales_relation'))
            ->creationDefaultLocale(config('nova-localizable-model.creation_default_locale'))
            ->setAdditionalLocalesToCreate(config('nova-localizable-model.additional_locales_to_create'))
            ->setDuplicateDataForLocalesOnCreate(config('nova-localizable-model.duplicate_data_for_locales'));

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

    /**
     * @param array $additionalLocalesToCreate
     * @return NovaLocalizableModel
     */
    public function setAdditionalLocalesToCreate(array $additionalLocalesToCreate): NovaLocalizableModel
    {
        $this->additionalLocalesToCreate = $additionalLocalesToCreate;
        return $this;
    }

    /**
     * @param bool $duplicateDataForLocalesOnCreate
     * @return NovaLocalizableModel
     */
    public function setDuplicateDataForLocalesOnCreate(bool $duplicateDataForLocalesOnCreate): NovaLocalizableModel
    {
        $this->duplicateDataForLocalesOnCreate = $duplicateDataForLocalesOnCreate;
        return $this;
    }


    public function handleCreate($model, $localeRequest)
    {
        $class = get_class($model);

        $class::saved(function ($model) use ($localeRequest) {
            $model->{$localeRequest->relationName}()->create(
                array_merge([$localeRequest->localeAttr => $localeRequest->currentLocale], $localeRequest->localeData)
            );

            if (!count($this->additionalLocalesToCreate)) return;

            $defaultData = $this->duplicateDataForLocalesOnCreate ? $localeRequest->localeData : [];

            foreach ($this->additionalLocalesToCreate as $l) {
                $model->{$localeRequest->relationName}()->create(
                    array_merge([$localeRequest->localeAttr => $l], $defaultData)
                );
            }
        });
    }


    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {

        $localeRequest = new RequestLocaleData($request);

        if ($request->isCreateOrAttachRequest()) {
            $this->handleCreate($model, $localeRequest);
        } else {
            $model->{$attribute}()->where($localeRequest->localeAttr, $localeRequest->currentLocale)->update(
                $localeRequest->localeData
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
