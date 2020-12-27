// Fixing Webkit that not clearing input/textarea when get focus
$(function(){
  if ($.browser.webkit) {
    $('input, textarea').on('focus',function(){
      if ( $(this).attr('placeholder') ) $(this).data('placeholder', $(this).attr('placeholder')).removeAttr('placeholder');
}).on('blur', function(){
        if ( $(this).data('placeholder') ) $(this).attr('placeholder', $(this).data('placeholder')).removeData('placeholder');
    });
  }
});