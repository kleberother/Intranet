<?php
class extranet extends controllers
    {
        public function index($tipo)
            {
                home::execute($tipo);
            }
    }

?>