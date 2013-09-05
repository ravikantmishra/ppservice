function ajax_call(divId, uri, formId)
{
    $.post(uri,$("#"+formId).serialize(), function(data){
        $('#'+divId).html(data);
    });

    return false;
}


function validatePhone(phoneNumber) {
    //      var reg = /^((\+)?(\d{2}[-]))?(\d{10}){1}?$/;
    //var reg = /^((\+)?(\d{2}))?(\d{10-15}){1}?$/;
    var reg = /^[0-9 [\]+()-]{8,20}?$/;
    if(reg.test(phoneNumber) == false) {
      return true;
    }

    return false;
  }

 function compare_date(date){
      var today = new Date;
      var entered_date = date.split("-") ;
      var dob = new Date;
      dob.setDate(entered_date[0]);
      dob.setMonth(entered_date[1]-1);
      dob.setFullYear(entered_date[2]);
      if (dob >= today) {
        return false;
      }
      else{
        return true;
      }

}


 function validateAddress(address) {
   if((address.length > 255)) {
      return true;
    }

    return false;
  }

  function ajax_paginator(divId, uri)
{
    $.post(uri,$("#search").serialize(), function(data){
        $('#'+divId).html(data);
    });
    return false;
}

/* This function remove the blank space...*/
function trim(inputString)
{
   inputString=inputString.replace(/^\s+/g,"");
   inputString=inputString.replace(/\s+$/g,"");
   return inputString;

}//End of the trim function...

function validateEmail(email) {
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if(reg.test(email) == false) {

      return 1;
    }
    return 0;
}

  


