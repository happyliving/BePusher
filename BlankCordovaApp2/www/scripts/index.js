var notifNum = 0;
var carouselNum = 0;
var status = 0;
var subscribedBeaconArray = [];
var subscribedExhibition = [];
var subscribedExhibitionVersion = [];
var ver_id;
var subscribedPushArray = [];
var inExhibition = [];
var id;
var cnt = 0;
var default_r = 3;
var userName = null;
var password = null;
var deleteTarget = null;
var tempDelete;
//var url = "http://140.121.197.130";
var url = "https://bepusher.000webhostapp.com";

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-full-width",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

"use strict";
document.addEventListener('deviceready', onDeviceReady.bind(this), false);

function onDeviceReady() {

    // 處理 Cordova 暫停與繼續事件
    document.addEventListener('pause', onPause.bind(this), false);
    document.addEventListener('resume', onResume.bind(this), false);

    // TODO: Cordova 已載入。請在這裡執行任何需要 Cordova 的初始化作業。
    var parentElement = document.getElementById('deviceready');
    var listeningElement = parentElement.querySelector('.listening');
    var receivedElement = parentElement.querySelector('.received');
    listeningElement.setAttribute('style', 'display:none;');
    receivedElement.setAttribute('style', 'display:block;');
    //window.plugins.PushbotsPlugin.initialize("5989527b4a9efa19fc8b4567", { "android": { "sender_id": "784353059382" } });
    $("#initial").fadeOut("slow");
    $("#loaded").fadeIn("slow");
    $("#discovered").fadeIn("slow");
    getData();
    if (status == 1) {

    }
};

function discovered() {
    $("#discovered").fadeIn("slow");
    $("#recorded").fadeOut("slow");
    $("#add").fadeOut("slow");
    getData();
}

function record() {
    console.log(status);
    if (status == 1) {
        $("#discovered").fadeOut("slow");
        $("#recorded").fadeIn("slow");
        $("#add").fadeOut("slow");
        refresh();
        getMyData();
    }
    else {
        Command: toastr["warning"]("請登入來執行此動作");
        $("#signModal").modal("show");
    }
}

function add() {

    if (status == 1) {
        $("#discovered").fadeOut("slow");
        $("#record").fadeOut("slow");
        $("#add").fadeIn("slow");
        stopRange();
        document.location.href = "step1.html";
    }
    else {
        $("#addBtn").attr("href", "#page-top")
        Command: toastr["warning"]("請登入來執行此動作")
        $("#signModal").modal("show");
    }
}

function addNotif(title, information, vendorId, imgArray, typeArray, url, fb_url, twitter_url) {

    Command: toastr["success"]("你有新的通知!!");
    var temp =
        "<ul class='event-list'>" +
        "<li>" +
        "<time datetime=''>" +
        "<button id='rmNotifBtn' type='button' class='close' style='color:white;'>&times;</button>" +
        "<span class='vendor'>" + vendorId + "</span>" +
        "</time>" +
        "<div id='myCarousel" + carouselNum + "' class='carousel slide' data-ride='carousel' style='margin:0px;'>" +
        '<ol class="carousel-indicators">' +
        "<li data-target='#myCarousel" + carouselNum + "' data-slide-to='0' class='active'></li>" +
        "<li data-target='#myCarousel" + carouselNum + "' data-slide-to='1'></li>" +
        "<li data-target='#myCarousel" + carouselNum + "' data-slide-to='2'></li> " +
        "</ol>" +
        "<div class='carousel-inner'>" +
        "<div class='item active'>" +
        "<a href='" + url + "' target='_blank'>" +
        "<img src='data:image/" + typeArray[0] + ";base64," + imgArray[0] + "' class='img-responsive'/>" +
        "</a>" +
        "</div>" +
        "<div class='item'>" +
        "<a href='" + url + "' target='_blank'>" +
        "<img src='data:image/" + typeArray[1] + ";base64," + imgArray[1] + "' class='img-responsive'/>" +
        "</a>" +
        "</div>" +
        "<div class='item'>" +
        "<a href='" + url + "' target='_blank'>" +
        "<img src='data:image/" + typeArray[2] + ";base64," + imgArray[2] + "' class='img-responsive'/>" +
        "</a>" +
        "</div>" +
        "</div>" +
        "<a class='left carousel-control' href='#myCarousel" + carouselNum + "' data-slide='prev'>" +
        "<span class='glyphicon glyphicon-chevron-left'></span>" +
        "<span class='sr-only'>Previous</span>" +
        "</a>" +
        "<a class='right carousel-control' href='#myCarousel" + carouselNum + "' data-slide='next'>" +
        "<span class='glyphicon glyphicon-chevron-right'></span>" +
        "<span class='sr-only'>Next</span>" +
        "</a>" +
        "</div>" +
        "<div class='info'>" +
        "<h2 class='title'>" + title + "</h2>" +
        "<p class='desc'>" + information + "</p>";
    if (url != null) {
        temp +=
            "<ul>" +
            "<li style='width:50%;'><a href='" + url + "'><span class='fa fa-globe'></span>Website</a></li>" +
            "</ul>" +
            "</div>" +
            "<div class='social'>" +
            "<ul>";
    }
    else {
        temp +=
            "</div>" +
            "<div class='social'>" +
            "<ul>";
    }
    if (fb_url != null)
        temp += "<li class='facebook' style='width:33%;'><a href='" + fb_url + "'><span class='fa fa-facebook'></span></a></li>";
    else if (twitter_url != null)
        temp += "<li class='twitter' style='width:34%;'><a href='" + twitter_url + "'><span class='fa fa-twitter'></span></a></li>";
    temp +=
        "</ul>" +
        "</div>" +
        "</li>" +
        "</ul>";
    console.log(temp);
    $("#notifList").prepend(temp);
    carouselNum++;
    $(document).on('click', '#rmNotifBtn', function () {
        $(this).closest('ul').remove();
    });
    notifNum++;
    $("#notifNum").html(notifNum);
    $("#notifNum").show();
}

// Modal Image Gallery
function imgListener() {
    $("#exhibition > .discovered-block").click(function () {
        id = this.id;

        document.getElementById("imgFull").src = $('#' + this.id + ' > .discovered-middle > img')[0].src;
        document.getElementById("modalFull").style.display = "block";
        buttonArray = document.getElementById("modalFull").getElementsByTagName('button');
        if (status == 0) {
            buttonArray[0].style.display = 'none';
            buttonArray[1].style.display = 'none';
        }
        else if (subscribedExhibition[id] == true) {
            buttonArray[0].style.display = 'none';
            buttonArray[1].style.display = 'block';
        }
        else {
            buttonArray[1].style.display = 'none';
            buttonArray[0].style.display = 'block';
        }
        var captionText = document.getElementById("caption");
        captionText.innerHTML = "";

        span = document.createElement('h3');
        span.innerHTML = $('#' + this.id + ' > .discovered-bottom > span')[0].innerHTML;
        span.setAttribute('style', 'color:blue');
        captionText.appendChild(span);
        captionText.innerHTML += $('#' + this.id + ' > .discovered-bottom > span')[1].innerHTML;
    })
}

function editBtnListener() {
    $("#edit_exhibition").click(function () {
        deleteTarget = $(this).closest('.discovered-block').attr("id");
        tempDelete = $(this).closest('.discovered-block');
        console.log($(this));
        localStorage.setItem("exhibition_id", deleteTarget);
        document.location.href = "editPush.html";
    })
}

function delBtnListener() {
    $("#del_exhibition").click(function () {
        deleteTarget = $(this).closest('.discovered-block').attr("id");
        tempDelete = $(this).closest('.discovered-block');
        console.log($(this));
        localStorage.setItem("exhibition_id", deleteTarget);
    })
}

//hide notif num when click notifBtn
function notifBtnListener() {
    $("#notifBtn").click(function () {
        notifNum = 0;
        $("#notifNum").fadeOut();
    })
}

function resendBtnListener() {
    $("#resendBtn").click(function () {
        for (var i in subscribedPushArray)
            for (var j in subscribedPushArray[i])
                subscribedPushArray[i][j].isPush = false;
        Command: toastr["success"]("推播已刷新");
    });
}

function getMyData() {
    $.ajax({
        cache: true,
        dataType: "json",
        type: "POST",
        url: url + "/exhibition_server/exhibition/search_exhibition.php",
        data: $("#searchExhibition").serialize(),
        async: false,
        error: function (jqXhr, textStatus, errorThrown) { alert("目前無法拿到資料!" + textStatus + ': ' + errorThrown) },
        success: function (data) {
            $("#exhibition").html("");
            $("#record").html("");
            $("#my_exhibition").html("");
            var haveExhibition = 0;
            var d1 = document.createElement('div');
           
            for (var i in data) {


                if (subscribedExhibition[data[i].exhibition_id] == true) {

                    $("#record").append(

                        "<div class='discovered-block' id ='" + data[i].exhibition_id + "'>" +
                        "<div class='discovered-middle'>" +
                        "<img src='data:image/" + data[i].type + ";base64," + data[i].mapImage + "' class='img-responsive' alt='" + data[i].introduce + "' />" +
                        "</div>" +
                        "<div class='discovered-bottom'>" +
                        "<span class='title'>" + data[i].exhibition_name + "</span>" +
                        "<span class='info'>" + data[i].introduce + "</span>" +
                        "</div>" +
                        "</div>");

                }

                if (data[i].owner == userName) {

                    $("#my_exhibition").prepend(

                        "<div class='discovered-block' id ='" + data[i].exhibition_id + "'>" +
                        "<div class='discovered-middle'>" +
                        "<img src='data:image/" + data[i].type + ";base64," + data[i].mapImage + "' class='img-responsive' alt='" + data[i].introduce + "' />" +
                        "</div>" +
                        "<div class='discovered-bottom'>" +
                        "<span class='title'>" + data[i].exhibition_name + "</span>" +
                        "<span class='info'>" + data[i].introduce + "</span>" +
                        "<button id='edit_exhibition' class='btn btn-warning'>EDIT</button><br>" +
                        "<button id='del_exhibition' class='btn btn-danger' style='margin-top:5px' data-toggle='modal' data-target='#deleteModal'>DELEDTE</button>" +
                        "</div>" +
                        "</div>");

                    haveExhibition = 1;
                }

                delBtnListener();
                editBtnListener();
                imgListener();
            }
        }
    })
}



function getData() {
    $.ajax({
        cache: true,
        dataType: "json",
        type: "POST",
        url: url + "/exhibition_server/exhibition/search_exhibition.php",
        data: $("#searchExhibition").serialize(),
        async: false,
        error: function (jqXhr, textStatus, errorThrown) { alert("目前無法拿到資料!" + textStatus + ': ' + errorThrown) },
        success: function (data) {
            $("#exhibition").html("");
            $("#record").html("");
            console.log(data);
            for (var i in data) {
                $("#exhibition").append(

                    "<div class='discovered-block' id ='" + data[i].exhibition_id + "'>" +
                    "<div class='discovered-middle'>" +
                    "<img src='data:image/" + data[i].type + ";base64," + data[i].mapImage + "' class='img-responsive' alt='" + data[i].introduce + "' />" +
                    "</div>" +
                    "<div class='discovered-bottom'>" +
                    "<span class='title'>" + data[i].exhibition_name + "</span>" +
                    "<span class='info'>" + data[i].introduce + "</span>" +
                    "</div>" +
                    "</div>"
                )


            }
            $("#exhibition").append(
                "<button id='notifBtn' type='button' class='btn btn-danger btn-circle btn-lg notif-position' data-toggle='modal' data-target='#notifModal'>" +
                "<i class='fa fa-bell' aria-hidden='true'></i>" +
                "</button>" +
                "<p id='notifNum' class='notif-num' style='display:none;'></p>" +
                "<button id='resendBtn' type='button' class='btn btn-success btn-circle btn-lg resend-position'>" +
                "<i class='fa fa-repeat' aria-hidden='true'></i>" +
                "</button>"
                   
                
            )
            imgListener();
            notifBtnListener();
            resendBtnListener();
        }
    })

    checkStatus();
}


function search() {
    $.ajax(
        {
            data: {
                id: id,
            },
            type: "POST",
            url: url + "/exhibition_server/beacon/search_beacon.php",
            error: function (jqXhr, textStatus, errorThrown) { alert(textStatus + ': ' + errorThrown) },
            success: function (data) {

                var temp = JSON.parse(data);
                subscribedBeaconArray[id] = [];

                for (var i in temp) {
                    subscribedBeaconArray[id].push(new subscribedBeacon(temp[i]['beacon_name'], temp[i]['major'], temp[i]['minor'], temp[i]['beacon_positionX'], temp[i]['beacon_positionY'], temp[i]['beacon_positionZ']));
                }
                
                if (cnt == 1) {
                    cal();
                    cnt = 0;
                }

                else
                    cnt++;


            }

        });  //拿註冊展場的beacon資料


    $.ajax(
        {
            data: {
                id: id,
            },
            type: "POST",
            url: url + "/exhibition_server/broadcast/search_broadcast.php",
            error: function (jqXhr, textStatus, errorThrown) { alert(textStatus + ': ' + errorThrown) },
            success: function (data) {

                var temp = JSON.parse(data);
                subscribedPushArray[id] = [];

                for (var i in temp) {
                    //pushInfo = function (title, info, img1, img2, img3, url, fb_url, twitter_url, x, y, z, r) 
                    //subscribedPushArray[id].push(new pushInfo(temp[i]['title'], temp[i]['x'], temp[i]['y'], temp[i]['z'], temp[i]['r'], temp[i]['info']));
                    subscribedPushArray[id].push(new pushInfo(temp[i]['title'], temp[i]['info'], temp[i]['vendorId'],
                        temp[i]['broadcastImage1'], temp[i]['broadcastImage2'], temp[i]['broadcastImage3'],
                        temp[i]['type1'], temp[i]['type2'], temp[i]['type3'],
                        temp[i]['url'], temp[i]['fb_url'], temp[i]['twitter_url'],
                        temp[i]['x'], temp[i]['y'], temp[i]['z']));
                    console.log(subscribedPushArray[id]);
                }

                if (cnt == 1) {
                    cal();
                    cnt = 0;
                }

                else
                    cnt++;



            }

        }); //拿註冊展場的推播資料


    subscribedExhibition[id] = true;
    subscribedExhibitionVersion[id] = ver_id;
   

}

function stopRange() {

    var beaconRegion = new cordova.plugins.locationManager.BeaconRegion("regionTest", "74278BDA-B644-4520-8F0C-720EAF059935");

    cordova.plugins.locationManager.stopRangingBeaconsInRegion(beaconRegion)
        .fail(function (e) { console.error(e); })
        .done();
}

function cal() {
    for (var j in subscribedPushArray[id]) {
        push_x = subscribedPushArray[id][j].x;
        push_y = subscribedPushArray[id][j].y;
        push_z = subscribedPushArray[id][j].z;
    
        for (var k in subscribedBeaconArray[id]) {
            beacon_x = subscribedBeaconArray[id][k].x;
            beacon_y = subscribedBeaconArray[id][k].y;
            beacon_z = subscribedBeaconArray[id][k].z;
            subscribedPushArray[id][j].disArray[k] = (Math.pow(Math.pow(beacon_x - push_x, 2) + Math.pow(beacon_y - push_y, 2) + Math.pow(beacon_z - push_z, 2), 0.5));

        }
    }

}

function checkStatus() {
    $.ajax({
        cache: true,
        type: "POST",
        url: url + "/exhibition_server/member/checkStatus.php",
        async: false,
        error: function (e) {
           // Command: toastr["error"]("Connection error");
        },
        success: function (data) {
            console.log(data);
            var loginInfo = JSON.parse(data);
           
            if (loginInfo.status == 1) {
                status = loginInfo.status;
                $("#signModal").css("display", "none");
                $("#signinBtn").css("display", "none");
                $("#logoutBtn").show();
                $("#userName").html(loginInfo.userName);
                userName = loginInfo.userName;

            }
        }
    })
}

function signUp() {
    $.ajax({
        cache: true,
        type: "POST",
        url: url + "/exhibition_server/member/register.php",
        data: $("#signupForm").serialize(),
        async: false,
        error: function (e) {
            Command: toastr["error"]("Connection error");
        },
        success: function (data) {
            if (data == 1) {
                Command: toastr["error"]("已經有存在的帳號，請重新註冊");
                $("input").val("");
            }
            else {
                Command: toastr["success"]("註冊成功");
                $("input").val("");
            }
        }
    })
}

function login() {
    $.ajax({
        cache: true,
        type: "POST",
        url: url + "/exhibition_server/member/login.php",
        data: $("#loginForm").serialize(),
        async: false,
        error: function (e) {
            Command: toastr["error"]("Connection error");
        },
        success: function (data) {
            console.log(data);
            var loginInfo = JSON.parse(data);
            if (loginInfo.status == 1) {
                status = loginInfo.status;
                userName = loginInfo.userName;
                password = $("input[name=password]").val();
                exhibitionList = loginInfo.exhibitionList;

                for (i in exhibitionList) {
                    id = exhibitionList[i];
                    ver_id = loginInfo.versionList[i];
                    search();
                }


                Command: toastr["success"]("你好" + loginInfo.userName + "，登入成功");
                $("#signModal").css("display", "none");
                $("#signinBtn").css("display", "none");
                $("#logoutBtn").show();
                $("#userName").html(userName);
                $("input").val("");
            }
            else {
                Command: toastr["error"]("不存在的帳號密碼或輸入錯誤，請重新登入");
                $("input").val("");
            }
        }
    })

    getData();
}

function getExhibitionVer() {

    $.ajax({
        cache: true,
        type: "POST",
        url: url + "/exhibition_server/exhibition/get_version.php",
        data: $("#loginForm").serialize(),
        async: false,
        error: function (e) {
            Command: toastr["error"]("Connection error");
        },
        success: function (data) {
            data = JSON.parse(data);
            for (var i = 0; i < data.length; i++) {
                if (subscribedExhibitionVersion[data[i].id] != undefined && data[i].version != subscribedExhibitionVersion[data[i].id]) {
                    Command: toastr["success"]("你訂閱的展場有推播更新");
                    subscribedExhibitionVersion[data[i].id] = data[i].version;
                    console.log(data[i].version);
                    id = data[i].id;
                    signCancel();
                    signIn();
                   

                }
        
            }
        }
    })
    
    
}

function refresh() {
    $.ajax({
        cache: true,
        type: "POST",
        url: url + "/exhibition_server/member/login.php",
        data: {
            userName: userName,
            password: password,
        },
        async: false,
        error: function (e) {
            Command: toastr["error"]("Connection error");
        },
        success: function (data) {
            console.log(data);
            var loginInfo = JSON.parse(data);
            if (loginInfo.status == 1) {
                exhibitionList = loginInfo.exhibitionList;
                console.log(exhibitionList);
                for (i in exhibitionList) {
                    id = exhibitionList[i];
                    ver_id = loginInfo.versionList[i];
                    console.log(ver_id);
                    search();
                }
            }
        }
    });
}


    function logout() {
        $.ajax({
            cache: true,
            type: "POST",
            url: url + "/exhibition_server/member/logout.php",
            async: false,
            error: function (e) {
                Command: toastr["error"]("Connection error");
            },
            success: function (data) {
                Command: toastr["success"]("登出成功");
                status = 0;
                userName = undefined;
                $("#signinBtn").show();
                $("#logoutBtn").css("display", "none");
                subscribedBeaconArray = [];
                subscribedExhibition = [];
                subscribedPushArray = [];
                subscribedExhibitionVersion = [];

            }
        })
        checkStatus();
        getData();
    }

    function onPause() {
        // TODO: 這個應用程式已暫停。請在這裡儲存應用程式狀態。
    };

    function onResume() {
        // TODO: 這個應用程式已重新啟動。請在這裡還原應用程式狀態。
    };

    function calculateDistance(txPower, rssi) {
        var n = 2.5;
        if (rssi == 0) {
            return -1.0; // if we cannot determine distance, return -1.
        }

        var ratio = rssi * 1.0 / txPower;
        if (ratio < 1.0) {
            return Math.pow(ratio, 10);
        }
        else {
            var accuracy = Math.pow(10, ((txPower - rssi) / (10 * n)));
            //double accuracy =  (0.89976)*Math.pow(ratio,7.7095) + 0.111;
            return accuracy;
        }
    }

    function startRange() {

        var beaconRegion = new cordova.plugins.locationManager.BeaconRegion("regionTest", "74278BDA-B644-4520-8F0C-720EAF059935");

        var delegate = new cordova.plugins.locationManager.Delegate();

        delegate.didRangeBeaconsInRegion = function (pluginResult) {
            for (var i in pluginResult["beacons"]) {           
                for (var j in subscribedBeaconArray) {
                    for (var k in subscribedBeaconArray[j]) {
                       
                        if (pluginResult["beacons"][i]['name'] == subscribedBeaconArray[j][k].name && pluginResult["beacons"][i]['major'] == subscribedBeaconArray[j][k].major && pluginResult["beacons"][i]['minor'] == subscribedBeaconArray[j][k].minor) {
                            subscribedBeaconArray[j][k].setDistance(calculateDistance(pluginResult["beacons"][i]['tx'], pluginResult["beacons"][i]['rssi']));
                           
                            document.getElementById(pluginResult["beacons"][i]['name']).innerHTML = "" + pluginResult["beacons"][i]['name'] + ":" + calculateDistance(pluginResult["beacons"][i]['tx'], pluginResult["beacons"][i]['rssi']);
                        }
                    }
                }
            }



            for (var i in subscribedPushArray) {
                
                for (var j in subscribedPushArray[i]) {

                    flag = true;

                    for (var k in subscribedBeaconArray[i]) {

                        
                        if (!(subscribedBeaconArray[i][k].getDistance() >= 0 )) {
                            flag = false;
                            break;
                        }
                      
                        console.log(subscribedPushArray[i][j].disArray[k]);
                  
                        if (subscribedPushArray[i][j].disArray[k]  > subscribedBeaconArray[i][k].getDistance()) {
                           
                            console.log("suc");
                            flag = false;
                           
                            Command: toastr["warning"]("exit");
                        }



                    }
                
                        
                    if (flag == true) {
                        if (subscribedPushArray[i][j].isPush == false) {
                            var imgArray = [];
                            var typeArray = [];
                            subscribedPushArray[i][j].isPush = true;
                            console.log(subscribedPushArray[i]);
                            console.log(subscribedPushArray[i][j]);
                            imgArray[0] = subscribedPushArray[i][j].img1;
                            imgArray[1] = subscribedPushArray[i][j].img2;
                            imgArray[2] = subscribedPushArray[i][j].img3;
                            typeArray[0] = subscribedPushArray[i][j].type1;
                            typeArray[1] = subscribedPushArray[i][j].type2;
                            typeArray[2] = subscribedPushArray[i][j].type3;
                            addNotif(subscribedPushArray[i][j].title, subscribedPushArray[i][j].info, subscribedPushArray[i][j].vendorId,
                                imgArray, typeArray, subscribedPushArray[i][j].url, subscribedPushArray[i][j].fb_rul, subscribedPushArray[i][j].twitter_url);
                            
                           
                        }
                        console.log("www");
                    }

                }
            }
        }

        cordova.plugins.locationManager.setDelegate(delegate);

        cordova.plugins.locationManager.startRangingBeaconsInRegion(beaconRegion)
            .fail(function (e) { console.error(e); })
            .done();

    };


    window.onload = function () {

        document.getElementById("beaconBtn").addEventListener("click", discovered, false);
        document.getElementById("discoveredBtn").addEventListener("click", discovered, false);
        document.getElementById("recordBtn").addEventListener("click", record, false);
        document.getElementById("addBtn").addEventListener("click", add, false);

        //hide navbar by clicking <a> tag
        var navMain = $(".navbar-collapse");
        navMain.on("click", "a", null, function () {
            navMain.collapse("hide");
        })

        //submit
        $("#searchBtn").click(function () {
            //alert($("input[name=exhibition_name]").val());
            getData();
        })

        $("#searchBtn").click(function () {
            //alert($("input[name=exhibition_name]").val());
            getData();
        })

        //closing the img modal by clicking nowhere
        $("#modalFull").click(function () {
            $("#modalFull").css("display", "none");
        })

        //Sign up submit
        $("#signupBtn").click(function () {
            signUp();
        })

        //Login submit
        $("#loginBtn").click(function () {
            login();
        })

        $("#logoutBtn").click(function () {
            logout();
        })

        //Remove Notif
        $("#rmNotifBtn").click(function () {
            $(this).closest('ul').remove();
        })

        $("#deleteModal").click(function () {
            $("#deleteModal").fadeOut();
        })

        //confirm to delete exhibition
        $("#yes").click(function () {
            console.log(deleteTarget);
            $.ajax({
                cache: true,
                type: "POST",
                data: { id: deleteTarget },
                url: url + "/exhibition_server/member/remove_exhibition.php",
                async: false,
                error: function (e) {
                    Command: toastr["error"]("Connection error");
                },
                success: function (data) {
                    Command: toastr["success"]("刪除成功");
                }
            })
            tempDelete.remove();
        })

        document.getElementById("signCancel").addEventListener('click', signCancel, false);

        setInterval(getExhibitionVer, 300000);


        document.getElementById("signIn").addEventListener('click', signIn , false);
        startRange();

    }

    function signCancel() {
        $.ajax(
            {
                data: {
                    id: id,
                    flag: 0,
                },
                type: "POST",
                url: url + "/exhibition_server/member/subscribe.php",
                error: function (jqXhr, textStatus, errorThrown) { alert(textStatus + ': ' + errorThrown) },
                success: function (data) {
                    console.log(data);
                    subscribedBeaconArray[id] = [];
                    subscribedPushArray[id] = [];
                }

            });

        subscribedExhibition[id] = false;
        subscribedExhibitionVersion[id] = undefined;
        getData();

    }

    function signIn() {
        $.ajax(
            {
                data: {
                    id: id,
                    flag: 1,
                },
                type: "POST",
                url: url + "/exhibition_server/member/subscribe.php",
                error: function (jqXhr, textStatus, errorThrown) { alert(textStatus + ': ' + errorThrown) },
                success: function (data) {
                    search();
                    getExhibitionVer[id] = data;
                }

            });


        getData();

    }




  