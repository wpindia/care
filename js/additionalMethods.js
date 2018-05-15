jQuery('document').ready(function(){
	jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
		return this.optional(element) || /^[a-z-.,()'\"\s]+$/i.test(value);
	}, "Letters or punctuation only please");  

	jQuery.validator.addMethod("alphanumeric", function(value, element) {
		return this.optional(element) || /^\w+$/i.test(value);
	}, "Letters, numbers, spaces or underscores only please");  

	jQuery.validator.addMethod("lettersonly", function(value, element) {
		return this.optional(element) || /^[a-z]+$/i.test(value);
	}, "Letters only please"); 

	jQuery.validator.addMethod("nowhitespace", function(value, element) {
		return this.optional(element) || /^\S+$/i.test(value);
	}, "No white space please"); 

	jQuery.validator.addMethod("ziprange", function(value, element) {
		return this.optional(element) || /^90[2-5]\d\{2}-\d{4}$/.test(value);
	}, "Your ZIP-code must be in the range 902xx-xxxx to 905-xx-xxxx");

	jQuery.validator.addMethod("integer", function(value, element) {
		return this.optional(element) || /^-?\d+$/.test(value);
	}, "A positive or negative non-decimal number please");

	jQuery.validator.addMethod("letterswithspaces", function(value, element) 
	{
	return this.optional(element) || /^[a-z ]+$/i.test(value);
	}, "Letters and spaces only please");
});