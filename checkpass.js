/**
 *
 * Modified from the tutorial at:
 * http://keithscode.com/tutorials/javascript/3-a-simple-javascript-password-validator.html
 * 
 **/
function checkPass()
{
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    var pass3 = document.getElementById('pass3');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field
    //and the confirmation field
    if(pass1.value == pass2.value){
        //The passwords match.
        //Set the color to the good color and inform
        //the user that they have entered the correct password
        pass2.style.backgroundColor = goodColor
        if(pass1.value == pass3.value){
         pass3.style.backgroundColor = goodColor
         pass1.style.backgroundColor = goodColor
        }


    }
    else{
        if(pass2.value != pass1.value)
        pass2.style.backgroundColor = badColor

        if(pass3.value != pass1.value)
        pass3.style.backgroundColor = badColor

    }
}
