<?php


namespace Rulya\NovaLocalizableModel\Actions;

use Laravel\Nova\Http\Requests\NovaRequest;

class SaveValueByAttribute
{

    public static function execute(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $localeAttr = $request->get('default_locale_attr');

        $relationName = $request->get('default_locales_relation_name');
        $currentLocale = $request->get("{$relationName}_selected_locale");

        $value = $request->get("{$currentLocale}_{$attribute}");

        $model->{$relationName}()
            ->where($localeAttr, $currentLocale)
            ->update([
                $attribute => $value
            ]);
    }
}