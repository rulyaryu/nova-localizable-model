<?php


namespace Rulya\NovaLocalizableModel\Traits;


use Laravel\Nova\Http\Requests\NovaRequest;


trait FillAttribute
{

    protected $parentAttributeCanBeUpdated = true;

    public function updateParentAttribute(bool $parentAttributeCanBeUpdated)
    {
        $this->parentAttributeCanBeUpdated = $parentAttributeCanBeUpdated;
        return $this;
    }

    protected function parentModelCanBeUpdated($request)
    {
        $preventCollisions = config('nova-localizable-model.prevent_parent_attribute_collisions');
        $updateParentWithLocale = config('nova-localizable-model.update_parent_with_locale');

        $relationName = $request->get('default_locales_relation_name');

        $currentLocale = $request->get("{$relationName}_selected_locale");

        return !$preventCollisions && $updateParentWithLocale === $currentLocale && $this->parentAttributeCanBeUpdated;
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {

        if ($this->parentModelCanBeUpdated($request)) return parent::fillAttributeFromRequest($request, $requestAttribute, $model, $attribute);

        if ($request->exists($requestAttribute)) {
            unset($request[$requestAttribute]);
        }

    }

}