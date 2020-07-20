<?php


namespace Rulya\NovaLocalizableModel\Actions;


class SaveValueByAttribute
{

    public static function execute($request, $requestAttribute, $model, $attribute)
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