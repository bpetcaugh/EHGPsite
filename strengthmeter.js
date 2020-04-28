function passwordStrength(password) {
    

    var desc = new Array();

    desc[0] = "Does not meet requirements";

	desc[1] = "Weak";

	desc[2] = "Medium";

	desc[3] = "Strong";
		
	var score=0;

	if(password.length > 8){
		document.getElementById("subPass").style.visibility="visible";
		if ((password.match(/[a-z]/))  && (password.match(/[A-Z]/))){
			
			if (password.match(/\d+/)){
				score++;
				//if password has at least one special character give 1 point
				if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ){
					score++;
				}
				//if password bigger than 12 give another 1 point
				if (password.length > 12){
					score++;
				}
			}else{
				document.getElementById("subPass").style.visibility="hidden";
			}
		}else{
			document.getElementById("subPass").style.visibility="hidden";
		}
	}else{
		document.getElementById("subPass").style.visibility="hidden";
	}

	document.getElementById("passwordDescription").innerHTML = desc[score];

	document.getElementById("passwordStrength").className = "strength" + score;
	
}