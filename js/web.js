    var $ = jQuery;
    jQuery().ready(function() {
        /* Custom select design */
        jQuery('.drop-down').append('<div class="country_select"></div>');
        jQuery('.drop-down').append('<ul class="select-list"></ul>');
        jQuery('.drop-down select option').each(function() {
          var bg = jQuery(this).css('background-image');
          jQuery('.select-list').append('<li class="clsAnchor"><span value="' + jQuery(this).val() + '" class="' + jQuery(this).attr('class') + '" style=background-image:' + bg + '>' + jQuery(this).text() + '</span></li>');
        });
        jQuery('.drop-down .country_select').html('<span style=background-image:' + jQuery('.drop-down select').find(':selected').css('background-image') + '>' + jQuery('.drop-down select').find(':selected').text() + '</span>' + '<a href="javascript:void(0);" class="select-list-link"></a>');
        jQuery('.drop-down ul li').each(function() {
          if (jQuery(this).find('span').text() == jQuery('.drop-down select').find(':selected').text()) {
          jQuery(this).addClass('active');
        }

    });
    jQuery('.drop-down .select-list span').on('click', function()
    {
      var dd_text = jQuery(this).text();
      var dd_img = jQuery(this).css('background-image');
      var dd_val = jQuery(this).attr('value');
      jQuery('.drop-down .country_select').html('<span style=background-image:' + dd_img + '>' + dd_text + '</span>' + '<a href="javascript:void(0);" class="select-list-link"></a>');
      jQuery('.drop-down .select-list span').parent().removeClass('active');
      jQuery(this).parent().addClass('active');
      $('#country_redirector_select').val( dd_val );
      $('.drop-down .select-list li').slideUp();
    });
      jQuery('.drop-down .country_select').on('click','a.select-list-link', function()
    {
      jQuery('.drop-down ul li').slideToggle();
    });
  /* End */
  });
  function country_redirector_top_append(){
    var panel = document.getElementById('country_redirector')
    document.body.insertBefore(panel, document.body.firstChild);
  }
  function country_redirector_top_fixed(){
    if($('#top-header').length == 0){
      var find = $('*').filter(function () {
          if( $(this).css('position') == 'fixed' && $(this).attr('id') != "country_redirector" && $(this).attr('id') != "wpadminbar" && $(this).css('bottom') != "0px"){
            if($(this).css('top').endsWith("px")){
                  var new_top = parseFloat($(this).css('top')) + 60;
                  $(this).css({top: new_top + "px"});
            }
          }
      });
    }else{
     $( 'body').addClass("country_redirector");
      $( '#top-header').prepend($( '#country_redirector'));
    }

  }
function country_redirector_ignore(){
  sessionStorage.removeItem('country_redirector_redirect');
  localStorage.removeItem('country_redirector_redirect');
  var d = new Date();
  d.setTime(d.getTime() - (365*24*60*60*1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = "wordpress_country_redirector_redirect" + "=ignored;path=/;expires=" + expires;
  country_redirector_hide();
}
function country_redirector_redirect(r){
  sessionStorage.setItem('country_redirector_redirect', r);
  localStorage.setItem('country_redirector_redirect', r);
  var d = new Date();
  d.setTime(d.getTime() + (365*24*60*60*1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = "wordpress_country_redirector_redirect" + "=" +r+";path=/;expires=" + expires;
  window.location.href = r;
}
function country_redirector_hide(){

  document.getElementById('country_redirector').remove();
  $(window).resize();


  sessionStorage.setItem('country_redirector_hide', true);
  localStorage.setItem('country_redirector_hide', true);
  document.cookie = "country_redirector_hide=1";
}
