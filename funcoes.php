<?php
//informar string, quantas palavras retorna limitaPalavras(string, num_palavras)
function limitaPalavras($string, $word_limit) {
   $words = explode(' ', $string);
   return implode(' ', array_slice($words, 0, $word_limit));
}
?>