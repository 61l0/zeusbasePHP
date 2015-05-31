<?php

class Micro_Accessor_ModuleAccessor
{
    private $_modules = array();

    public function __construct(array $modules)
    {
        foreach ($modules as $module) {
            // Generate module class name
            $module_elements = explode('_', $module);
            foreach ($module_elements as &$module_element) {
                $module_element = ucfirst($module_element);
            }
            $module_class = ucfirst(Micro::$id) . '_Module_' . implode('_', $module_elements);

            // Load module class
            $module_file = Micro::$app_root_dir . '/module/' . str_replace('_', '/', implode('_', $module_elements)) . '.php';
            if ( ! file_exists($module_file)) {
                throw new Exception("## Error : $module_file not found.");
            }
            require_once($module_file);

            $this->_modules[$module] = new $module_class;
        }
    }

    public function __get($name)
    {
        return $this->_modules[$name];
    }

}