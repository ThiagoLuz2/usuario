<?php
namespace projetux\Math;
class Basic{
    /** 
    *@return int|float
    */
    public function soma(int|float $numero, int|float $numero2)
{
    return $numero + $numero2;
}
 /** 
    *@return int|float
    */
public function subtracao(int|float $numero, int|float $numero2)
{
    return $numero - $numero2;
}
 /** 
    *@return int|float
    */
public function muiti(int|float $numero, int|float $numero2)
{
    return $numero * $numero2;
}
 /** 
    *@return int|float
    */
public function divisao(int|float $numero, int|float $numero2)
{
    return $numero / $numero2;
}
 /** 
    *@return int|float
    */
public function raiz(int|float $numero)
{
    return sqrt($numero);
}
 /** 
    *@return int|float
    */
public function quadrado(int|float $numero)
{
    return pow($numero,2);
}
}