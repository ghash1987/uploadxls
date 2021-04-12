<?php 

newPost("szemelyek_tata_honlap_final.xlsx", "szervezeti_egyseg", "szemely");


function newPost($table_name, $taxonomy, $cpt)
{
    
    global $wpdb;
    echo '<br>';
    echo '<br>';
    echo '<br>';
    
    include "SimpleXLSX.php";
    
    if ( $xlsx = SimpleXLSX::parse( __DIR__.'/'.$table_name) ) {
        
        $table_heads=$xlsx->rows()[0];
        print_r($table_heads[0]);
        
        
        foreach ($xlsx->rows() as $elt) {
            if ($elt != $table_heads) {
                
                
                $meta_input = array();
                
                foreach ($table_heads as $meta_key) {
                    if ($meta_key) {
                        
                        //    $value = str_replace('&lt;', '<', $value);
                        //   $value = str_replace('&gt;', '>', $value);
                        $index = array_search($meta_key, $table_heads);
                        if ($index > 1) {
                            console_log($meta_key);
                            $meta_input[sanitize_title($meta_key)] = $elt[$index];
                            console_log($elt[$index]);
                            
                        }
                    }
                }
                
                $insert_data_array = array(
                    //      'ID' => 0,
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