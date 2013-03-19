<?php
class REQUESTS extends controllers
    {
        public function index($tipo)
            {
                home::execute($tipo);
            }
    }
?>