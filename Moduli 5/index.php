<?php


$dogs = [
    ["husky",   "mexico",  20],
    ["bulldog", "soberia", 15],
    ["pug",     "china",   10],
    ["beagle",  "england", 18]
];


$rows = count($dogs);


$cols = count($dogs[0]);

echo "<h3>Row 1 (dog 0):</h3>";
for ($c = 0; $c < $cols; $c++) {
    echo "Column $c : " . $dogs[0][$c] . "<br>";
}

echo "<hr>";

echo "<h3>All Rows & Columns:</h3>";


for ($r = 0; $r < $rows; $r++) {

    echo "<strong>Row $r</strong><br>";

   
    for ($c = 0; $c < $cols; $c++) {
        echo "Row $r, Col $c → " . $dogs[$r][$c] . "<br>";
    }

    echo "<br>";
}

echo "<h2>1. Array i element j</h2>";

for ($i = 1; $i < 4; $i++) {

    for ($j = 1; $j < 4; $j++) {
        echo "array $i element $j <br>";
    }

    echo "<br>";
}

echo "<h2>2. Star Pattern (with for i and j loops)</h2>";

for ($i = 1; $i <= 4; $i++) {

    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }

    echo "<br>";
}

echo"<br>";

$grade = array(
    "math"      => 3,
    "english"   => 4,
    "science"   => 5,
    "history"   => 2,
    "computer"  => 5
);


echo "Math grade = " . $grade["math"] . "<br><br>";


echo "<h3>All Subjects & Grades</h3>";

foreach ($grade as $subject => $value) {
    echo $subject . " grade = " . $value . "<br>";
}



?>







