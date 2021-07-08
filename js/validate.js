function validateProfile() {
    let name = document.forms["profile"]["name"].value;
    let email = document.forms["profile"]["email"].value;
    let bio = document.forms["profile"]["bio"].value;
    let newPassword = document.forms["profile"]["newPassword"].value;
    let newPasswordRepeat = document.forms["profile"]["newPasswordRepeat"].value;

    if(newPassword !== "" || newPassword !== null || newPasswordRepeat !== "" || newPasswordRepeat !== null){
        if(newPassword != newPasswordRepeat){
            document.getElementById('newPasswordErrorText').innerHTML = 'The passwords do not match';
            return false;
        }
    }
    if (email === "" || email === null || name === "" || name === null || bio === "" || bio === null) {
        alert("Fill in all the fields");

        document.forms["profile"]["name"].focus() ;
        return false;
    }
    else {
        var mailformat = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (email.match(mailformat)) {
            return true;
        } else {
            document.getElementById('emailValidate').innerHTML = 'Insert valid email';
            document.forms["profile"]["email"].focus();
            return false;
        }
    }
}

function validatePost() {
    tinyMCE.init({
        selector: 'textarea',
        mode: "textareas",
        plugins: "fullpage"
      });
    let title = document.forms["recipe"]["title"].value;
    let naziv_kategorije = document.forms["recipe"]["categoryId"].value;
    let sadrzaj =  tinyMCE.get('tinyeditor').getContent();
    let file = document.forms["recipe"]["file"].value;

    if(title === "" || title === null || naziv_kategorije === "" || naziv_kategorije === null || sadrzaj == '' || file === "" || file === null ){
            alert("Fill in all the fields!");
            return false;
        
    }else return true;
    
}

function validateEditPost() {
    tinyMCE.init({
        selector: 'textarea',
        mode: "textareas",
        plugins: "fullpage"
      });
    let title = document.forms["recipe"]["title"].value;
    let naziv_kategorije = document.forms["recipe"]["categoryId"].value;
    let sadrzaj = tinyMCE.get('tinyeditor').getContent();

    if(title === "" || title === null || naziv_kategorije === "" || naziv_kategorije === null || sadrzaj == '' ){
            alert("Fill in all the fields!");
            return false;
        
    }else return true;
    
}

function readURL(input) {
if (input.files && input.files[0]) {
  var reader = new FileReader();
  
  reader.onload = function(e) {
    $('#imageDiv').attr('style','display = inline');
    $('#Image').attr('src', e.target.result);
  }
  
  reader.readAsDataURL(input.files[0]); // convert to base64 string
}
}
$("#imgInp").change(function() {
readURL(this);
});

