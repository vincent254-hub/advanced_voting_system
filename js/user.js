
function loginValidate(loginForm){

var validationVerified=true;
var errorMessage="";
var okayMessage="click OK to continue";

if (loginForm.myusername.value=="")
{
errorMessage+="Email field empty!\n";
validationVerified=false;
}
if(loginForm.mypassword.value=="")
{
errorMessage+="Password field empty!\n";
validationVerified=false;
}
if (!isValidEmail(loginForm.myusername.value)) {
errorMessage+="Invalid email address provided!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
if(validationVerified)
{
alert(okayMessage);
}
return validationVerified;
}

function registerValidate(registerForm){

var validationVerified=true;
var errorMessage="thank you! for registering";
var okayMessage="click OK to proceed for registration";

if (registerForm.firstname.value=="")
{
errorMessage+="Firstname not filled!\n";
validationVerified=false;
}
if(registerForm.lastname.value=="")
{
errorMessage+="Lastname not filled!\n";
validationVerified=false;
}
if (registerForm.email.value=="")
{
errorMessage+="Email not filled!\n";
validationVerified=false;
}
if(registerForm.password.value=="")
{
errorMessage+="Password not provided!\n";
validationVerified=false;
}
if(registerForm.ConfirmPassword.value=="")
{
errorMessage+="Confirm password not filled!\n";
validationVerified=false;
}
if(registerForm.ConfirmPassword.value!=registerForm.password.value)
{
errorMessage+="Confirm password and password do not match!\n";
validationVerified=false;
}
if (!isValidEmail(registerForm.email.value)) {
errorMessage+="Invalid email address provided!\n";
validationVerified=false;
}    
if(!validationVerified)
{
alert(errorMessage);
}
if(validationVerified)
{
alert(okayMessage);
}
return validationVerified;    

}


function updateProfile(registerForm){

var validationVerified=true;
var errorMessage="";
var okayMessage="click OK to update your account";

if (registerForm.firstname.value=="")
{
errorMessage+="Firstname field empty!\n";
validationVerified=false;
}
if(registerForm.lastname.value=="")
{
errorMessage+="Lastname field empty!\n";
validationVerified=false;
}
if (registerForm.email.value=="")
{
errorMessage+="Email field empty!\n";
validationVerified=false;
}
if(registerForm.password.value=="")
{
errorMessage+="New password field provided!\n";
validationVerified=false;
}
if(registerForm.ConfirmPassword.value=="")
{
errorMessage+="Confirm password field empty!\n";
validationVerified=false;
}
if(registerForm.ConfirmPassword.value!=registerForm.password.value)
{
errorMessage+="Confirm password and new password do not match!\n";
validationVerified=false;
}
if (!isValidEmail(registerForm.email.value)) {
errorMessage+="Invalid email address provided!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
if(validationVerified)
{
alert(okayMessage);
}
return validationVerified;
}

function isValidEmail(val) {
	var re = /^[\w\+\'\.-]+@[\w\'\.-]+\.[a-zA-Z]{2,}$/;
	if (!re.test(val)) {
		return false;
	}
    return true;
}
function isValidSpecialPIN(val) {
	var re = /^[0-9][0-9][A-Z][A-Z][A-Z][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$/;
	if (!re.test(val)) {
		return false;
	}
	return true;
}

function isValidLength(val){
	var length = 12;
	if (!re.test(val)) {
		return false;
	}
	return true;
}

function getProductTotal(field) {
    clearErrorInfo();
    var form = field.form;
	if (field.value == "") field.value = 0;
	if ( !isPosInt(field.value) ) {
        var msg = 'No value provided.';
        addValidationMessage(msg);
        addValidationField(field)
        displayErrorInfo( form );
        return;
	} else {
		var product = field.name.slice(0, field.name.lastIndexOf("_") ); 
        var price = form.elements[product + "_price"].value;
		var amt = field.value * price;
		form.elements[product + "_tot"].value = formatDecimal(amt);
		doTotals(form);
	}
}

function doTotals(form) {
    var total = 0;
    for (var i=0; PRODUCT_ABBRS[i]; i++) {
        var cur_field = form.elements[ PRODUCT_ABBRS[i] + "_qty" ]; 
        if ( !isPosInt(cur_field.value) ) {
            var msg = 'No value provided.';
            addValidationMessage(msg);
            addValidationField(cur_field)
            displayErrorInfo( form );
            return;
        }
        total += parseFloat(cur_field.value) * parseFloat( form.elements[ PRODUCT_ABBRS[i] + "_price" ].value );
    }
    form.elements['total'].value = formatDecimal(total);
}


function finalCheck(orderForm) {
    var validationVerified=true;
var errorMessage="";
var okayMessage="click OK to process your order";

if (orderForm.quantity.value=="")
{
errorMessage+="Please provide a quantity.\n";
validationVerified=false;
}
if (orderForm.quantity.value==0)
{
errorMessage+="Please provide a quantity rather than 0.\n";
validationVerified=false;
}
if(orderForm.total.value=="")
{
errorMessage+="Total has not been calculated! Please provide first the quantity.\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
if(validationVerified)
{
alert(okayMessage);
}
return validationVerified;
}

//validate updateForm
function updateValidate(updateForm) {
    var validationVerified=true;
var errorMessage="";
var okayMessage="click OK to Accept password change";

if (updateForm.opassword.value=="")
{
errorMessage+="Oops! Kindly provide your prevoius password.\n";
validationVerified=false;
}
if (updateForm.npassword.value=="")
{
errorMessage+="Oops! Kindly provide a new password.\n";
validationVerified=false;
}
if(updateForm.cpassword.value=="")
{
errorMessage+="Please confirm your new password.\n";
validationVerified=false;
}
if(updateForm.cpassword.value!=updateForm.npassword.value)
{
errorMessage+="Confirm password and new password do not match!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
if(validationVerified)
{
alert(okayMessage);
}
return validationVerified;
}



function reserveValidate(reserveForm){

var validationVerified=true;
var errorMessage="";
var okayMessage="click OK to reserve this table";

if (reserveForm.tNumber.selectedIndex==0)
{
errorMessage+="Please select a table by its number!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
if(validationVerified)
{
alert(okayMessage);
}
return validationVerified;
}
function positionValidate(positionForm){

var validationVerified=true;
var errorMessage="";
var okayMessage="select OK to see the candidates under the chosen position";

if (positionForm.position.selectedIndex == 0)
{
errorMessage+="Position not set!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
if(validationVerified)
{
alert(okayMessage);
}
return validationVerified;
}