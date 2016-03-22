var source = new EventSource("recieve.php");

var normalCycleNumbers=["007","111","420","555","911", "CY*14", "CY*22"];
var premiumCycleNumbers=["CY*14", "CY*22"];

source.addEventListener("request_unlock", function(event) {
    var array = event.data.split("\n");
    for(var i = 0; i < array.length; i++) {
        createItem(JSON.parse(array[i]), "unlock");
    }
}, false);

source.addEventListener("request_lock", function(event) {
    var array = event.data.split("\n");
    for(var i = 0; i < array.length; i++) {
        createItem(JSON.parse(array[i]), "lock");
    }
}, false);

function createItem(obj, lock_state) {
    var parent = document.createElement("div");
    parent.className = "parent";

    var name = document.createElement("p");
    name.className = "name";
    name.appendChild(document.createTextNode(obj.name));

    var college = document.createElement("p");
    college.className = "college";
    college.appendChild(document.createTextNode(obj.college));

    var number = document.createElement("p");
    number.className = "number";
    number.appendChild(document.createTextNode(obj.number));

    var email = document.createElement("p");
    email.className = "email";
    email.appendChild(document.createTextNode(obj.email));

    var cycle_number = document.createElement("p");
    cycle_number.className = "cycle";
    var cycleNumbers = (obj.cycle_type === 0) ? normalCycleNumbers: premiumCycleNumbers;
    cycle_number.appendChild(document.createTextNode(cycleNumbers[obj.cycle_number-1]));

    var cycle_type = document.createElement("p");
    cycle_type.className = "type";
    cycle_type.appendChild(document.createTextNode((obj.cycle_type === 0) ? "Normal" : "Premium"));

    var btnYes = document.createElement("button");
    btnYes.className = "btnYes";
    btnYes.setAttribute("onclick", "onYesClick(this, '" + lock_state + "')");
    btnYes.appendChild(document.createTextNode("YES"));

    var btnNo = document.createElement("button");
    btnNo.className = "btnNo";
    btnNo.setAttribute("onclick", "onNoClick(this, '" + lock_state + "')");
    btnNo.appendChild(document.createTextNode("NO"));

    parent.appendChild(name);
    parent.appendChild(college);
    parent.appendChild(number);
    parent.appendChild(email);
    parent.appendChild(cycle_number);
    parent.appendChild(cycle_type);
    parent.appendChild(btnYes);
    parent.appendChild(btnNo);

    document.getElementById(lock_state).appendChild(parent);
}

var userData = function(name, college, number, email, cycle_number, lock_state, accepted, cycle_type) {
    this.name = name;
    this.college = college;
    this.number = number;
    this.email = email;
    this.cycle_number = cycle_number;
    this.lock_state = (lock_state == "unlock")? 0: 1;
    this.accepted = accepted;
    this.cycle_type = cycle_type;
};

function onYesClick(element, lock_state) {
    var children = element.parentElement.children;
    var name = children[0].innerText.replace(" ", "%20");
    var college = children[1].innerText;
    var number = children[2].innerText;
    var email = children[3].innerText;
    var cycleNumbers = (obj.cycle_type === 0) ? normalCycleNumbers: premiumCycleNumbers;
    var cycle_number = cycleNumbers.indexOf(children[4].innerText)+1;
    var cycle_type = (children[5].innerText === "Normal") ? 0 : 1;
    var obj = new userData(name, college, number, email, cycle_number, lock_state, 1, cycle_type);
    console.log(obj);
    switch (lock_state) {
        case "unlock":
            getData("service", obj);
            break;
        case "lock":
            getData("amount", obj);
            break;
    }
    element.parentElement.remove();
}

function onNoClick(element, lock_state) {
    var children = element.parentElement.children;
    var name = children[0].innerText.replace(" ", "%20");
    var college = children[1].innerText;
    var number = children[2].innerText;
    var email = children[3].innerText;
    var cycleNumbers = (obj,cycle_type === 0) ? normalCycleNumbers: premiumCycleNumbers;
    var cycle_number = cycleNumbers.indexOf(children[4].innerText)+1;
    var cycle_type = (children[5].innerText === "Normal") ? 0 : 1;
    var obj = new userData(name, college, number, email, cycle_number, lock_state, -1, cycle_type);
    console.log(obj);
    getData("service", obj);
    element.parentElement.remove();
}

function getData(id, obj) {
    var send = "res/" + id + ".php?";
    for(var i in obj)
        // TODO: if(obj[i]) Checking if obj has data in it (just making it more secure, unseen scenario)
              send += i + '=' + obj[i] + '&';

    console.log(send);
    $.get(send, function(data) {
        if (!data.error)
            dealWithData(data, obj.lock_state, id, obj);
    }, 'json');
}

function dealWithData(data, lock_state, id, obj) {
    console.log(data);
    //unlock service
    if(lock_state === 0 && data.time !== undefined) {
        console.log("no error");
        alert("Time starts at " + data.time);
    }

    //lock service
    else {
        if(id == "amount") {
            var msg = "Minutes = " + data.minutes + " mins\n";
            msg +=  "Amount = " + data.amount;
            var con = confirm(msg);
            if(con) {
                getData("service", obj);
            }
            else {
                // TODO: Reject amount
            }
        }
        if (id == "service" && data.time !== undefined) {
            console.log("no error");
            alert("Time stops at " + data.time);
        }
    }
}
