function createUser() {
    let url = API_ENDPOINT_URL + "?action=createUser";
    let formData = new FormData(document.getElementById("user-Form"))
    
    formData.append('action', 'createUser');
    
    xhr = new XMLHttpRequest();
    xhr.open("post", url);
    xhr.onreadystatechange = function (event) {
        if (xhr.readyState == 4) {
            if (xhr.status < 400) {
                let json = JSON.parse(xhr.responseText);
                if ("created_id" in json) {
                    window.location = PRJ_PUBLIC_DIR + 'pages/Project/users_management.php';
                }
            } else {
                console.log(xhr);
            }
        }
    };
    xhr.send(formData);
}
document.getElementById("create-user-button").onclick = createUser;