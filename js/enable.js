function validate1() {
    var cycle_type = document.getElementById("cycle_type").value;
    var cycle_number = document.getElementById("cycle_number").value;
    document.getElementById("lcycle_type").innerHTML="";
    document.getElementById("lcycle_number").innerHTML="";
    var validate = 0;

				//phone validate
                if (cycle_type==1) {
                    if(cycle_number<0 || cycle_number>2){
                        validate=1;
                        document.getElementById("lcycle_number").innerHTML="INVALID";
                        return false;
                    };
				};
    
                if (cycle_type==0) {
                    if(cycle_number<0 || cycle_number>5){
                        validate=1;
                        document.getElementById("lcycle_number").innerHTML="INVALID";
                        return false;
                    };
				};
                
                if (cycle_type<0 || cycle_type>1){
                    validate=1;
                    document.getElementById("lcycle_type").innerHTML="INVALID";
                    return false;
                }

				if(validate==0){
                    return true;
				};
};