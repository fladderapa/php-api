$(document).ready(function() {
  let drawer = new mdc.drawer.MDCTemporaryDrawer(document.querySelector('.mdc-drawer--temporary'));
  document.querySelector('.menu').addEventListener('click', () => drawer.open = true);
  var deletingObject;
  // Global variabes
  var col = [];
  var routes = [
    "/api/entries",
  // "/api/getLast20Entries",
  "/api/users",
  "/api/comments"
  ];


  // ,
  // "api/getLast20Entries",
  // "api/users",
  // "api/comments"

/*
  var username = document.getElementById("username");
  var password = document.getElementById("password");
  const urlAddusr = 'api/addUser';
*/
  /* A generic function which goes through the Web APAI, create a table for them and fill them!*/
  async function main() {
    routes.forEach(function(rout) {
      fetch(rout).
      then((response) => response.json()).
      then(function(entries) {
        createTable(entries, rout);
      });

    });
  }


  function createTable(entries, rout) {
    var i;
    col = [];
    for (i = 0; i < entries.data.length; i++) {
      let data = entries.data[i];
      for (var key in data) {
        if (data.hasOwnProperty(key)) {
          if (col.indexOf(key) === -1) {
            col.push(key);
          }
        }
      }
    }
    // col.push('action');

    // H1
    var h1 = document.createElement("h1");
    var text;
    if (rout == "/api/entries"){
      text = "Last 20 Entries";
      h1.setAttribute("class", "entriesHeader" );}
    else if (rout == "/api/getLast20Entries"){
      text = "Last 20 entries";
      h1.setAttribute("class", "lastEntriesHeader" );}
    else if (rout == "/api/users"){
        text = "All users";
        h1.setAttribute("class", "usersHeader" );}
    else if (rout == "/api/comments"){
      text = "Comments";
      h1.setAttribute("class", "commentsHeader" );}
    else {
      text = "Unknown";
    }

    var t = document.createTextNode(text);
    h1.appendChild(t);

    var myContainer = document.getElementById("myContainer");
    myContainer.appendChild(h1);


    // Create table
    var table = document.createElement("table");
    table.setAttribute("class", "tablesorter");
    table.classList.add('table');
    table.classList.add('table-hover');
    table.classList.add('table-responsive');
    table.setAttribute("id", "myTable");
    
    var thead = table.createTHead();
    thead.setAttribute("class", "thead-light");
    thead.setAttribute("class", "mdc-typography--subtitle1");
    thead.setAttribute("class", "white");

    var row = thead.insertRow(0);
    var cell;
    for (i = 0; i < col.length; i++) {
      cell = row.insertCell(-1);
      cell.innerHTML = col[i];
    }

    var tBody = document.createElement("tbody");
    //Add class to tables
    if (rout == "/api/entries"){
      table.classList.add('entriesTable');
      table.appendChild(tBody);
    }
    else if(rout == "/api/getLast20Entries"){
      table.classList.add('lastEntriesTable');
      table.appendChild(tBody);
    }
    else if(rout == "/api/users"){
      table.classList.add('usersTable');
      table.appendChild(tBody);
    }
    else{
      table.classList.add('commentsTable');
      table.appendChild(tBody);
    }
    
    var wedData = entries.data;
   
    for (var j = 0; j < wedData.length; j++) {
      row = tBody.insertRow(-1);
      for (i = 0; i < col.length; i++) {
        cell = row.insertCell(-1);
        cell.innerHTML = wedData[j][col[i]];
        cell.setAttribute("class", "mdc-typography--body1" );
        
        if(wedData[j].title == wedData[j][col[i]]){
          cell.setAttribute("class", "entryTitle" );
        }
      }
      //Creating cells
        if(wedData[j].entryID && !wedData[j].commentID){

          cellCreateComment = row.insertCell(-1);
          cellCreateComment.innerHTML = 
          "<a class=mdc-button href='/add-comment/"+wedData[j].entryID+"'>Create comment</a>"


          cellCreateComment = row.insertCell(-1);
          cellCreateComment.innerHTML = 
          "<a class=mdc-button href='/update-entry/"+wedData[j].entryID+"'>Update entry</a>"

          cellDelete = row.insertCell(-1);
          cellDelete.innerHTML = '<i class="material-icons">delete</i>';
          cellDelete.setAttribute("IdToDelete", wedData[j].entryID );
          cellDelete.setAttribute("class", "remove" );
          cellDelete.onclick = function() { deleteEntry(this.getAttribute("idtodelete"));};
        }
        else if(wedData[j].commentID){
         
          cellDelete = row.insertCell(-1);
          cellDelete.innerHTML = '<i class="material-icons">delete</i>';
          cellDelete.setAttribute("IdToDelete", wedData[j].commentID );
          cellDelete.setAttribute("class", "remove" );
          cellDelete.onclick = function() { deleteComment(this.getAttribute("idtodelete"));};
        }

    }

    myContainer.appendChild(table);

  };
  main();

});
//Adding a user
function addUser() {
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;

  // x-www-form-urlencoded
    const formData = new FormData();
    const todoInput = document.getElementById('todoInput');
    formData.append('username', username);
    formData.append('password', password);

    const postOptions = {
      method: 'POST',
      body: formData,
      // MUCH IMPORTANCE!
      credentials: 'include'
    }
    fetch('api/addUser', postOptions)
      .then(res => res.json())
      .then(window.location = "/");

}
//Adding a entry
function addEntry(){
  var title = document.getElementById("title").value;
  var content = document.getElementById("comment").value;

  // x-www-form-urlencoded
    const formData = new FormData();
    formData.append('title', title);
    formData.append('content', content);
    //formData.append('createdAt', time);
    //formData.append('createdBy', 1);

    const postOptions = {
      method: 'POST',
      body: formData,
      // MUCH IMPORTANCE!
      credentials: 'include'
    }

    fetch(' api/addEntry', postOptions  )
      .then(res => res.text())
      .then(window.location = "/");

  }
//Deleting entry
  function deleteEntry(entryToDelete){
    const formData = new FormData();
    formData.append('entryId', entryToDelete );
    
    const url = 'api/entries/' + entryToDelete;

    const postOptions = {
      method: 'DELETE',
      body: formData,
      // MUCH IMPORTANCE!
      credentials: 'include'
    }

    fetch(url, postOptions  )
    .then(res => res.text())
    .then(location.reload());
  }
//Search title
  function search(){
    var searchValue = document.getElementById('searchValue').value;
    var elements = document.getElementsByClassName('entryTitle');

    //Row to show
    var tr = collectionContains(elements, searchValue);
    
    hideElements();
    createSearchTable(tr);

  }

  //Get row that includes the entry-title from search
  function collectionContains(collection, searchText) {
    for (var i = 0; i < collection.length; i++) {
        if(collection[i].innerText.includes(searchText)) {
            return collection[i].parentElement;
        }
    }
    return false;
}

//Create new table with result
function createSearchTable(tr){
  var myContainer = document.getElementById("myContainer");

  var table = document.createElement("table");
  table.setAttribute("class", "tablesorter");
  table.classList.add('table');
  table.classList.add('table-hover');
  table.classList.add('table-responsive');

  table.setAttribute("id", "myTable");
  var thead = table.createTHead();
  thead.setAttribute("class", "thead-light");
  thead.setAttribute("class", "mdc-typography--subtitle1");
  thead.setAttribute("class", "white");

  var row = thead.insertRow(0);
  var cell1 = row.insertCell(0);
  cell1.innerHTML = "entryID";

  var cell2 = row.insertCell(1);
  cell2.innerHTML = "title";

  var cell3 = row.insertCell(2);
  cell3.innerHTML = "content";

  var cell4 = row.insertCell(3);
  cell4.innerHTML = "username";

  var cell5 = row.insertCell(4);
  cell5.innerHTML = "createdAt";

  var tBody = document.createElement("tbody");

  row2 = tBody.insertRow(-1);
  
  var cell6 = row2.insertCell(0);
  cell6.innerHTML = tr.childNodes[0].innerHTML;

  var cell7 = row2.insertCell(1);
  cell7.innerHTML = tr.childNodes[1].innerHTML;

  var cell8 = row2.insertCell(2);
  cell8.innerHTML = tr.childNodes[2].innerHTML;

  var cell9 = row2.insertCell(3);
  cell9.innerHTML = tr.childNodes[3].innerHTML;

  var cell10 = row2.insertCell(4);
  cell10.innerHTML = tr.childNodes[4].innerHTML;

  var h1 = document.createElement("h1");
  h1.setAttribute("class", "entriesHeader" );
  
  var text = "Result";
  var t = document.createTextNode(text);
  
  h1.appendChild(t);
  myContainer.appendChild(h1);
  
  table.appendChild(tBody);

  myContainer.appendChild(table);

}
//Hiding other tables
function hideElements(){
  var entriesTable = document.getElementsByClassName('entriesTable');
  var entriesHeader = document.getElementsByClassName('entriesHeader');


  var userTable = document.getElementsByClassName('usersTable');
  var usersHeader = document.getElementsByClassName('usersHeader');


  var commentsTable = document.getElementsByClassName('commentsTable');
  var commentsHeader = document.getElementsByClassName('commentsHeader');

  entriesTable[0].setAttribute("class", "hide" );
  userTable[0].setAttribute("class", "hide" );
  commentsTable[0].setAttribute("class", "hide" );

  entriesHeader[0].setAttribute("class", "hide" );
  usersHeader[0].setAttribute("class", "hide" );
  commentsHeader[0].setAttribute("class", "hide" );

}

//Deleting comment
  function deleteComment(commentToDelete){
    const formData = new FormData();
    formData.append('entryId', commentToDelete );
    
    const url = 'api/comments/' + commentToDelete;

    const postOptions = {
      method: 'DELETE',
      body: formData,
      // MUCH IMPORTANCE!
      credentials: 'include'
    }

    fetch(url, postOptions  )
    .then(res => res.text())
    .then(location.reload());
  }


