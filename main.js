$(function(){

  const MSG_TEXT_MAX = '20字以内で入力して下さい';
  const MSG_EMPTY = '入力必須です';
  const MSG_EMAIL_TYPE= 'メールアドレスの形式で入力して下さい';
  const MSG_TEXTAREA_MAX = '200字以内で入力して下さい';
  const MSG_PASS_NO = 'パスワード再入力が合いません';

  $('.valid-name').keyup(function(){
    
    var form_item = $(this).closest('.form-item');

    if($(this).val().length > 20){
      form_item.removeClass('success').addClass('error');
      form_item.find('.error-msg').text(MSG_TEXT_MAX);
    }else{
      form_item.removeClass('error').addClass('success');
      form_item.find('.error-msg').text('');
    }
  });

  $('.valid-email').keyup(function(){

    var form_item = $(this).closest('.form-item');

    if($(this).val().length === 0){
      form_item.removeClass('success').addClass('error');
      form_item.find('.error-msg').text(MSG_EMPTY);
    }else if($(this).val().length > 50 || !$(this).val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)){
      form_item.removeClass('success').addClass('error');
      form_item.find('.error-msg').text(MSG_EMAIL_TYPE);
    }else{
      form_item.removeClass('error').addClass('success');
      form_item.find('.error-msg').text('');
    }
    });
  
  $('.valid-textarea').keyup(function(){

    var form_item = $(this).closest('.form-item');

    if($(this).val().length === 0){
      form_item.removeClass('success').addClass('error');
      form_item.find('.error-msg').text(MSG_EMPTY);
    }else if($(this).val().length > 200){
      form_item.removeClass('success').addClass('error');
      form_item.find('.error-msg').text(MSG_TEXTAREA_MAX);
    }else{
      form_item.removeClass('error').addClass('success');
      form_item.find('.error-msg').text('');
    }
  });  
  
  $('.format-tel').change(function(){

    var format_before = $(this).val();
    format_before = format_before.replace(/-/g,'');
    format_after = format_before.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){ return String.fromCharCode(s.charCodeAt(0)-0xFEE0) });

    if(format_after.length === 11){
      $(this).val(format_after.substr(0,3)+'-'+format_after.substr(3,4)+'-'+format_after.substr(7,4));
    }else{
      $(this).val(format_after);
    }
  });

    
  $('.count-textarea').keyup(function(){
    
    var count = $(this).val().length;
  
    $('.counter').text(count);
  });

  $('.valid-pass-re').keyup(function(){
    if($('.valid-pass') !== $('.valid-pass-re')){
      var form_item = $(this).closest('.form-item');
      form_item.find('.error-msg').text(MSG_PASS_NO);
    }
  });
});
