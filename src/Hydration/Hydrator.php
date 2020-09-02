<?php

namespace BristolSU\ApiToolkit\Hydration;

class Hydrator
{

    public static function hydrate($subject, Hydrate $hydrate)
    {
        if($hydrate->type === 'array') {
            return array_map(function($singleModel) use ($hydrate) {
                return static::runHydration($singleModel, $hydrate);
            }, $subject);
        } elseif($hydrate->type === 'model') {
            return static::runHydration($subject, $hydrate);
        }
        throw new \Exception('Hydration failed. Make sure you either hydrate the model or array of models');
    }

    private static function runHydration($singleModel, Hydrate $hydrate)
    {
        $replacedModel = static::runReplace($singleModel, $hydrate->replace);
        foreach($hydrate->hydrate as $key => $childHydrate) {
            if(!array_key_exists($key, $replacedModel)) {
                throw new \Exception(sprintf('Key %s does not exist on the model and so could not be hydrated', $key));
            }
            $replacedModel[$key] = Hydrator::hydrate($replacedModel[$key], $childHydrate);
        }
        return $hydrate->model::createFromArray($replacedModel);
    }

    public static function runReplace($subject, $toReplace)
    {
        foreach($toReplace as $old => $new) {
            if(array_key_exists($old, $subject)) {
                $subject[$new] = $subject[$old];
                unset($subject[$new]);
            }
        }
        return $subject;
    }

}
