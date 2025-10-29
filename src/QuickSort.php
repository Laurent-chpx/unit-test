<?php
final class QuickSortClass
{
    function QuickSort(array $arr, ?callable $cmp = null): array
    {
        //Exception pour vérifier que le tableau n'est pas vide
        if (count($arr) < 1){
            throw new Exception('empty array');
        }

        //Exception pour vérifier que les type sont les mêmes
        $firstTypeElement = gettype($arr[0]);
        foreach ($arr as $element) {
            if(gettype($element) !== $firstTypeElement){
                throw new Exception('mixed type ');
            }
        }

       //Exception pour les tableaux multidimensionnels
        foreach ($arr as $element) {
            if(is_array($element)){
                throw new Exception('multidimensional array');
            }
        }


        $arr = array_values($arr);
        if ($cmp === null) {
            $cmp = static function ($a, $b): int {
                return $a <=> $b;
            };
        }

        $swap = static function (array &$a, int $i, int $j): void {
            if ($i !== $j) {
                $tmp   = $a[$i];
                $a[$i] = $a[$j];
                $a[$j] = $tmp;
            }
        };

        $partition = static function (array &$a, int $lo, int $hi) use ($cmp, $swap): int {
            $pivotIndex = random_int($lo, $hi);
            $swap($a, $pivotIndex, $hi);
            $pivot = $a[$hi];

            $i = $lo;
            for ($j = $lo; $j < $hi; $j++) {
                if ($cmp($a[$j], $pivot) <= 0) {
                    $swap($a, $i, $j);
                    $i++;
                }
            }
            $swap($a, $i, $hi);
            return $i;
        };

        $qs = static function (array &$a, int $lo, int $hi) use (&$qs, $partition) {
            while ($lo < $hi) {
                $p = $partition($a, $lo, $hi);
                if (($p - 1) - $lo < $hi - ($p + 1)) {
                    if ($lo < $p - 1) {
                        $qs($a, $lo, $p -1);
                    }
                    $lo = $p + 1;
                } else {
                    if ($p + 1 < $hi) {
                        $qs($a, $p + 1, $hi);
                    }
                    $hi = $p - 1;
                }
            }
        };

        if (count($arr) > 1) {
            $qs($arr, 0, count($arr) - 1);
        }

        return $arr;
    }
}