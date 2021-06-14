// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyCcWFz0je-DewN74o8QszO4YNAIpBJBtFg",
    authDomain: "hris-1ac4a.firebaseapp.com",
    databaseURL: "https://hris-1ac4a.firebaseio.com",
    projectId: "hris-1ac4a",
    storageBucket: "hris-1ac4a.appspot.com",
    messagingSenderId: "866554099563",
    appId: "1:866554099563:web:d6d34a46ccbac2a845fe2e",
    measurementId: "G-SX2Q5R0RHW"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
//firebase.analytics();
const messaging = firebase.messaging();
	messaging
.requestPermission()
.then(function () {
//MsgElem.innerHTML = "Notification permission granted." 
	console.log("Notification permission granted.");

     // get the token in the form of promise
	return messaging.getToken()
})
.then(function(token) {
    // print the token on the HTML page     
    console.log(token);
  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/save-token",
        method: "POST",
        dataType: "JSON",
        data: {
            token: token
        },
        success: function (data) {
            console.log('Token saved successfully.');
        },
        error: function (err) {
            console.log(err.responseJSON);
        },
    });
  
})
.catch(function (err) {
	console.log("Unable to get permission to notify.", err);
});

messaging.onMessage(function(payload) {
    console.log(payload);
    var notify;
    notify = new Notification(payload.notification.title,{
        body: payload.notification.body,
        icon: payload.notification.icon,
        tag: "Dummy"
    });
    console.log(payload.notification);
});

    //firebase.initializeApp(config);
var database = firebase.database().ref().child("/users/");
   
database.on('value', function(snapshot) {
    renderUI(snapshot.val());
});

// On child added to db
database.on('child_added', function(data) {
	console.log("Comming");
    if(Notification.permission!=='default'){
        var notify;
         
        notify= new Notification('CodeWife - '+data.val().username,{
            'body': data.val().message,
            'icon': 'bell.png',
            'tag': data.getKey()
        });
        notify.onclick = function(){
            alert(this.tag);
        }
    }else{
        alert('Please allow the notification first');
    }
});

self.addEventListener('notificationclick', function(event) {       
    event.notification.close();
});

