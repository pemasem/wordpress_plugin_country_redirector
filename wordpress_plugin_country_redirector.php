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

if ( !defined('ABSPATH') )
die();


function country_redirector_settings_init() {
 // register a new setting
 register_setting( 'country_redirector', 'country_redirector_options' );

 // register a new section
 add_settings_section('country_redirector_section_detection', __( 'Country Detection', 'country_redirector' ), 'country_redirector_section_detection_cb', 'country_redirector' );
 add_settings_field('country_redirector_field_type', __( 'IP COUNTRY DETECTION', 'country_redirector' ), 'country_redirector_field_type_cb', 'country_redirector', 'country_redirector_section_detection', [ 'label_for' => 'country_redirector_field_type', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );
 add_settings_field('country_redirector_field_url', __( 'URL COUNTRY', 'country_redirector' ), 'country_redirector_field_url_cb', 'country_redirector', 'country_redirector_section_detection', [ 'label_for' => 'country_redirector_field_url', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );

 add_settings_section('country_redirector_section_public', __( 'Public Design', 'country_redirector' ), 'country_redirector_section_public_cb', 'country_redirector' );
  add_settings_field('country_redirector_field_location', __( 'LOCATION', 'country_redirector' ), 'country_redirector_field_location_cb', 'country_redirector', 'country_redirector_section_public', [ 'label_for' => 'country_redirector_field_location', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );
 add_settings_field('country_redirector_field_info', __( 'INFO', 'country_redirector' ), 'country_redirector_field_info_cb', 'country_redirector', 'country_redirector_section_public', [ 'label_for' => 'country_redirector_field_info', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );
 add_settings_field('country_redirector_field_button', __( 'BUTTON', 'country_redirector' ), 'country_redirector_field_button_cb', 'country_redirector', 'country_redirector_section_public', [ 'label_for' => 'country_redirector_field_button', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );

 add_settings_section('country_redirector_section_redirections', __( 'Redirections', 'country_redirector' ), 'country_redirector_section_redirections_cb', 'country_redirector' );
 add_settings_field('country_redirector_field_redirections', __( 'ACTIVE', 'country_redirector' ), 'country_redirector_field_redirections_cb', 'country_redirector', 'country_redirector_section_redirections', [ 'label_for' => 'country_redirector_field_redirections', 'class' => 'country_redirector_row', 'country_redirector_custom_data' => 'custom', ] );




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
    <button class="btn btn-danger" onclick=" delRedirection(<?=$redirection["id"]?>); " style="float:right">-</button>
    </div>
  <?php }
  ?>
  </div>
  <button class="btn btn-primary" onclick="addNewRedirection();" style="float:left;margin-top:20px">NEW REDIRECTION</button>
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
 <option value="API" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'API', false ) ) : ( '' ); ?>>
 <?php esc_html_e( 'API', 'country_redirector' ); ?>
 </option>
 <option value="FILE" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'FILE', false ) ) : ( '' ); ?>>
 <?php esc_html_e( 'FILE', 'country_redirector' ); ?>
 </option>
 </select>
 <p class="description">
 <?php esc_html_e( 'Get the IP country from a third party API', 'country_redirector' ); ?>
 </p>
 <p class="description">
 <?php esc_html_e( 'Get the IP country from a file.', 'country_redirector' ); ?>
 </p>
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
 <form action="options.php" method="post">
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

   function get_visitor_IP() {
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



    $ip = get_visitor_IP();
$ip = "89.46.89.241";
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
      $options = get_option( 'country_redirector_options' );

      switch ($options["country_redirector_field_type"]) {
        case 'FILE':
          include __DIR__.'/GeoIp2/geoip2.phar';
          $reader = new GeoIp2\Database\Reader( __DIR__ . '/GeoIp2/GeoLite2-Country.mmdb' );
          $country = $reader->country( $ip);
           if(is_object($country) && strlen($country->country->isoCode) == 2){
               if(!detectUrlCountry($country->country->isoCode)){
                   add_action( 'wp_footer',   'country_redirector_add_country_redirector' , 1000 );
                   add_action( 'get_footer', 'country_redirector_add_footer_styles' );
               }
           }


          break;
        case 'API':

        break;
      }
    }
  function detectUrlCountry($country){
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
              if(strpos($match[0], $country )!== FALSE ){
                return true;
              }
            }
          }
        }
      }
    return false;
  }
  function country_redirector_add_country_redirector() {

    $options = get_option( 'country_redirector_options' );
    $redirections = json_decode( $options[ "country_redirector_field_redirections"], true);
    ?>
    <div id='country_redirector' class="hide <?=$options[ "country_redirector_field_location"]?>">
      <script type="text/javascript">
        window.onload = function(){
          var country_redirector_hide = localStorage.getItem("country_redirector_hide");
          if(!country_redirector_hide){

            <?php
              if($options[ "country_redirector_field_location"] == "top_append"){?>
                  var panel = document.getElementById('country_redirector')
                  document.body.insertBefore(panel, document.body.firstChild);
              <?php } ?>
              document.getElementById('country_redirector').classList.remove("hide");
          }
      }
      </script>
    <span><?=$options["country_redirector_field_info"]?></span>
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
    <button onclick="var r = document.getElementById('country_redirector_select').value; window.location.href = r;"><?=$options["country_redirector_field_button"]?></button>
    <a href="#" onclick="document.getElementById('country_redirector').remove();localStorage.setItem('country_redirector_hide', true);">X</a>
    </div>
    <?php
  }



  function country_redirector_add_footer_styles() {
      wp_enqueue_style( 'country_redirector', plugin_dir_url(__FILE__) . 'css/style.css' );
      wp_enqueue_script('web',plugin_dir_url(__FILE__) . 'js/web.js');
      wp_enqueue_script('jquery');
  };
