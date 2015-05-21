// JavaScript Document
jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#formID").validationEngine();
		});

function checkPass(field, rules, i, options){
  if (field.val() != $('#frm_PASSWORD1').val()) {
     // this allows the use of i18 for the error msgs
     return options.allrules.validate2fields.alertText;
  }
}