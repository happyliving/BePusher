window.onload = function () {
    startRange();
}

var logToDom = function (type, message) {

    var name = message["name"];
    var uuid = message["uuid"];
    var major = message["major"];
    var minor = message["minor"];
    var accuracy = message["accuracy"];
    var rssi = message["rssi"];
    var beaconName = document.getElementById("beaconName");

    console.log(message);

    var existBeacon = document.getElementById(name + "_" + major + "_" + minor);


    if (existBeacon != undefined) {
        
        existBeacon.innerHTML = '<img src = "images/beacon.png" style = "width:15%;height:15%;float:left;margin-right:5%;margin-left:5%;">';

        existBeacon.innerHTML += "name : " + name + "<br>"
            + "major : " + major + "<br>"
            + "minor : " + minor + "<br>"
            + "rssi : " + rssi + "<br>"
            + "accuracy : " + accuracy + "<br<br><hr>";

       

    } else {
        switch (type) {
            case 'EventType':
                break;
            case 'Region':
                break;
            case 'Beacons':
                var outerDiv = document.createElement('div');
                var beacon = document.createElement('div');

              //  beacon.setAttribute(id,'name + "_" + major + "_" + minor' );
                beacon.classList.add('beacon');

                beacon.innerHTML = '<img src = "images/beacon.png" style = "width:15%;height:15%;float:left;margin-right:5%;margin-left:5%;">';

                beacon.innerHTML += "<div style='float:right'>name : " + name + "<br>"
                    + "major : " + major + "<br>"
                    + "minor : " + minor + "<br>"
                    + "rssi : " + rssi + "<br>"
                    + "accuracy : " + accuracy + "</div>";
                beacon.setAttribute("id", name + "_" + major + "_" + minor);

                outerDiv.appendChild(beacon);

                outerDiv.innerHTML += '<table class="table table-striped">' +
                    ' <tbody><tr><td>x</td><td>y</td><td>z</td></tr>' +
                    '<tr>' +
                    '<td><input id="' + name + "_" + major + "_" + minor + '_buttonx" type="number" style="float:left;width:50%" /></td>' +
                    '<td><input id="' + name + "_" + major + "_" + minor + '_buttony" type="number" style="float:left;width:50%" /></td>' +
                    '<td><input id="' + name + "_" + major + "_" + minor + '_buttonz" type="number" style="float:left;width:50%" /></td>' +
                    '<td><div><img style="display:none;" width="40" height="40"  src="images/loading.gif"><button id = "'+name + '_' + major + '_' + minor+'_button" type="button" onclick = "audit(this)" style="display:block;" class="btn btn-warning" >審核</button><h6 style="displaye:none;color: red;" value="審核成功"></h6></div></td></tr></tbody></table >';
                  

              

                
            
      

                document.getElementById('showBeacon').appendChild(outerDiv);
                break;
        }
    }
};


function audit(t) {
    var parent = t.parentNode;

    console.log(parent.firstChild);
    parent.firstChild.style.display = "block";
    t.style.display = "none";
    console.log(t.id);
    temp = t.id;
    setTimeout(function () {
        parent.lastChild.style.display = "block";
        parent.firstChild.style.display = "none";
        var beaconObject = new beaconObj(temp.split("_")[0], temp.split("_")[1], temp.split("_")[2],
            document.getElementById(temp + "x").value, document.getElementById(temp + "y").value, document.getElementById(temp + "z").value);
        beaconArray.push(beaconObject);
        console.log(beaconObject);
        parent.lastChild.innerHTML = "OK";
    }, 3000)

}

function beaconObj(name, major, minor, x, y, z) {

    this.name = name;
    this.minor = minor;
    this.major = major;
    this.x = x;
    this.y = y;
    this.z = z;
}

function startRange() {

    var beaconRegion = new cordova.plugins.locationManager.BeaconRegion("regionTest", "74278BDA-B644-4520-8F0C-720EAF059935");

    var delegate = new cordova.plugins.locationManager.Delegate();

    delegate.didRangeBeaconsInRegion = function (pluginResult) {
        logToDom('EventType', pluginResult["eventType"]);
        logToDom('Region', pluginResult["region"]);
        for (var i in pluginResult["beacons"])
            logToDom('Beacons', pluginResult["beacons"][i]);
    };


    cordova.plugins.locationManager.setDelegate(delegate);

    cordova.plugins.locationManager.startRangingBeaconsInRegion(beaconRegion)
        .fail(function (e) { console.error(e); })
        .done();

}

function stopRange() {

    var beaconRegion = new cordova.plugins.locationManager.BeaconRegion("regionTest", "74278BDA-B644-4520-8F0C-720EAF059935");

    cordova.plugins.locationManager.stopRangingBeaconsInRegion(beaconRegion)
        .fail(function (e) { console.error(e); })
        .done();
}

