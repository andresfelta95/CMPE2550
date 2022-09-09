<?php
    function GenerateNumbers() {
        $numbers = array();
        for ($i = 0; $i <= 10; $i++) {
            $numbers[] = $i;
        }
        shuffle($numbers);
        return $numbers;
    }

    function Makelist(array $numbers) {
        $list = "";
        foreach ($numbers as $number) {
            $list .= "<li>$number</li>";
        }
        return $list;
    }

    function MakeTable(array $numbers) {
        $table = "<table>";
        $table .= "<tr><th>Number</th><th>Square</th></tr>";
        foreach ($numbers as $number) {
            $table .= "<tr><td>$number</td><td>$number^2</td></tr>";
        }
        $table .= "</table>";
        return $table;
    }
        