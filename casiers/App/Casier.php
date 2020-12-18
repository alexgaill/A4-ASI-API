<?php

class Casier extends General{

    public function open()
    {
        echo "Le casier est ouvert";
    }

    public function close()
    {
        echo "Le casier est fermé";

    }

    public function getReserved()
    {
        echo "La liste des casiers";
        
    }

    public function getAll()
    {
        echo "Tous les casiers";

    }

    public function maintenance()
    {
        echo "Le casier est en maintenance";

    }

    public function activate()
    {
        echo "Le casier est utilisable";
        
    }
}