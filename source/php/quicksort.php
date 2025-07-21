<?php
// Function to swap two elements
function swap(&$a, &$b) : void {
	if($a === $b)
		return;
    $temp = $a;
    $a = $b;
    $b = $temp;
}

// Partition function
function partition(&$arr, $low, $high,$compair) : int{
    
    // Choose the pivot
    $pivot = $arr[$high];
    
    // Index of smaller element and indicates 
    // the right position of pivot found so far
    $i = $low - 1;

    // Traverse arr[low..high] and move all smaller
    // elements to the left side. Elements from low to 
    // i are smaller after every iteration
    for ($j = $low; $j < $high; $j++)
    {
        if ($compair($pivot,$arr[$j]))
        {
            $i++;
            swap($arr[$i], $arr[$j]);
        }
    }
    
    // Move pivot after smaller elements and
    // return its position
    swap($arr[$i + 1], $arr[$high]);  
    return $i + 1;
}

// The QuickSort function implementation
function quickSort(&$arr, $low, $high,$compair) : void{
    if ($low < $high) {
        
        // pi is the partition return index of pivot
        $pi = partition($arr, $low, $high,$compair);
        // Recursion calls for smaller elements
        // and greater or equals elements
        quickSort($arr, $low, $pi - 1,$compair);
        quickSort($arr, $pi + 1, $high,$compair);
    }
}
?>