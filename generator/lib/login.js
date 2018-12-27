function login(){
    	$.post('lib/auth.php?action=login', $("#login-form").serialize(), function(data){   
		
            var btn = $("#loginButton");
            switch(data){
                case "success": 
					btn.html('Logging In Please Wait');
                    toastr.success("Successfully Signed In"); 
                    window.setTimeout(function() { window.location.href = '/Dashboard/';}, 5000); 
                break;
                case "banned": 
					btn.html('Your Account Has Been Banned');
                    toastr.error("Your Account Has Been Banned"); 
                break;
                case "no-exist": 
                    toastr.error("The Username / Password You Entered Doesnt Exist"); 
                break;
                case "error": 
                    toastr.error("There Was An Error"); 
                break;
                case "incorrect-pass": 
                    toastr.error("The Username / Password You Entered Was Incorrect"); 
                break;
            }   
        });
    }
    
    function test(){
        toastr.success("test");
    }