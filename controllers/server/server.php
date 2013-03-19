<?php
class server extends controllers
    {
        public function index($tipo)
            {
                home::execute($tipo);
            }
    }

?>
