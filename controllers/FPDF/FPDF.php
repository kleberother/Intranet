<?php
class cont_FPDF extends controllers
    {
        public function index($tipo)
            {
                home::execute($tipo);
            }
    }

?>