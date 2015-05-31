<?php

class Micro_Accessor_DaoAccessor
{
    private $_daos = array();

    public function __construct(array $daos)
    {
        foreach ($daos as $dao) {
            // Generate dao class name
            $dao_elements = explode('_', $dao);
            foreach ($dao_elements as &$dao_element) {
                $dao_element = ucfirst($dao_element);
            }
            $dao_class = ucfirst(Micro::$id) . '_Dao_' . implode('_', $dao_elements);

            // Load dao class
            $dao_file = Micro::$app_root_dir . '/dao/' . str_replace('_', '/', implode('_', $dao_elements)) . '.php';
            if ( ! file_exists($dao_file)) {
                error_log("## Error : $dao_file not found.");
                continue;
            }
            require_once($dao_file);

            $this->_daos[$dao] = new $dao_class;
        }
    }

    public function __get($name)
    {
        return $this->_daos[$name];
    }

}