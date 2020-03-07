<?php

    /**
     * Person Tag
     * @param array $info
     * @return string
     */
    function ui_element_person_tag( $info )
    {
        $response_text = "<b>".$info['first_name'] . ' ' . $info['middle_name'] . ' ' . $info['last_name'] . "</b>\n";
        $response_text .= $info['address_name'] . "\n";
        $response_text .= 'NID: ' . $info['nid'] . "\n"; 
        $response_text .= 'DOB: ' . date('d M Y', strtotime($info['dob'])) . "\n"; 
        $response_text .= 'Contact: ' . $info['contact_no'] . "\n";
        $response_text .= 'Email: ' . $info['email'];

        return $response_text;
    }