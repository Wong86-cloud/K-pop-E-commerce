const searchBar = document.querySelector(".users .search input"),
searchBtn = document.querySelector(".users .search button"),
usersList = document.querySelector(".users .users-list");

searchBtn.onclick = () => {
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
}

//Search the user
searchBar.onkeyup = () => {
    // Ajax is running two times in the same time so adding an active class when user is searching
    // only run  the setInterval function when the user is not searching
    let searchTerm = searchBar.value;
    if(searchTerm != ""){
        searchBar.classList.add("active");
    }else{
        searchBar.classList.remove("active");
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "db_connection/users_search.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                usersList.innerHTML = data;
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
}

//User List
setInterval(() => { 
    // let's start Ajax
    let xhr = new XMLHttpRequest(); // creating XML object
    xhr.open("GET", "db_connection/users.php", true); //receive data not to send 
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(!searchBar.classList.contains("active")){ //if active class is not in search bar
                    usersList.innerHTML = data;
                }        
            }
        }
    }
    xhr.send();
}, 500); //this function will run every 500 milliseconds


