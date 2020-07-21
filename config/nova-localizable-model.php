<?php

return [

    'locale_attribute' => 'locale',

    'locale_variants' => [
        ['lang' => 'ru', 'label' => 'Русский'],
        ['lang' => 'en', 'label' => 'Английский']
    ],

    'locales_relation' => 'locales',

    'creation_default_locale' => 'ru',

    'prevent_parent_attribute_collisions' => false,

    'update_parent_with_locale' => 'ru'


];