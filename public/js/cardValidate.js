/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */




/*************************************************************************\
CheckCardNumber()
function called when users click the "continue" button.
\*************************************************************************/
function CheckCardNumber() {
    var tmpyear;
    var tmpmonth;
    var cardname;
    var err = 0;

    //checking if card number is empty
    if (document.getElementById('cardDetails_card_num').value == '') {
        document.getElementById('card_num_error').innerHTML = 'Please enter a Card Number.';
        document.getElementById('cardDetails_card_num').focus();
        err++;
    }else{
        document.getElementById('card_num_error').innerHTML = '';
    }

    if (document.getElementById('cardDetails_year').value == '') {
        document.getElementById('month_year_error').innerHTML = 'Please select the Expiration Year.';
        err++;
    }else{
        document.getElementById('month_year_error').innerHTML = '';
    }


    if (document.getElementById('cardDetails_month').value == '') {
        document.getElementById('month_year_error').innerHTML = 'Please select the Expiration Month.';
        err++;
    }else{
        document.getElementById('month_year_error').innerHTML = '';
    }


    tmpyear = document.getElementById('cardDetails_year').value;
    tmpmonth = document.getElementById('cardDetails_month').options[document.getElementById('cardDetails_month').selectedIndex].value;



    if(!ValidateExpDate(tmpyear,tmpmonth)){
        document.getElementById('month_year_error').innerHTML = 'This card has already expired.';
        err++;
    }else{
        document.getElementById('month_year_error').innerHTML = '';
    }


    if(document.getElementById('cardDetails_card_num').value != ''){
        $cardStatus = Mod10(document.getElementById('cardDetails_card_num').value);

        if(!$cardStatus){
            document.getElementById('card_num_error').innerHTML = 'Please enter a valid Card Number.';
            document.getElementById('cardDetails_card_num').focus();
            err++;
        }else{
            document.getElementById('card_num_error').innerHTML = '';
        }
    }

    if (document.getElementById('cardDetails_cvv_number').value == '') {
        document.getElementById('cvv_number_error').innerHTML = 'Please enter the CVV Number.';
        err++;
    }else{
        document.getElementById('cvv_number_error').innerHTML = '';
    }


    if(err == 0){
        return true;
    }else{
        return false
    }


}





function checkCardType(){
    var visaReg = /^4[0-9]{12}(?:[0-9]{3})?$/;
    var masterReg = /^5[1-5][0-9]{14}$/;
    var americanReg = /^3[47][0-9]{13}$/;
    var discoverReg = /^6(?:011|5[0-9]{2})[0-9]{12}$/;
    var cardName;
    var cardType;

    if(document.getElementById('cardDetails_card_num').value != ''){
        if(visaReg.test(document.getElementById('cardDetails_card_num').value)){
            cardType = "visa";
            cardName = "Visa Card";
        }else if(masterReg.test(document.getElementById('cardDetails_card_num').value)){
            cardType = "master";
            cardName = "Master Card";
        }else if(americanReg.test(document.getElementById('cardDetails_card_num').value)){
            cardType = "amex";
            cardName = "American Express Card";
        }else if(discoverReg.test(document.getElementById('cardDetails_card_num').value)){
            cardType = "discover";
            cardName = "Discover Card";
        }else{
            cardType = "Unrecognised Card";
            cardName = "Unrecognised Card";
        }
        document.getElementById('cardTypeTd').style.display = 'block';
        document.getElementById('cardName').innerHTML = 'Card Type : '+cardName;
        document.getElementById('card_type').value = cardType;
    }else{
        document.getElementById('cardTypeTd').style.display = 'none';
        document.getElementById('cardName').innerHTML = '';
        document.getElementById('card_type').value = '';
    }
}


function payeasycheckCardType(){ 
    var visaReg = /^4[0-9]{12}(?:[0-9]{3})?$/;
    var masterReg = /^5[1-5][0-9]{14}$/;
    var americanReg = /^3[47][0-9]{13}$/;
    var jcbReg = /^(?:2131|1800|35\d{3})\d{11}$/;
    var dinersReg = /^3(?:0[0-5]|[68][0-9])[0-9]{11}$ /;
    var cardType = document.getElementById('ep_pay_easy_request_card_type').value;
    var cardNum = document.getElementById('ep_pay_easy_request_card_Num').value;

    if(cardNum != '' && cardType != ''){

        if(cardType =='V'){
            if(!visaReg.test(cardNum)){
                $("#card_Num_error").html('Please enter correct Card Number')
                return false;
            }
        }
        if(cardType =='A'){
            if(!americanReg.test(cardNum)){
                $("#card_Num_error").html('Please enter correct Card Number')
                return false;
            }
        }
        if(cardType =='D'){
            if(!dinersReg.test(cardNum)){
                $("#card_Num_error").html('Please enter correct Card Number')
                return false;
            }
        }
        if(cardType =='J'){
            if(!jcbReg.test(cardNum)){
                $("#card_Num_error").html('Please enter correct Card Number')
                return false;
            }
        }
        if(cardType =='M'){
            if(!masterReg.test(cardNum)){
                $("#card_Num_error").html('Please enter correct Card Number')
                return false;
            }
        }
    }else{
        document.getElementById$("#card_type_error").html('Please select a Card.');
        document.getElementById('#card_Num_error').html('Please enter a Card Number.');
        return false;
    }
    return true;
}

// NMI Card Number Check
function nmiCheckCardType(cardNum){
    var visaReg = /^4[0-9]{12}(?:[0-9]{3})?$/;
    var masterReg = /^5[1-5]{1}[0-9]{14}$/;
    var americanReg = /^3[47][0-9]{13}$/;
    var jcbReg = /^(?:2131|1800|35\d{3})\d{11}$/;
    var dinersReg = /^3(?:0[0-5]|[68][0-9])[0-9]{11}$ /;
    var cardType = document.getElementById('ep_gray_pay_request_card_type').value;
    //var cardNum = document.getElementById('billing-cc-number').value;

    if(cardNum != '' && cardType != ''){

        if(cardType =='V'){
            if(!visaReg.test(cardNum)){
                //$("#billing-cc-number_error").html('Please enter correct Card Number')
                return 1;
            }
        }
        if(cardType =='A'){
            if(!americanReg.test(cardNum)){
                //$("#billing-cc-number_error").html('Please enter correct Card Number')
                return 1;
            }
        }
        if(cardType =='D'){
            if(!dinersReg.test(cardNum)){
                //$("#billing-cc-number_error").html('Please enter correct Card Number')
                return 1;
            }
        }
        if(cardType =='J'){
            if(!jcbReg.test(cardNum)){
                //$("#billing-cc-number_error").html('Please enter correct Card Number')
                return 1;
            }
        }
        if(cardType =='M'){
            if(!masterReg.test(cardNum)){
                //$("#billing-cc-number_error").html('Please enter correct Card Number')
                return 1;
            }
        }
    }
    
    return 0;
}

function Mod10(ccNumb) {  // v2.0
    var valid = "0123456789"  // Valid digits in a credit card number
    var len = ccNumb.length;  // The length of the submitted cc number
    var iCCN = parseInt(ccNumb);  // integer of ccNumb
    var sCCN = ccNumb.toString();  // string of ccNumb
    sCCN = sCCN.replace (/^s+|s+$/g,'');  // strip spaces
    var iTotal = 0;  // integer total set at zero
    var bNum = true;  // by default assume it is a number
    var bResult = false;  // by default assume it is NOT a valid cc
    var temp;  // temp variable for parsing string
    var calc;  // used for calculation of each digit

    // Determine if the ccNumb is in fact all numbers
    for (var j=0; j<len; j++) {
        temp = "" + sCCN.substring(j, j+1);
        if (valid.indexOf(temp) == "-1"){
            bNum = false;
        }
    }

    // if it is NOT a number, you can either alert to the fact, or just pass a failure
    if(!bNum){
        /*alert("Not a Number");*/bResult = false;
    }

    // Determine if it is the proper length
    if((len == 0)&&(bResult)){  // nothing, field is blank AND passed above # check
        bResult = false;
    } else{  // ccNumb is a number and the proper length - let's see if it is a valid card number
        if(len >= 15){  // 15 or 16 for Amex or V/MC
            for(var i=len;i>0;i--){  // LOOP throught the digits of the card
                calc = parseInt(iCCN) % 10;  // right most digit
                calc = parseInt(calc);  // assure it is an integer
                iTotal += calc;  // running total of the card number as we loop - Do Nothing to first digit
                i--;  // decrement the count - move to the next digit in the card
                iCCN = iCCN / 10;                               // subtracts right most digit from ccNumb
                calc = parseInt(iCCN) % 10 ;    // NEXT right most digit
                calc = calc *2;                                 // multiply the digit by two
                // Instead of some screwy method of converting 16 to a string and then parsing 1 and 6 and then adding them to make 7,
                // I use a simple switch statement to change the value of calc2 to 7 if 16 is the multiple.
                switch(calc){
                    case 10: calc = 1; break;       //5*2=10 & 1+0 = 1
                    case 12: calc = 3; break;       //6*2=12 & 1+2 = 3
                    case 14: calc = 5; break;       //7*2=14 & 1+4 = 5
                    case 16: calc = 7; break;       //8*2=16 & 1+6 = 7
                    case 18: calc = 9; break;       //9*2=18 & 1+8 = 9
                    default: calc = calc;           //4*2= 8 &   8 = 8  -same for all lower numbers
                }
                iCCN = iCCN / 10;  // subtracts right most digit from ccNum
                iTotal += calc;  // running total of the card number as we loop
            }  // END OF LOOP
            if ((iTotal%10)==0){  // check to see if the sum Mod 10 is zero
                bResult = true;  // This IS (or could be) a valid credit card number.
            } else {
                bResult = false;  // This could NOT be a valid credit card number
            }
        }
    }
    // change alert to on-page display or other indication as needed.
    //if(bResult) {
    //  alert("This IS a valid Credit Card Number!");
    //}
    //if(!bResult){
    //  alert("This is NOT a valid Credit Card Number!");
    //}
    return bResult; // Return the results
}



function ValidateExpDate(year,month)

{

    var ccExpYear = year;

    var ccExpMonth = month;



    var expDate=new Date();

    expDate.setFullYear(ccExpYear, ccExpMonth, 1);



    var today = new Date();



    if (expDate<today)

    {

        // Credit Card is expire

        return false;

    }

    else

    {

        // Credit is valid

        return true;

    }

}




//  End -->
