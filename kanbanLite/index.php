<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<meta name='description' content='Projects'>
	<meta name='author' content='@mdelgadop'>

	<link rel='shortcut icon' href='./favicon.ico' type='image/x-icon'>

	<meta name="twitter:description" content="Projects">
	<meta name="twitter:title" content="@mdelgadop">

	<meta property="og:title" content="@mdelgadop Projects">
	<meta property="og:description" content="Projects">

	<title>@mdelgadop Projects</title>

	<link rel='stylesheet' href='./assets/paper.css'>
	<link rel='stylesheet' href='./assets/projects.css'>
	<link rel='stylesheet' href='./assets/syntax.css'>

</head>

<body>
  <div id='top' class='site container'>
	<div class='paper' id="app">
	
	

		<div class="row flex-edges" style="margin:0px">
		  <div class="sm-6 col" style="padding:0px"><h2>@mdelgadop Projects</h2></div>
		  <div class="sm-6 col" style="padding:0px">
			<div class="form-group inline" style="margin-right: 50px;">
				<label for="slProject">Project</label>
				<div>
				<select class="inline" id="slProject" v-model="currentProjectId" v-on:change="LoadSprints()">
				  <option v-for="project in projectsListJSON" v-bind:value="project.id">
					{{ project.name }}
				  </option>
				</select>
				<label class="inline paper-btn margin btn-success btn-small" for="modal-create-project">+</label>
				<button class="btn-small btn-danger-outline" v-on:click="DeleteProject()">x</button>
				<label class="inline" for="modal-conf-project"><img src="./icons/conf_48.png" class="no-responsive no-border selectable" style="width:30px" /></label>
				</div>
			</div>
			<div class="form-group inline" v-if="currentProjectId !== null">
				<label for="slSprint">Sprints</label>
				<div>
				<select class="inline" id="slSprint" v-model="currentSprintId" v-on:change="LoadTasks()">
				  <option v-for="sprint in sprintsListJSON" v-bind:value="sprint.id">
					{{ sprint.name }}
				  </option>
				</select>
				<label class="inline paper-btn margin btn-success btn-small" for="modal-create-sprint">+</label>
				<button class="btn-small btn-danger-outline" v-on:click="DeleteSprint()">x</button>
				</div>
			</div>
		  </div>
		</div>

		<div v-if="currentSprintId !== null">
			<h3 class="title"><label class="inline paper-btn margin btn-success btn-small" for="modal-create-task">+</label>&nbsp;User stories</h3>
		</div>

		<table class="container" v-if="currentSprintId !== null">
			<tr class="fila" id="result">
				<td v-for="status in statusesListJSON">
					<div class="cola-title alert" v-bind:class="[status.type]" role="alert">
					  {{ status.name }}
					</div>
					<div v-bind:id="status.publicid" class="cola" v-on:drop="mydrop" v-on:dragover="myallowDrop">

						<div v-on:click="GetTaskInfo(task.publicid)"  for="modal-info-task" v-for="task in tasksListJSON" v-bind:id="task.publicid" class="nota border border-primary" draggable="true" v-on:dragstart="mydrag" v-if="task.status === status.id">

							
							<label class="inline btn-block selectable" for="modal-info-task"><button class="btn-small btn-danger-outline" v-on:click="DeleteTask(task.publicid)" style="margin-right:10px">x</button>{{ task.title }}</label>
							<p>{{ task.request }}</p>

						</div>

					</div>
				</td>

			</tr>

		</table>

		<?php
		include("indexModals.php");
		?>

	</div>
	<div class='site container'>
		<a href="#top" class="paper-btn margin">^</a>
	</div>

	<br/>

  </div>

  <script src="./js/vue.js"></script>

  <script src="./js/app.js"></script>

</body>

</html>