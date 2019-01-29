<?php
/*
Plugin Name: Country Redirector
Plugin URI: https://github.com/pemasem/wordpress_plugin_country_redirector
Description: Redirect to a other countries
Verison: 1.0
Author: Pere Mataix Sempere
Author URI:
License: GPL2
License URI: https://www.gnu.org/license/gpl-2.0.html
Text Domain: country_redirector
*/

if ( !defined( 'ABSPATH' ) ) exit;



function country_redirector_settings_init() {
  $options = get_option( 'country_redirector_options' );

 // register a new setting
 register_setting( 'country_redirector', 'country_redirector_options' );

 // register a new section
 add_settings_section('country_redirector_section_detection', __( 'Country Detection', 'country_redirector' ), 'country_redirector_section_detection_cb', 'country_redirector' );
 add_settings_field('country_redirector_field_type', __( 'IP COUNTRY DETECTION', 'country_redirector' ), 'country_redirector_field_type_cb', 'country_redirector', 'country_redirector_section_detection', [ 'label_for' => 'country_redirector_field_type', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );
 add_settings_field('country_redirector_field_url', __( 'URL COUNTRY', 'country_redirector' ), 'country_redirector_field_url_cb', 'country_redirector', 'country_redirector_section_detection', [ 'label_for' => 'country_redirector_field_url', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );
 add_settings_field('country_redirector_field_behaviour', __( 'BEHAVIOUR', 'country_redirector' ), 'country_redirector_field_behaviour_cb', 'country_redirector', 'country_redirector_section_detection', [ 'label_for' => 'country_redirector_field_behaviour', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );

 add_settings_section('country_redirector_section_public', __( 'Public Design', 'country_redirector' ), 'country_redirector_section_public_cb', 'country_redirector' );
  add_settings_field('country_redirector_field_location', __( 'LOCATION', 'country_redirector' ), 'country_redirector_field_location_cb', 'country_redirector', 'country_redirector_section_public', [ 'label_for' => 'country_redirector_field_location', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );
 add_settings_field('country_redirector_field_info', __( 'INFO', 'country_redirector' ), 'country_redirector_field_info_cb', 'country_redirector', 'country_redirector_section_public', [ 'label_for' => 'country_redirector_field_info', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );
 add_settings_field('country_redirector_field_button', __( 'BUTTON', 'country_redirector' ), 'country_redirector_field_button_cb', 'country_redirector', 'country_redirector_section_public', [ 'label_for' => 'country_redirector_field_button', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );

 add_settings_section('country_redirector_section_redirections', __( 'Redirections', 'country_redirector' ), 'country_redirector_section_redirections_cb', 'country_redirector' );
 add_settings_field('country_redirector_field_redirections', __( 'ACTIVE', 'country_redirector' ), 'country_redirector_field_redirections_cb', 'country_redirector', 'country_redirector_section_redirections', [ 'label_for' => 'country_redirector_field_redirections', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );


 add_settings_section('country_redirector_section_manage', __( 'Manage', 'country_redirector' ), 'country_redirector_section_manages_cb', 'country_redirector' );



}
function country_redirector_field_behaviour_cb($args){
  $options = get_option( 'country_redirector_options' );

   $checked = isset($options[$args['label_for']."_hide_not_in_redirections"]);
    ?>
    <input value="hide_not_in_redirections" <?php if ($checked) echo 'checked="checked"'; ?> type="checkbox" name="country_redirector_options[<?php echo esc_attr( $args['label_for']."_hide_not_in_redirections" ); ?>]" >Hide Not Listed Country
    <p class="description">
    <?php esc_html_e( 'Hide the control if the country code is not in the redirections list' ); ?>
    </p>
    <select name="country_redirector_options[<?php echo esc_attr( $args['label_for']."_hide" ); ?>]">
      <option <?php echo isset( $options[ $args['label_for']."_hide"  ] ) ? ( selected( $options[ $args['label_for']."_hide"  ], 'only_your_country_and_global', false ) ) : ( '' ); ?> value="only_your_country_and_global">ONLY YOUR IP COUNTRY AND "GLOBAL" REDIRECTION</option>
        <option <?php echo isset( $options[ $args['label_for']."_hide"  ] ) ? ( selected( $options[ $args['label_for']."_hide"  ], 'only_your_country', false ) ) : ( '' ); ?> value="only_your_country">ONLY YOUR IP COUNTRY</option>
      <option <?php echo isset( $options[ $args['label_for']."_hide"  ] ) ? ( selected( $options[ $args['label_for']."_hide"  ], 'all_countries', false ) ) : ( '' ); ?> value="all_countries">ALL REDIRECTIONS</option>
    </select>
    <p class="description">
    <?php esc_html_e( 'Country list control' ); ?>
    </p>
    <select name="country_redirector_options[<?php echo esc_attr( $args['label_for']."_save" ); ?>]">
      <option <?php echo isset( $options[ $args['label_for']."_save" ] ) ? ( selected( $options[ $args['label_for']."_save"  ], 'sessionStorage', false ) ) : ( '' ); ?> value="sessionStorage">SAVE IN SESSION (reset when the navigator is closed)</option>
      <option <?php echo isset( $options[ $args['label_for']."_save" ] ) ? ( selected( $options[ $args['label_for']."_save"  ], 'localStorage', false ) ) : ( '' ); ?> value="localStorage">SAVE LOCALLY (saved in your navigator, not in others)</option>
      <option <?php echo isset( $options[ $args['label_for']."_save" ] ) ? ( selected( $options[ $args['label_for']."_save"  ], 'cookies', false ) ) : ( '' ); ?> value="cookies">SAVE IN A COOKIE (saved for all your browsers in your computer, not in others)</option>
    </select>
    <p class="description">
    <?php esc_html_e( 'Where the user selection is saved' ); ?>
    </p>
  <?php
}
function country_redirector_section_manages_cb(){?>
  <input type="submit" name="save_to_file" value="SAVE TO FILE"><br>
  <input type="submit" name="load_from_file" value="LOAD FROM FILE">
  <input type="file" name="config" value="LOAD FROM FILE">
<?php }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if((isset($_POST["submit"]) || isset($_POST["add"]) || isset($_POST["del"])) && isset($_POST["country_redirector_options"])){

    update_option( 'country_redirector_options',$_POST["country_redirector_options"] );

   $options = get_option( 'country_redirector_options' );
  }
  if(isset($_POST["load_from_file"]) && isset($_FILES["config"])){

        $file_data = file_get_contents($_FILES["config"]["tmp_name"]);

        $data = json_decode( $file_data, true);

        if(is_array($data)){
          update_option( 'country_redirector_options',$data );
          $options = get_option( 'country_redirector_options' );
        }
  }
  if(isset($_POST["save_to_file"]) && isset($_POST["country_redirector_options"] )){
    file_put_contents(plugin_dir_path( __FILE__) . 'js/country_redirector.json', json_encode( $_POST["country_redirector_options"] ));
    $file = plugin_dir_path( __FILE__) . 'js/country_redirector.json';
    header('Content-type: text/plain');
    header('Content-Length: '.filesize($file));
    header('Content-Disposition: attachment; filename=country_redirector.json');
    readfile($file);
      exit;
  }

}


function country_redirector_section_redirections_cb(){
  ?>
  <p><?php esc_html_e( 'Add Country Redirections', 'country_redirector' ); ?></p>
  <?php
}
function country_redirector_section_detection_cb( $args ) {
 ?>
 <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Set Up Coutry Redirector parameters', 'country_redirector' ); ?></p>
 <?php
}
function country_redirector_section_public_cb( $args ) {
 ?>
 <p><?php esc_html_e( 'Visible public design', 'country_redirector' ); ?></p>
 <?php
}
function country_redirector_field_location_cb($args){
  $options = get_option( 'country_redirector_options' );?>
  <select name="country_redirector_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
    <option <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'top_floating', false ) ) : ( '' ); ?> value="top_floating">TOP FLOATING</option>
    <option <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'top_append', false ) ) : ( '' ); ?> value="top_append">TOP APPEND</option>
      <option <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'top_fixed', false ) ) : ( '' ); ?> value="top_fixed">TOP FIXED</option>
  </select>
  <?php
}

function country_redirector_field_redirections_cb($args){
  $options = get_option( 'country_redirector_options' );

  $redirections = array();
  if(isset($options[ $args['label_for']])){
    $redirections = json_decode( $options[ $args['label_for']], true);
  }
  ?>
  <script type="text/javascript">
  var redirections  = <?php echo json_encode( $redirections ) ?>;
  function addNewRedirection(){
    var rand = new Date().valueOf();
    var redirection = {id:rand,country:"ES",redirect:"/es",text:"ESPAÑA",icon:""};
    redirections.push(redirection);
   document.getElementById("redirections_value").value = JSON.stringify(redirections);
   return true;
  }

  function delRedirection(id){
    redirections.forEach(function(value,index){
      if(value.id ==id ){
          redirections.splice(index, 1);
          document.getElementById("redirections_value").value = JSON.stringify(redirections);
         return true;
      }
    });

  }

  function updateRedirection(index,field,new_value){
    redirections[index][field]  = new_value;


          document.getElementById("redirections_value").value = JSON.stringify(redirections);



  }
  window.onload = function(){
  document.getElementById("redirections_value").value = JSON.stringify(redirections);

  }
  </script>
  <input id="redirections_value" style="width:100%"  type="hidden" name="country_redirector_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
  <div id="redirections" >
  <?php
  foreach ($redirections as $index => $redirection) {?>
    <div class="redirection" style="clear:both;border:solid 1px #AFAFAF; padding:10px;margin-top: 15px;background-color: #DDDDDD">
    <label style="text-align: right;display: inline-block;width:15%;margin-right:1%">Country ISO2</label><input onchange="updateRedirection(<?=$index?>,'country',this.value);return false;" value="<?=$redirection["country"]?>">
    <label style="text-align: right;display: inline-block;width:15%;margin-right:1%">Text</label><input onchange="updateRedirection(<?=$index?>,'text',this.value);return false;" value="<?=$redirection["text"]?>">
    <br>
    <label style="text-align: right;display: inline-block;width:15%;margin-right:1%">Redirection</label><input style="width:80%" onchange="updateRedirection(<?=$index?>,'redirect',this.value);return false;" value="<?=$redirection["redirect"]?>">
    <br>
    <label style="text-align: right;display: inline-block;width:15%;margin-right:1%">Icon</label><input style="width:80%" onchange="updateRedirection(<?=$index?>,'icon',this.value);return false;" value="<?=$redirection["icon"]?>">
    <button class="btn btn-danger" name="del" onclick=" delRedirection(<?=$redirection["id"]?>); " style="float:right">-</button>
    </div>
  <?php }
  ?>
  </div>
  <button class="btn btn-primary" name="add" onclick="addNewRedirection();" style="float:left;margin-top:20px">NEW REDIRECTION</button>
  <?php
}
function country_redirector_field_button_cb($args){
  $options = get_option( 'country_redirector_options' );
  ?>
  <input style="width:100%" type="text" name="country_redirector_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php  if(isset( $options[ $args['label_for'] ] )){ echo $options[ $args['label_for']];} else { echo 'Continuar' ; } ?>">
  <?php
}
function country_redirector_field_info_cb( $args ) {
  $options = get_option( 'country_redirector_options' );
  ?>
  <input style="width:100%" type="text" name="country_redirector_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php  if(isset( $options[ $args['label_for'] ] )){ echo $options[ $args['label_for']];} else { echo 'Indica en qué país o región estás para ver contenidos específicos.' ; } ?>">
  <?php
}
function country_redirector_field_url_cb($args){
  // get the value of the setting we've registered with register_setting()
  $options = get_option( 'country_redirector_options' );
  $checked = isset($options[$args['label_for']])?$options[$args['label_for']]:array();
  ?>
  <input value="-[A-Za-z]{2}/" <?php if ( in_array("-[A-Za-z]{2}/", $checked)) echo 'checked="checked"'; ?> type="checkbox" name="country_redirector_options[<?php echo esc_attr( $args['label_for'] ); ?>][]" >/es<b>-ES/</b>page.html
  <p class="description">
  <?php esc_html_e( 'How are your country been defined', 'country_redirector' ); ?>
  </p>

  <?php
}
function country_redirector_field_type_cb( $args ) {
 // get the value of the setting we've registered with register_setting()
 $options = get_option( 'country_redirector_options' );


 // output the field
 ?>
 <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['country_redirector_custom_data'] ); ?>"
 name="country_redirector_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
 >

 <option value="FILE" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'FILE', false ) ) : ( '' ); ?>>

 <?php esc_html_e( 'FILE', 'country_redirector' ); ?>
 </option>
 <option value="API" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'API', false ) ) : ( '' ); ?>>
   <?php esc_html_e( 'API', 'country_redirector' ); ?>
   </option>
 </select>
 <p class="description">
 <?php esc_html_e( 'Test a country (iso2):', 'country_redirector' ); ?>
 </p>

 <input type="text" value="<?=isset($options[ $args['label_for']."_country_test" ])?$options[ $args['label_for']."_country_test" ]:"";?>" name ="country_redirector_options[<?php echo esc_attr( $args['label_for'] ); ?>_country_test]">
 <?php
}

add_action( 'admin_init', 'country_redirector_settings_init' );


function country_redirector_options_page() {
 // add top level menu page
 add_menu_page(
 'country_redirector',
 'Country Red.',
 'manage_options',
 'country_redirector',
 'country_redirector_options_page_html'
 );
}

function country_redirector_options_page_html() {
 // check user capabilities
 if ( ! current_user_can( 'manage_options' ) ) {
 return;
 }

 // add error/update messages

 // check if the user have submitted the settings
 // wordpress will add the "settings-updated" $_GET parameter to the url
 if ( isset( $_GET['settings-updated'] ) ) {
 // add settings saved message with the class of "updated"
 add_settings_error( 'country_redirector_messages', 'country_redirector_message', __( 'Settings Saved', 'country_redirector' ), 'updated' );
 }

 // show error/update messages
 settings_errors( 'country_redirector_messages' );
 ?>
 <div class="wrap">
 <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
 <form  action method="post" enctype="multipart/form-data">
 <?php
 // output security fields for the registered setting "wporg"
 settings_fields( 'country_redirector' );
 // output setting sections and their fields
 // (sections are registered for "wporg", each field is registered to a specific section)
 do_settings_sections( 'country_redirector' );
 // output save settings button
 submit_button( 'Save Settings' );
 ?>
 </form>
 </div>
 <?php
}




   add_action( 'admin_menu', 'country_redirector_options_page' );

   function country_redirector_get_visitor_IP() {
   	$ip = null;
   	$client = @$_SERVER['HTTP_CLIENT_IP'];
   	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
   	$remote = $_SERVER['REMOTE_ADDR'];
   	if ( filter_var( $client, FILTER_VALIDATE_IP ) ) {
   		$ip = $client;
   	} elseif ( filter_var( $forward, FILTER_VALIDATE_IP ) ) {
   		$ip = $forward;
   	} else {
   		$ip = $remote;
   	}
   	return $ip;
   }

   $ip_country = "";
   function country_redirector_init(){
     global $ip_country;
     $ip = country_redirector_get_visitor_IP();
       if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
         $ip = '20.190.129.0';
       }

     if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
       $options = get_option( 'country_redirector_options' );

       if(isset($options["country_redirector_field_type"])){
         switch ($options["country_redirector_field_type"]) {
           case 'FILE':
             include __DIR__.'/GeoIp2/geoip2.phar';
             $reader = new GeoIp2\Database\Reader( __DIR__ . '/GeoIp2/GeoLite2-Country.mmdb' );
             $c = $reader->country( $ip);

              if(is_object($c) && strlen($c->country->isoCode) == 2){
                $ip_country = strtoupper($c->country->isoCode);

              }else{
                $ch = curl_init('http://api.ipapi.com/'.$ip.'?access_key=d55722d1ba0708ff6d292f50458287b9');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($ch);
                curl_close($ch);
                //country_redirector_log_console($json);
                $api_result = json_decode($json, true);
                $ip_country =  $api_result['country_code'];
              }

             break;
           case 'API':
           // Initialize CURL:
           $ch = curl_init('http://api.ipapi.com/'.$ip.'?access_key=d55722d1ba0708ff6d292f50458287b9');
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           $json = curl_exec($ch);
           curl_close($ch);
           $api_result = json_decode($json, true);
           $ip_country =  $api_result['country_code'];
           break;
         }
       }
       if(strlen($ip_country) == 2 && !country_redirector_detectUrlCountry($ip_country)){
           $hide = false;
           if(isset($options["country_redirector_field_behaviour_hide_not_in_redirections"])){
               $hide = true;
               $options = get_option( 'country_redirector_options' );
               $redirections = json_decode( $options[ "country_redirector_field_redirections"], true);
               foreach ($redirections as $key => $value) {
                 if(strtoupper($value["country"]) == $ip_country){
                   $hide = false;
                 }
               }
           }
           if(!$hide){
             add_action( 'wp_footer',   'country_redirector_add_country_redirector' , 0 );
             add_action( 'get_footer', 'country_redirector_add_footer_styles' );
           }

       }
     }
       //country_redirector_log_console($ip_country);
   }
    add_action( 'init', 'country_redirector_init' );


    function country_redirector_footer_info(){

      ?>

    <?php }

  function country_redirector_detectUrlCountry($ip_country){
    $options = get_option( 'country_redirector_options' );
    $redirections = array();
    if(isset($options[ "country_redirector_field_url"])){
      $redirections = $options[ "country_redirector_field_url"];
    }
      $url = strtoupper($_SERVER["REQUEST_URI"]);
      foreach ($redirections as   $code) {
        preg_match_all('/'. str_replace("/", "\/",$code).'/', $url, $matches);
        if(is_array($matches) &&  count($matches) > 0){
          foreach ($matches as $match) {
            if(is_array($match) &&  count($match) > 0){
              if(strpos($match[0], $ip_country )!== FALSE ){
                return true;
              }
            }
          }
        }
      }

    return false;
  }
  function country_redirector_log_console($vale){?>
      <script type="text/javascript">
      console.log('<?=$vale?>');
      </script>
  <?php }

  function country_redirector_add_country_redirector() {
    global $ip_country;
    $options = get_option( 'country_redirector_options' );
    $redirections = json_decode( $options[ "country_redirector_field_redirections"], true);
    switch ($options["country_redirector_field_behaviour_hide"]) {
      case 'only_your_country_and_global':
        $global = "";
         foreach ($redirections as $key => $value) {
           if(strtoupper($value["country"]) == "GLOBAL" ){
             $global = $value;
              unset($redirections[$key]);
           }else{
             if(strtoupper($value["country"]) != $ip_country ){

               unset($redirections[$key]);
             }
           }
         }
         if($global != ""){
           $redirections["global"] = $global;
         }
        break;
      case 'only_your_country':
         foreach ($redirections as $key => $value) {
           if(strtoupper($value["country"]) != $ip_country){
             unset($redirections[$key]);
           }
         }
        break;
      case 'all_countries':

      break;
    }



    ?>
    <div id='country_redirector' class="hide <?=$options[ "country_redirector_field_location"]?>">
      <script type="text/javascript">
        window.onload = function(){
          <?php
          if(!isset($options["country_redirector_field_behaviour_save"])){
            $options["country_redirector_field_behaviour_save"] = "sessionStorage";
          }?>
          var r = "";
          var country_redirector_hide = false;
          <?php
          switch ($options["country_redirector_field_behaviour_save"]) {
            case 'sessionStorage':?>
                 country_redirector_hide = sessionStorage.getItem("country_redirector_hide");
                 r = sessionStorage.getItem("country_redirector_redirect");
            <?php  break;
            case 'localStorage':?>
                 country_redirector_hide = localStorage.getItem("country_redirector_hide");
                 r = localStorage.getItem("country_redirector_redirect");
            <?php  break;
            case 'cookies':?>
              var x = document.cookie;
              var ca = document.cookie.split(';');
              for(var i = 0; i < ca.length; i++) {
                var c = ca[i];
                var value = "";
                while (c.charAt(0) == ' ') {
                  c = c.substring(1);
                }
                if (c.indexOf('country_redirector_hide=') == 0) {
                  value =  c.substring('country_redirector_hide='.length, c.length);
                  country_redirector_hide = (value == 1)? true : false;
                }
                if (c.indexOf('country_redirector_redirect=') == 0) {
                  r =  c.substring('country_redirector_hide='.length, c.length);
                }
              }

            <?php  break;
          } ?>
          <?php if(!is_user_logged_in()){?>
          if( r != ""){
            country_redirector_redirect(r);
          }
          <?php }?>
          if(!country_redirector_hide){
            <?php
              if($options[ "country_redirector_field_location"] == "top_append"){?>
                  country_redirector_top_append();
              <?php }elseif($options[ "country_redirector_field_location"] =="top_fixed"){?>
                 country_redirector_top_fixed();
              <?php } ?>
              document.getElementById('country_redirector').classList.remove("hide");
          }
      }
      </script>
    <span><?= __($options["country_redirector_field_info"]);?></span>
    <div class="drop-down">
      <select id="country_redirector_select">
        <?php
          foreach ($redirections as $key => $value) {?>
            <option class="<?=$value["country"]?>" value="<?=$value["redirect"]?>" <?php

              if($value["icon"] != ""){ ?>
                style="background-image:url('<?=$value["icon"];?>');"
              <?php }elseif(file_exists(plugin_dir_path( __FILE__) . 'images/'.$value["country"].".svg")){?>
                style="background-image:url('<?=plugin_dir_url(__FILE__) . 'images/'.$value["country"].".svg"; ?>');"

              <?php }        ?>><?=$value["text"]?></option>
          <?php } ?>
      </select>
    </div>
    <button  country=<?php echo "a:".$ip_country;?> onclick="country_redirector_redirect(document.getElementById('country_redirector_select').value);return false;"><?= __($options["country_redirector_field_button"]);?></button>
    <a href="#" onclick="country_redirector_hide();return false;">X</a>
    </div>
    <?php
  }



  function country_redirector_add_footer_styles() {
    $options = get_option( 'country_redirector_options' );
    if(file_exists(plugin_dir_path( __FILE__) . 'css/'.$options[ "country_redirector_field_location"].".css")){
      wp_enqueue_style( $options[ "country_redirector_field_location"], plugin_dir_url(__FILE__) . 'css/'.$options[ "country_redirector_field_location"].'.css',1 );
    }
      wp_enqueue_style( 'country_redirector', plugin_dir_url(__FILE__) . 'css/style.css' );
      wp_enqueue_script('web',plugin_dir_url(__FILE__) . 'js/web.js');
      wp_enqueue_script('jquery');
  };
