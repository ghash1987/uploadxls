<?php 

newPost("szemelyek_tata_honlap_final.xlsx", "szervezeti_egyseg", "szemely");


function newPost($table_name, $taxonomy, $cpt)
{
    
    global $wpdb;
    
    include "SimpleXLSX.php";
    
    if ( $xlsx = SimpleXLSX::parse( __DIR__.'/'.$table_name) ) {
        
        $table_heads=$xlsx->rows()[0];
        
        
        foreach ($xlsx->rows() as $elt) {
            if ($elt != $table_heads) {
                
                
                $meta_input = array();
                
                foreach ($table_heads as $meta_key) {
                    if ($meta_key) {
                        $index = array_search($meta_key, $table_heads);
                        if ($index > 1) {
                            $meta_input[sanitize_title($meta_key)] = $elt[$index];                            
                        }
                    }
                }
                
                $insert_data_array = array(
                    'post_title' => $elt[0],
                    'post_content' => "",
                    'post_type' => $cpt,
                    'post_status' => "publish",
                    "meta_input" => $meta_input,
                );
               
                
                $post_id = wp_insert_post($insert_data_array, true);
                
                wp_set_object_terms( $post_id, $elt[1], $taxonomy );
                   
                
            }
        }
        
        
    } else {
        echo SimpleXLSX::parseError();
    }
    
    
    
}

get_footer();
