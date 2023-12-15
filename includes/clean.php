<?php

    // remove special chars, strip tags and trim spaces from inputs
    
    function clean($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = strip_tags($data);
        return $data;
    }