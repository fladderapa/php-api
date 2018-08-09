$(document).ready(function() {
  let drawer = new mdc.drawer.MDCTemporaryDrawer(document.querySelector('.mdc-drawer--temporary'));
  document.querySelector('.menu').addEventListener('click', () => drawer.open = true);
  var deletingObject;
  // Global variabes
  var col = [];
  var routes = ["api/entries",
  "api/getLast20Entries",
  "api/users",
  "api/comments"
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
        //debugger;
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
    if (rout == "api/entries")
      text = "All Entries";
    else if (rout == "api/getLast20Entries")
      text = "Last 20 entries";
    else if (rout == "api/users")
        text = "All users";
    else if (rout == "api/comments")
        text = "All comments";
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

    var row = thead.insertRow(-1);
    var cell;

    for (i = 0; i < col.length; i++) {
      //debugger;
      var test = col[i];
      cell = row.insertCell(-1);
      cell.innerHTML = col[i];
    }

    var tBody = document.createElement("tbody");
    table.appendChild(tBody);
    //debugger;

    var wedData = entries.data;

    for (var j = 0; j < wedData.length; j++) {
      row = tBody.insertRow(-1);
      for (i = 0; i < col.length; i++) {
        cell = row.insertCell(-1);
        cell.innerHTML = wedData[j][col[i]];
      }
      cellDelete = row.insertCell(-1);
      cellDelete.innerHTML = 'X';
      deletingObject = wedData[j];
      cellDelete.onclick = function() { deleteObject(wedData[j].entryID)};

      cellDelete.onclick = deleteObject(wedData[j].entryID);
      
      // if(wedData[j].entryID){
      //   cellDelete.onclick = function() { deleteObject('entryID', wedData[j].entryId)};
      // }
      // else{
      //   cellDelete.onclick = function() { deleteObject('userID', wedData[j].userId)};
      // }
    }

    //debugger;
    myContainer.appendChild(table);

  };
  // Global
  main();

});

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
    //debugger;
    fetch('api/addUser', postOptions)
      .then(res => res.json())
      .then(console.log)
      .then(location.reload());

}

function addEntry(){
  var title = document.getElementById("title").value;
  var content = document.getElementById("comment").value;

  var time = new Date();

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

    let data = {
        'title': title,
        'content':content,
        'createdBy': 1
    }
    // The parameters we are gonna pass to the fetch function
    /*let fetchData = {
        method: 'POST',
        body: data,
        headers: new Headers()
    }*/

    //debugger;
    fetch('/api/addEntry', postOptions  )
      .then(res => res.text())
      .then(console.log)
      .then(location.reload());

  }


  function deleteObject(objectToDelete){
    console.log(objectToDelete);
  }

//main();
