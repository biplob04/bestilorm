function onlyAlphaLetters(event) {
    var key = event.keyCode;
    // Verifies if the user pressed left arrow, right arrow or delete key (Coudn't do it in regex)
    if (key == 37 || key == 39 || key == 46) 
        return true;

    // String.fromCharCode() turns whatever letter inside the parameters into a unicode
    // event.which returns a value
    var value = String.fromCharCode(event.which);
    var pattern = new RegExp(/[a-z\b ]/i); // Allows all letters, backspace and space.
    return pattern.test(value); // Verifies if value indeed matches the pattern
}

function postalCode(input) {
	var code = input.value;
	var pattern = new RegExp(/^\d{4}[-]\d{3}$/);

    if(code != '') {
    	if(!pattern.test(code)) 
    		document.getElementById('postCodError').style.display = 'block';
    	else 
    		document.getElementById('postCodError').style.display = 'none';
    }
}

function checkPass(newPass, repeatPass, errorMsg) {
    var newPass = document.getElementById(newPass);
    var newPassR = document.getElementById(repeatPass);
    var noMatchP = document.getElementById(errorMsg);

    if(newPassR != '') {
        if(newPass.value != newPassR.value) {
            noMatchP.style.display = 'block';
            return false;
        }
        else {
            noMatchP.style.display = 'none';
        }
    }
}
