<?php

namespace AlgoliaIndexModularityAddon;

class App
{
    public function __construct()
    {
        //Check for modularity & algolia index plugins
        add_action('plugins_loaded', function() {
            if(!class_exists('\Modularity\App') || !class_exists('\AlgoliaIndex\App')) {
                add_action('admin_notices', array($this, 'displayAdminNotice'));
            }
        });

        //Add rendered post module content to post content 
        add_filter('AlgoliaIndex/Record', array($this, 'addModularityModule'), 10, 2); 

        //Remove posttypes from modularity
        add_filter('AlgoliaIndex/IndexablePostTypes', array($this, 'removeModularityPostTypes'), 10, 1); 
    }

    /**
     * Display admin notice (missing plugins error)
     *
     * @return void
     */
    public function displayAdminNotice() {
        echo '<div class="notice notice-error"><p>';
        _e(
            "Modularity or Algolia Index not found, Algolia Modularity Addon will have no effect. 
            Install Modularity and Algolia Index or disable Algolia Modularity Addon.",
            'algolia-index-modularity-addon'
        );
        echo '</p></div>';
    }

    /**
     * Add modularity content to content field
     *
     * @param   array       $result     The stuff to be indexed. 
     * @param   integer     $postId     Current post id to index
     * 
     * @return  array       $result     The stuff to be indexed, with modularity content. 
     */
    public function addModularityModule ($result, $postId) {

        //Add content if not exists
        if(!isset($result['content'])) {
            $result['content'] = ""; 
        }

        //Add modules to content
        $result['content'] = $result['content'] . "\r\n" . $this->getRenderedPostModules($postId); 

        //Return index record, with module content. 
        return $result;
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

    /**
     * Render all modules on post
     * @param  integer $postId
     * @return string
     */
    public function getRenderedPostModules($postId)
    {
        if (!is_numeric($postId)) {
            return;
        }

        $modules = \Modularity\Editor::getPostModules($postId);
        $onlyModules = array();

        // Normalize modules array
        foreach ($modules as $sidebar => $item) {
            if (!isset($item['modules']) || count($item['modules']) === 0) {
                continue;
            }

            $onlyModules = array_merge($onlyModules, $item['modules']);
        }

        // Render modules and append to post content
        $rendered = "\r\n\r\n";
        foreach ($onlyModules as $module) {
            if ($module->post_type === 'mod-wpwidget') {
                continue;
            }

            //Get output for module
            $output = \Modularity\App::$display->outputModule(
                $module, 
                array('edit_module' => false), 
                array(), false
            );

            //Concat to end result
            if(!empty($output)) {
                $rendered .= "\r\n" . strip_tags($output);
            }
        }

        return $rendered;
    }
}
