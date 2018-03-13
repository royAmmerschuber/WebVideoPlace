function checkLogin() {
    var valid=true;
    if($("#inputName").val()==""||
        $("#inputPassword").val()==""){
        valid=false;
        $("#eName").text("please fill out the entire form")
    }
    if(valid){
        $.ajax({
            url:"/WebVideoPlace/Auth/loginCheck",
            data:{
                username: $("#inputName").val(),
                password: $("#inputPassword").val()
            },
            success: function ( result ) {
                var e=result.split("\n");
                if(e.length>0){
                    $("#eName").text(e[0]);
                    $("#ePassword").text(e[1]);
                }else{
                    window.location.replace("/WebVideoPlace")
                }
            }
        })
    }
}
function checkRegister() {
    var valid = true;
    if($("#inputName").val()==""||
        $("#inputEmail").val()==""||
        $("#inputPassword1").val()==""||
        $("#inputPassword2").val()==""){
        $("#eName").text("please enter all the values");
        valid=false;
    }
    if($("#inputPassword1").val()!=$("#inputPassword2").val()){
        $("#ePassword2").text("the Passwords do not match");
        valid=false;
    }
    if (valid) {
        $.ajax({
            url: "/WebVideoPlace/Auth/registerCheck",
            type: "POST",
            data: {
                "name": $("#inputName").val(),
                "email": $("#inputEmail").val(),
                "password1": $("#inputPassword1").val(),
                "password2": $("#inputPassword2").val()
            },
            success: function (result) {
                var e = result.split("\n");
                console.log(result);
                if (e.length > 1) {
                    $("#eName").text(e[0]);
                    $("#eEmail").text(e[1]);
                    $("#ePassword1").text(e[2]);
                    $("#ePassword2").text(e[3]);
                } else {
                    window.location.replace("/WebVideoPlace/Auth/Login");
                }
            }
        })
    }
}