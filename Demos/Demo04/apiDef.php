<?php

// Function to clean data
private function _cleanInputs($data)
{
    $clean_input = Array();
    if (is_array($data)) {
        foreach ($data as $k => $v) {
            $clean_input[$k] = $this->_cleanInputs($v);
        }
    } else {
        $clean_input = trim(strip_tags($data));
    }
    return $clean_input;
}
?>