<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if( isset($_POST['submit']) ){
	
	//form validation vars
	$formok = true;
	$errors = array();
	
	//sumbission data
	$ipaddress = $_SERVER['REMOTE_ADDR'];
	$date = date('d/m/Y');
	$time = date('H:i:s');
	
	//form data
	$name = $_POST['name'];	
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	$enquiry = $_POST['enquiry'];
	$message = $_POST['message'];
	
	//validate form data
	
	//validate name is not empty
	if(empty($name)){
		$formok = false;
		$errors[] = "You have not entered a name";
	}
	
	//validate email address is not empty
	if(empty($email)){
		$formok = false;
		$errors[] = "You have not entered an email address";
	//validate email address is valid
	}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$formok = false;
		$errors[] = "You have not entered a valid email address";
	}
	
	//validate message is not empty
	if(empty($message)){
		$formok = false;
		$errors[] = "You have not entered a message";
	}
	//validate message is greater than 20 charcters
	elseif(strlen($message) < 20){
		$formok = false;
		$errors[] = "Your message must be greater than 20 characters";
	}
	
	//send email if all is ok
	if($formok){
		$headers = "From: {$name} <{$email}> "."\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		$emailbody = "<p>Social Feed Support (Free Version).</p>
					  <p><strong>Name: </strong> {$name} </p>
					  <p><strong>Email Address: </strong> {$email} </p>
					  <p><strong>Website URL: </strong> {$telephone} </p>
					  <p><strong>Enquiry: </strong> {$enquiry} </p>
					  <p><strong>Message: </strong> {$message} </p>
					  <p>This message was sent from the IP Address: {$ipaddress} on {$date} at {$time}</p>";
		
		mail("arrowplugins@gmail.com","Social Feed Support (Free Version)",$emailbody,$headers);
		
	}
	
	//what we need to return back to our form
	$returndata = array(
		'posted_form_data' => array(
			'name' => $name,
			'email' => $email,
			'telephone' => $telephone,
			'enquiry' => $enquiry,
			'message' => $message
		),
		'form_ok' => $formok,
		'errors' => $errors
	);
		
	
	//if this is not an ajax request
	if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'){
		//set session variables
		$_SESSION['cf_returndata'] = $returndata;
		
		//redirect back to form
		
	}
}

?>
<script type="text/javascript">
	window.log = function(){
  log.history = log.history || [];  
  log.history.push(arguments);
  arguments.callee = arguments.callee.caller;  
  if(this.console) console.log( Array.prototype.slice.call(arguments) );
};
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();)b[a]=b[a]||c})(window.console=window.console||{});



jQuery(document).ready(function($){

	//set global variables and cache DOM elements for reuse later
	var form = $('#upc_contact-form').find('form'),
		formElements = form.find('input[type!="submit"],textarea'),
		formSubmitButton = form.find('[type="submit"]'),
		errorNotice = $('#upc_errors'),
		successNotice = $('#upc_success'),
		loading = $('#loading'),
		errorMessages = {
			required: ' is a required field',
			email: 'You have not entered a valid email address for the field: ',
			minlength: ' must be greater than '
		}
	
	//feature detection + polyfills
	formElements.each(function(){

		//if HTML5 input placeholder attribute is not supported
	
		
		//if HTML5 input autofocus attribute is not supported
	
		
	});
	
	//to ensure compatibility with HTML5 forms, we have to validate the form on submit button click event rather than form submit event. 
	//An invalid html5 form element will not trigger a form submit.
	formSubmitButton.bind('click',function(){
		var formok = true,
			errors = [];
			
		formElements.each(function(){
			var name = this.name,
				nameUC = name.ucfirst(),
				value = this.value,
				placeholderText = this.getAttribute('placeholder'),
				type = this.getAttribute('type'), //get type old school way
				isRequired = this.getAttribute('required'),
				minLength = this.getAttribute('data-minlength');
			
			//if HTML5 formfields are supported			
			if( (this.validity) && !this.validity.valid ){
				formok = false;
				
				console.log(this.validity);
				
				//if there is a value missing
				if(this.validity.valueMissing){
					errors.push(nameUC + errorMessages.required);	
				}
				//if this is an email input and it is not valid
				else if(this.validity.typeMismatch && type == 'email'){
					errors.push(errorMessages.email + nameUC);
				}
				
				this.focus(); //safari does not focus element an invalid element
				return false;
			}
			
			//if this is a required element
			if(isRequired){	
				//if HTML5 input required attribute is not supported
				if(!Modernizr.input.required){
					if(value == placeholderText){
						this.focus();
						formok = false;
						errors.push(nameUC + errorMessages.required);
						return false;
					}
				}
			}

			//if HTML5 input email input is not supported
			if(type == 'email'){ 	
				if(!Modernizr.inputtypes.email){ 
					var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/; 
				 	if( !emailRegEx.test(value) ){	
						this.focus();
						formok = false;
						errors.push(errorMessages.email + nameUC);
						return false;
					}
				}
			}
			
			//check minimum lengths
			if(minLength){
				if( value.length < parseInt(minLength) ){
					this.focus();
					formok = false;
					errors.push(nameUC + errorMessages.minlength + minLength + ' charcters');
					return false;
				}
			}
		});
		
		//if form is not valid
		if(!formok){
			
			//animate required field notice
			$('#req-field-desc')
				.stop()
				.animate({
					marginLeft: '+=' + 5
				},150,function(){
					$(this).animate({
						marginLeft: '-=' + 5
					},150);
				});
			
			//show error message 
			showNotice('error',errors);
			
		}
		//if form is valid
		else {
			loading.show();
			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				success: function(){
					showNotice('success');
					form.get(0).reset();
					loading.hide();
				}
			});
		}
		
		return false; //this stops submission off the form and also stops browsers showing default error messages
		
	});

	//other misc functions
	function showNotice(type,data)
	{
		if(type == 'error'){
			successNotice.hide();
			errorNotice.find("li[id!='info']").remove();
			for(x in data){
				errorNotice.append('<li>'+data[x]+'</li>');	
			}
			errorNotice.show();
		}
		else {
			errorNotice.hide();
			successNotice.show();	
		}
	}
	
	String.prototype.ucfirst = function() {
		return this.charAt(0).toUpperCase() + this.slice(1);
	}
	
});


</script>
<style>
    


#upc_contact-form {
    background-color:#F2F7F9;
    width:465px;
    padding:20px;
    margin: 50px;   
    border: 6px solid #8FB5C1;
    -moz-border-radius:15px;
    -webkit-border-radius:15px;
    border-radius:15px;
    position:relative;
    text-align: center;
}

#upc_contact-form h1 {
    font-size:42px;
}

#upc_contact-form h2 {
    margin-bottom:15px;
    font-style:italic;
    font-weight:normal;
}

#upc_contact-form input, 
#upc_contact-form select, 
#upc_contact-form textarea, 
#upc_contact-form label {
    font-size:15px;
    margin-bottom:2px;
}

#upc_contact-form input, 
#upc_contact-form select, 
#upc_contact-form textarea {
    width:450px;
    border: 1px solid #CEE1E8;
    margin-bottom:20px;
    padding:4px;
    height: 40px;
}

#upc_contact-form input:focus, 
#upc_contact-form select:focus, 
#upc_contact-form textarea:focus {
    border: 1px solid #AFCDD8;
    background-color: #EBF2F4;
}

#upc_contact-form textarea {
    height:150px;
    resize: none;
}

#upc_contact-form label {
    display:block;
}

#upc_contact-form .required {
    font-weight:bold;
    color:#F00; 
}

#upc_contact-form #submit-button {
        width: 97%;
    background-color:#333;
    color:#FFF;
    border:none;
    display:block;
    margin-bottom:0px;
    margin-right:6px;
    background-color:#8FB5C1;
    -moz-border-radius:8px;
    margin: 0 auto;
}

#upc_contact-form #submit-button:hover {
    background-color: #A6CFDD;
}

#upc_contact-form #submit-button:active {
    position:relative;
    top:1px;
}

#upc_contact-form #loading {
    width:32px;
    height:32px;
    display:block;
    position:absolute;
    right:130px;
    bottom:16px;
    display:none;
}

#upc_errors {
    border:solid 1px #E58E8E;
    padding:10px;
    margin:25px 0px;
    display:block;
    width:437px;
    -webkit-border-radius:8px;
    -moz-border-radius:8px;
    border-radius:8px;
    display:none;
}

#upc_errors li {
    padding:2px;
    list-style:none;    
}

#upc_errors li:before {
    content: ' - '; 
}

#upc_errors #upc_info {
    font-weight:bold;
}

#upc_errors #upc_info:before {
    content: '';    
}

#upc_success {
    border:solid 1px #83D186;
    padding:25px 10px;
    margin:25px 0px;
    display:block;
    width:437px;
    -webkit-border-radius:8px;
    -moz-border-radius:8px;
    border-radius:8px;
    font-weight:bold;
    display:none;
}

#upc_errors.visible, #upc_success.visible {
    display:block;  
}

#upc_req-field-desc {
    font-style:italic;
}
</style>
<div id="container">
        <div id="upc_contact-form" class="clearfix">
            <h1>Get 24/7 Support!</h1>
            <h2>Contact us anytime, we'll do our best to answer and resolve all your questions & issues as soon as possible</h2>

            <?php
            //init variables
            $cf = array();
            $sr = false;
            
            if(isset($_SESSION['cf_returndata'])){
                $cf = $_SESSION['cf_returndata'];
                $sr = true;
            }
            ?>
            <ul id="upc_errors" class="<?php echo ($sr && !$cf['form_ok']) ? 'visible' : ''; ?>">
                <li id="upc_info">There were some problems with your form submission:</li>
                <?php 
                if(isset($cf['errors']) && count($cf['errors']) > 0) :
                    foreach($cf['errors'] as $error) :
                ?>
                <li><?php echo $error ?></li>
                <?php
                    endforeach;
                endif;
                ?>
            </ul>
            <p id="upc_success" class="<?php echo ($sr && $cf['form_ok']) ? 'visible' : ''; ?>">THANK YOU!<br/>
Your message has been sent successfully, Our support team will be in touch with you very soon.</p>
            <form method="post" action="">
                <label for="name">Name: <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="<?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['name'] : '' ?>" placeholder="John Doe" required autofocus />
                
                <label for="email">Email Address: <span class="required">*</span></label>
                <input type="email" id="email" name="email" value="<?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['email'] : '' ?>" placeholder="johndoe@example.com" required />
                
                <label for="telephone">Website URL: <span class="required">*</span></label>
                <input type="url" id="telephone" name="telephone" value="<?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['telephone'] : '' ?>" required/>
                
                <label for="enquiry">Enquiry: </label>
                <select id="enquiry" name="enquiry">
                    <option value="General" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['enquiry'] == 'General') ? "selected='selected'" : '' ?>>General</option>
                    <option value="Support" <?php echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['enquiry'] == 'Support') ? "selected='selected'" : '' ?>>Support</option>
                </select>
                
                <label for="message">Message: <span class="required">*</span></label>
                <textarea id="message" name="message" placeholder="Your message must be greater than 20 charcters" required data-minlength="20"><?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['message'] : '' ?></textarea>
                
                <span id="loading"></span>
                <input type="submit" value="Submit!" name="submit" id="submit-button" />
                <p id="req-field-desc"><span class="required">*</span> indicates a required field</p>
            </form>
            <?php unset($_SESSION['cf_returndata']); ?>
        </div>
    </div>
