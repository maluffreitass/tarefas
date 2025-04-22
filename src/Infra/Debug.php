<?php 

namespace Projetux\Infra;

class Debug{
     
    public function debug(string $texto): string 
    {
        return "Debug: {$texto}";
    }
}