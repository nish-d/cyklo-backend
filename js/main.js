var source = new EventSource("recieve.php");

source.addEventListener("request_unlock", function(event) {
    var array = event.data.split("\n");
    for(var i = 0; i < array.length; i++) {
        createItem(JSON.parse(array[i]), "unlock");
    }
}, false);

source.addEventListener("request_lock", function(event) {
    //TODO: lock request event listener
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
    cycle_number.appendChild(document.createTextNode(obj.cycle_number));

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
    parent.appendChild(btnYes);
    parent.appendChild(btnNo);

    document.getElementById(lock_state).appendChild(parent);
}

var userData = function(name, college, number, email, cycle_number, lock_state, accepted) {
    this.name = name;
    this.college = college;
    this.number = number;
    this.email = email;
    this.cycle_number = cycle_number;
    this.lock_state = (lock_state == "unlock")? 0: 1;
    this.accepted = accepted;
};

function onYesClick(element, lock_state) {
    var children = element.parentElement.children;
    var name = children[0].innerText.replace(" ", "%20");
    var college = children[1].innerText;
    var number = children[2].innerText;
    var email = children[3].innerText;
    var cycle_number = children[4].innerText;
    var obj = new userData(name, college, number, email, cycle_number, lock_state, 1);
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
    var cycle_number = children[4].innerText;
    var obj = new userData(name, college, number, email, cycle_number, lock_state, -1);
    console.log(obj);
    getData("service", obj);
    element.parentElement.remove();
    // TODO: onNoClick
}

function getData(id, obj) {
    var send = "res/" + id + ".php?";
    for(var i in obj)
        // TODO: if(obj[i])
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
            msg +=  "Amount = Rs. 10 + Rs. " + data.amount + " = Rs. " + (10 + data.amount);
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
