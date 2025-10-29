<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/QuickSort.php';
use PHPUnit\Framework\TestCase;


final class QuickSortTest extends TestCase
{
    public function test_sort_int(): void // Test de la fonction
    {
        $funcSort = new QuickSortClass();
        $unsorted = [5, 2, 1, 4, 3];
        $sorted = [1, 2, 3, 4, 5];
        $result = $funcSort->QuickSort($unsorted);
        $this->assertSame($sorted, $result);
    }
    public function test_sort_array_sorted(): void // Vérifie que le tri fonctionne même sur un tableau filtré
    {
        $funcSort = new QuickSortClass();
        $unsorted = [1, 2, 3, 4, 5];
        $sorted = [1, 2, 3, 4, 5];
        $result = $funcSort->QuickSort($unsorted);
        $this->assertSame($sorted, $result);
    }
    public function test_sort_array_width_duplicated(): void // Vérifie le test avec des doublons
    {
        $funcSort = new QuickSortClass();
        $unsorted = [5, 2, 8, 2, 9, 5, 1];
        $sorted = [1, 2, 2, 5, 5, 8, 9];
        $result = $funcSort->QuickSort($unsorted);
        $this->assertSame($sorted, $result);
    }
    public function test_sort_single_value(): void // Vérifie le tri sur une valeur seul
    {
        $funcSort = new QuickSortClass();
        $unsorted = [1];
        $sorted = [1];
        $result = $funcSort->QuickSort($unsorted);
        $this->assertSame($sorted, $result);
    }
    public function test_sort_float(): void // Vérifie que le tri fonctionne sur les nombres à virgule
    {
        $funcSort = new QuickSortClass();
        $unsorted = [3.5, 1.2, 4.8, 2.1];
        $sorted = [1.2, 2.1, 3.5, 4.8];
        $result = $funcSort->QuickSort($unsorted);
        $this->assertSame($sorted, $result);
    }
    public function test_sort_char(): void // Vérifie que le tri fonctionne sur les chaines de caractère
    {
        $funcSort = new QuickSortClass();
        $unsorted = ['banane', 'abricot', 'pomme', 'poire', 'cerise'];
        $sorted = ['abricot', 'banane', 'cerise', 'poire', 'pomme'];
        $result = $funcSort->QuickSort($unsorted);
        $this->assertSame($sorted, $result);
    }

    public function test_sort_large_array(): void // Vérifie que le tri fonctionne sur un grand tableau
    {
        $funcSort = new QuickSortClass();
        $unsorted = range(1, 100);
        shuffle($unsorted);
        $sorted = range(1, 100);
        $result = $funcSort->QuickSort($unsorted);
        $this->assertSame($sorted, $result);
    }
    public function test_error_empty_array(): void // Vérifie que le tableau n'est pas vide, exception dans la fonction
    {
        $arrayToBeSorted = [];
        $quickSort = new QuickSortClass();
        $this->expectException(Exception::class);
        $quickSort->QuickSort($arrayToBeSorted);
    }
    public function test_error_array_mixed_type(): void // Vérifie que le tableau n'est pas 2 type de données, exception dans la fonction
    {
        $arrayToBeSorted = [1, 'a', 3, 4, 'b', 'c'];
        $quickSort = new QuickSortClass();
        $this->expectException(Exception::class);
        $quickSort->QuickSort($arrayToBeSorted);
    }
    public function test_error_array_multidimensional(): void // Vérifie que le tableau n'est pas un tableau multidimensionnel, exception dans la fonction
    {
        $arrayToBeSorted = [[1,2], [5,3], [4,5]];
        $quickSort = new QuickSortClass();
        $this->expectException(Exception::class);
        $quickSort->QuickSort($arrayToBeSorted);
    }

}