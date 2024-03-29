
<!DOCTYPE html>

<html>
<head>
  <meta http-equiv = "Content-Type" content = "text/html; charset = utf-8" />
  <script type = "text/javascript">

         //prefixes of implementation that we want to test
         window.indexedDB = window.indexedDB || window.mozIndexedDB || 
         window.webkitIndexedDB || window.msIndexedDB;
         
         //prefixes of window.IDB objects
         window.IDBTransaction = window.IDBTransaction || 
         window.webkitIDBTransaction || window.msIDBTransaction;
         window.IDBKeyRange = window.IDBKeyRange || window.webkitIDBKeyRange || 
         window.msIDBKeyRange
         
         if (!window.indexedDB) {
          window.alert("Your browser doesn't support a stable version of IndexedDB.")
        }

        const employeeData = [];
        var db;
        var request = window.indexedDB.open("newDatabase", 1);

        request.onerror = function(event) {
          console.log("error: ");
        };

        request.onsuccess = function(event) {
          db = request.result;
          console.log("success: "+ db);
        };

        request.onupgradeneeded = function(event) {
          var db = event.target.result;
          var objectStore = db.createObjectStore("employee", {keyPath: "id"});

          for (var i in employeeData) {
           objectStore.add(employeeData[i]);
         }
       }

       function read() {
         var id = document.getElementById("id");
         var name = document.getElementById("name");
         var email = document.getElementById("email");
         var age = document.getElementById("age");
         var transaction = db.transaction(["employee"]);
         var objectStore = transaction.objectStore("employee");
         var request = objectStore.get(id.value );

         request.onerror = function(event) {
           alert("Unable to retrieve daa from database!");
         };

         request.onsuccess = function(event) {
               // Do something with the request.result!
               if(request.result) {
                alert("Name: " + request.result.name + ",Age: " + request.result.age + ", Email: " + request.result.email);
              } else {
                alert("Kenny couldn't be found in your database!");
              }
            };
          }

          function readAll() {
            var objectStore = db.transaction("employee").objectStore("employee");
            
            objectStore.openCursor().onsuccess = function(event) {
             var cursor = event.target.result;

             if (cursor) {
              alert("Name for id " + cursor.key + " is " + cursor.value.name + ", Age: " + cursor.value.age + ", Email: " + cursor.value.email);
              cursor.continue();
            } else {
              alert("No more entries!");
            }
          };
        }

        function add() {
          var id = document.getElementById("id");
          var name = document.getElementById("name");
          var email = document.getElementById("email");
          var age = document.getElementById("age");
          var request = db.transaction(["employee"], "readwrite")
          .objectStore("employee")
          .add({ id: id.value, name: name.value, age: age.value, email: email.value });

          request.onsuccess = function(event) {
           alert(name.value+" has been added to your database.");
         };

         request.onerror = function(event) {
           alert("Unable to add data\r\nKenny is aready exist in your database! ");
         }
       }

       function remove() {
         var id = document.getElementById("id");
         var name = document.getElementById("name");
         var email = document.getElementById("email");
         var age = document.getElementById("age");
         var request = db.transaction(["employee"], "readwrite")
         .objectStore("employee")
         .delete(id.value);

         request.onsuccess = function(event) {
           alert(name.value +" entry has been removed from your database.");
         };
       }
       function update() {
         var id = document.getElementById("id");
         var name = document.getElementById("name");
         var email = document.getElementById("email");
         var age = document.getElementById("age");
         var request = db.transaction(["employee"], 'readwrite')
         .objectStore("employee")
         .put({ id: id.value, name: name.value, age: age.value, email: email.value });

         request.onsuccess = function (event) {
          console.log(name.value + ' has been updated successfully');
        };

        request.onerror = function (event) {
          console.log('The data has been updated failed');
        }
      }
    </script>

  </head>
  <body>
    <label>ID :</label> <input type="text" id="id"> 
    <button onclick = "read()">Read </button>  <br>
    <label>Name :</label> <input type="text" id="name"> <br>
    <label>Age :</label> <input type="text" id="age"> <br>
    <label>E-mail : </label> <input type="text" id="email"><br>
    <button onclick = "readAll()">Read all </button>
    <button onclick = "add()">Add Data </button>
    <button onclick = "remove()">Delete Data </button>
    <button onclick="update()">Update Data</button>
  </body>
  </html>