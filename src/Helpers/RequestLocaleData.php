<?php


namespace Rulya\NovaLocalizableModel\Helpers;

use Laravel\Nova\Http\Requests\NovaRequest;


class RequestLocaleData
{


    public $localeData;
    public $relationName;
    public $currentLocale;
    public $localeAttr;

    public function __construct(NovaRequest $request)
    {
        $this->relationName = $request->get('default_locales_relation_name');

        $this->currentLocale = $request->get("{$this->relationName}_selected_locale");

        $this->localeAttr = $request->get('default_locale_attr');

        $this->localeData = $request->get("locales-payload");
    }
}