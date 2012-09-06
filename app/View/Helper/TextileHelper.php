<?php  
App::uses('Textile', 'Vendor');

class TextileHelper extends AppHelper { 

    // Process the text into Textile Format
    function process($text) { 
        $textile = new Textile(); 
        return $textile->TextileThis($text); 
        // For untrusted user input, use TextileRestricted instead: 
        // return $textile->TextileRestricted($in); 
    } 
    
    // Process untrusted user input
    function processRestricted($text) { 
        $textile = new Textile(); 
        return $textile->TextileRestricted($text); 
    } 
} 
?> 