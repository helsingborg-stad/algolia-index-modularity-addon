<?php

namespace AlgoliaIndexModularityAddon;

class App
{
    public function __construct()
    {
        //Add rendered modules to content

        //Remove mod-* posttypes from indexable results. 

        //add_filter('AlgoliaIndex/Record', array($this, 'addModularityModule')); 
        add_filter('AlgoliaIndex/IndexablePostTypes', array($this, 'removeModularityPostTypes')); 
    }

    public function addModularityModule () {

    }

    /**
     * Remove mod-* posttypes
     *
     * @param array $postTypes
     * @return array $postTypes
     */
    public function removeModularityPostTypes ($postTypes) {
        //Remove mod-* posttypes 
        if(is_array($postTypes) && !empty($postTypes)) {
            $filteredResult = array();
            foreach($postTypes as $postType) {
                if(substr($postType, 0, 4) != "mod-") {
                    $filteredResult[] = $postType;  
                }
            }
            return $filteredResult; //Return filtered
        }
        return $postTypes; //Not valid, return original
    }
}
