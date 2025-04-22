<?php
 
namespace Projetux\Math;
 
class Basic
{
  /**
   * @return int|float
   */
    public function soma(int|float $numero, int|float $numero2)
   {
    return $numero + $numero2;
   }
 
   /**
    * @return int|float
    */
    public function subtrai(int|float $numero, int|float $numero2)
    {
        return $numero - $numero2;
    }
 
    //criar funçoões para multiplicar, dividir, raiz quadrada e
 
    //potenciação, e criar um arquivo de teste para cada função
    //com os testes unitários.
    public function multiplica(int|float $numero, int|float $numero2)
    {
        return $numero * $numero2;
    }
 
    public function divide(int|float $numero, int|float $numero2)
    {
        return $numero / $numero2;
    }
 
    public function elevaAoQuadrado(int|float $numero)
    {
        return $numero **2;
    }

    public function raizQuadrada(int|float $numero)
    {
        return sqrt($numero);
    }
}