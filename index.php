<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="theme-color" content="#D1D1D1">
	<meta name="description" content="Food Recipe">
	<link rel="manifest" href="manifest.json">
	<title>Meal Search</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script type="text/javascript">
		if ('serviceWorker' in navigator) { 
			window.addEventListener('load', () => { 
				navigator.serviceWorker.register('service-worker.js')
				.then((reg) => { 
					console.log('Service worker registered.', reg);
				});
			});
		} 

	</script>
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
         var request = window.indexedDB.open("recipe", 1);

         request.onerror = function(event) {
         	console.log("error: ");
         };

         request.onsuccess = function(event) {
         	db = request.result;
         	console.log("success: "+ db);
         };

         request.onupgradeneeded = function(event) {
         	var db = event.target.result;
         	/*.add({ id: id.value, title: name.value, instruct: instruct.value, recipe: recipe.value });*/
         	const objectStore = db.createObjectStore("recipe", {keyPath: "id" , autoIncrement: true});

         	for (var i in employeeData) {
         		objectStore.add(employeeData[i]);
         	}
         }
     </script>
     <style>
     @media only screen and (max-width: 1200px ){
     	.flex{
     		flex-direction: row;
     	}
     	.flex > div {
     		flex-grow: 2;
     	}
     }
     @media only screen and (max-width: 1023px){
     	.flex{
     		flex-direction: row;
     	}
     	.flex > div {
     		flex-grow: 2;
     	}
     }
     @media only screen and (max-width: 764px){
     	.flex{
     		flex-direction: column;
     	}
     	.flex > div {
     		flex-grow: 0;
     	}
     }
     ul {
     	list-style-type: none;
     }
     .box { 
     	margin: 20px auto;
     	width: 100%;
     	max-width: 150px;
     	height: 40px; 
     	text-align: center; 
     }

     .box .container-1 input{
     	width: 100%;
     }
     .flex{
     	display: flex;
     	flex-direction: row;
     	align-content: center;
     	flex-flow: wrap;
     }
     .flex > div {
     	background-color: #f1f1f1;
     	margin: 10px;
     	width: 600px;
     	padding: 10px;
     	flex-wrap: wrap;
     }
     img{
     	width: 150px;
     	height: 150px;
     }
     h2{
     	font-size: calc(30px+10vw);
     }
     button{
     	padding: 15px;
     }
 </style>

</head>
<body>
	<nav class="navbar navbar-light bg-light justify-content-between">
		<a class="navbar-brand">Recipe Search</a>
		<label style="display: none" for="Search">Search</label>
		<input aria-label="searchi" class="form-control mr-sm-2" type="search" id="searchFood" placeholder="Search..." style="width:500px ;background-color : #d1d1d1;">
		<button class="btn btn-secondary btn-lg" id="Search" onclick="search()" aria-label="search">Search !</button>
		<button class="btn btn-secondary btn-lg" id="Favorite" data-toggle='modal' data-target='#FavoriteModal' onclick="favorite()" aria-label="fav">Favorite</button>
	</nav>
	<div >
		<div id="recipe-name" class="flex">
		</div>
	</div>
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="recipe-title"></h5>
					(<h5 class="modal-title" id="recipe-id"></h5>)
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Ingredient</h4>
					<p id="ingredient"></p>
					<h4>Instructions</h4>
					<p id="instruct"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
					<button type="button" class="btn btn-primary" onclick="add()" aria-label="addfav">Favorite!</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="FavoriteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 800px;">
			<div class="modal-content" style="width: 800px;">
				<div class="modal-header">
					<h5 class="modal-title">Favorite !</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="table">
						<thead>
							<tr>
								<th scope="col"style="width: 100px" >Title</th>
								<th scope="col" style="width: 200px;">Recipe</th>
								<th scope="col">Instruction</th>
								<th scope="col">Delete</th>
							</tr>
						</thead>
						<tbody id="favlist" class="favlist">
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		function search(){

			function createNode(element){
				return document.createElement(element);
			}
			function append(parent,el){
				return parent.appendChild(el);
			}
			var url='https://www.themealdb.com/api/json/v1/1/search.php?s='+document.getElementById('searchFood').value;
			console.log(url);
			fetch(url)
			.then((resp)=>resp.json())
			.then(function(data){
				var j = "";
				for (var i in data.meals) {
					console.log(data.meals[i].strMeal);
					j += "<div value='"+data.meals[i].idMeal+"'><h3>"+data.meals[i].strMeal+"</h3><img src='"+data.meals[i].strMealThumb+"'></img>"+"<button aria-label='show' value='"+data.meals[i].idMeal+"' class='btn btn-secondary float-right' type='button' data-toggle='modal' data-target='#exampleModalCenter' id='"+data.meals[i].idMeal+"' onclick='show(this.id)'>Show Recipe</button></div>";
					/*document.getElementById("recipe-name").innerHTML="<h2>"+data.meals[i].strMeal+"</h2>";*/
				}
				document.getElementById("recipe-name").innerHTML=j;
			})
			.catch(function(error){console.log(error);});
		}

		function add() {
			var id = document.getElementById("recipe-id").innerHTML;
			var name = document.getElementById("recipe-title").innerHTML;
			var recipe = document.getElementById("ingredient").innerHTML;
			var instruct = document.getElementById("instruct").innerHTML;
			console.log(id+" \n"+name+" \n"+recipe+" \n"+instruct);
			var request = db.transaction(["recipe"], "readwrite")
			.objectStore("recipe")
			.add({title: name, instruct: instruct, recipe: recipe});

			request.onsuccess = function(event) {
				alert(name+" has been added to your database.");
			};

			request.onerror = function(event) {
				alert("Unable to add data\r\nKenny is aready exist in your database!");
			}
		}

		function show(id){
			console.log(id);
			function createNode(element){
				return document.createElement(element);
			}
			function append(parent,el){
				return parent.appendChild(el);
			}
			var url='https://www.themealdb.com/api/json/v1/1/lookup.php?i='+id;
			console.log(url);
			fetch(url)
			.then((resp)=>resp.json())
			.then(function(data){
				document.getElementById("recipe-title").innerHTML=data.meals[0].strMeal;
				document.getElementById("recipe-id").innerHTML=data.meals[0].idMeal;
				document.getElementById("instruct").innerHTML=data.meals[0].strInstructions;
				document.getElementById('ingredient').innerHTML="<p>"+data.meals[0].strMeasure1+" "+data.meals[0].strIngredient1+"</p>"+
				"<p>"+data.meals[0].strMeasure2+" "+data.meals[0].strIngredient2+"</p>"+
				"<p>"+data.meals[0].strMeasure3+" "+data.meals[0].strIngredient3+"</p>"+
				"<p>"+data.meals[0].strMeasure4+" "+data.meals[0].strIngredient4+"</p>"+
				"<p>"+data.meals[0].strMeasure5+" "+data.meals[0].strIngredient5+"</p>"+
				"<p>"+data.meals[0].strMeasure6+" "+data.meals[0].strIngredient6+"</p>"+
				"<p>"+data.meals[0].strMeasure7+" "+data.meals[0].strIngredient7+"</p>"+
				"<p>"+data.meals[0].strMeasure8+" "+data.meals[0].strIngredient8+"</p>"+
				"<p>"+data.meals[0].strMeasure9+" "+data.meals[0].strIngredient9+"</p>"+
				"<p>"+data.meals[0].strMeasure10+" "+data.meals[0].strIngredient10+"</p>"+
				"<p>"+data.meals[0].strMeasure11+" "+data.meals[0].strIngredient11+"</p>"
				"<p>"+data.meals[0].strMeasure12+" "+data.meals[0].strIngredient12+"</p>"+
				"<p>"+data.meals[0].strMeasure13+" "+data.meals[0].strIngredient13+"</p>"+
				"<p>"+data.meals[0].strMeasure14+" "+data.meals[0].strIngredient14+"</p>"+
				"<p>"+data.meals[0].strMeasure15+" "+data.meals[0].strIngredient15+"</p>"+
				"<p>"+data.meals[0].strMeasure16+" "+data.meals[0].strIngredient16+"</p>"+
				"<p>"+data.meals[0].strMeasure17+" "+data.meals[0].strIngredient17+"</p>"+
				"<p>"+data.meals[0].strMeasure18+" "+data.meals[0].strIngredient18+"</p>"+
				"<p>"+data.meals[0].strMeasure19+" "+data.meals[0].strIngredient19+"</p>"+
				"<p>"+data.meals[0].strMeasure20+" "+data.meals[0].strIngredient20+"</p>";
			})
			.catch(function(error){console.log(error);});
		}

		function favorite(){
			var Parent = document.getElementById("favlist");
			while(Parent.hasChildNodes())
			{
				Parent.removeChild(Parent.firstChild);
			}
			var objectStore = db.transaction("recipe").objectStore("recipe");

			objectStore.openCursor().onsuccess = function(event) {
				var cursor = event.target.result;

				if (cursor) {
					document.getElementById("favlist").innerHTML+=" <tr><td>"+cursor.value.title+"</td><td>"+cursor.value.recipe+"</td><td>"+cursor.value.instruct+"</td><td><button id='"+cursor.key+"' class='btn btn-danger' onclick='remove(this.id)'data-dismiss='modal'>Remove</button></td></tr>"
					cursor.continue();
				} else {
					console.log("No entry");
				}
			};
		}
		function remove(id){
			console.log(id-1);
			var request = db.transaction(["recipe"], "readwrite")
			.objectStore("recipe")
			.delete(Number(id));

			request.onsuccess = function(event) {
				alert("Item has been added to your database.");
			};
		}

	</script>
</body>
</html>