function validate(form) {
	fail  = validateUsername(form.username.value)
	fail += validatePassword(form.password.value)
	
	if (fail == "") {
		return true;
	} else {
		alert(fail);
		return false
	}
}

function validateUsername(field) {
	if ( field == "" ) {
		return "No Username was entered.\n"
	} else if ( field.length < 3 ) {
		return "Usernames must be at least 3 characters.\n"
	} else if ( /[^a-zA-Z]/.test(field) ) {
		return "Only letters allowed in Usernames.\n"
	}
	return ""
}
function validatePassword(field) {
	if ( field == "" ) {
		return "No Password was entered.\n"
	} else if ( field.length < 3 ) {
		return "Passwords must be at least 3 characters.\n"
	} else if ( /[^a-zA-Z0-9]/.test(field) ) {
		return "Only letters and numbers in password and its case sensitive.\n"
	}
	return ""
}