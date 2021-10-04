
	<input class="modal-state" id="modal-create-project" type="checkbox">
	<div class="modal">
	  <label class="modal-bg" for="modal-create-project"></label>
	  <div class="modal-body">
		<label class="btn-close" for="modal-create-project">X</label>
		<h4 class="modal-title">New Project</h4>
		<br/>
		<div class="form-group">
		  <label for="create-project-name"></label>
		  <input type="text" placeholder="Name" v-model.text="createProjectName" style="min-width:340px">
		</div>
		
		<div class="row flex-center">
			<button class="btn-success-outline" v-on:click="CreteProject()">Create</button>
		</div>

	  </div>
	</div>
	
	<input class="modal-state" id="modal-create-sprint" type="checkbox" ref="modalCreateSprint">
	<div class="modal">
	  <label class="modal-bg" for="modal-create-sprint"></label>
	  <div class="modal-body">
		<label class="btn-close" for="modal-create-sprint">X</label>
		<h4 class="modal-title">New Sprint</h4>
		<br/>
		<div class="form-group">
		  <label for="create-sprint-name"></label>
		  <input type="text" placeholder="Name" v-model.text="createSprintName" style="min-width:340px">
		</div>
		
		<div class="row flex-center">
			<button class="btn-success-outline" v-on:click="CreateSprint()">Create</button>
		</div>

	  </div>
	</div>
	
	<input class="modal-state" id="modal-create-task" type="checkbox" ref="modalCreateTask">
	<div class="modal">
	  <label class="modal-bg" for="modal-create-task"></label>
	  <div class="modal-body">
		<label class="btn-close" for="modal-create-task">X</label>
		<h4 class="modal-title">New task</h4>
		<br/>
		<div class="form-group">
		  <label for="create-task-Title"></label>
		  <input type="text" placeholder="Título (código)" v-model.text="createTaskTitle" style="min-width:340px">
		</div>
		<div class="form-group">
		  <label for="create-task-role"></label>
		  <input type="text" placeholder="Como (role)" v-model.text="createTaskRole" style="min-width:340px">
		</div>
		<div class="form-group">
		  <label for="create-task-request"></label>
		  <input type="text" placeholder="Quiero (petición)" v-model.text="createTaskRequest" style="min-width:340px">
		</div>
		<div class="form-group">
		  <label for="create-task-purpose"></label>
		  <input type="text" placeholder="Para (justificación)" v-model.text="createTaskPurpose" style="min-width:340px">
		</div>
		
		<div class="row flex-center">
			<button class="btn-success-outline" v-on:click="CreateTask()">Create</button>
		</div>

	  </div>
	</div>
	
	<input class="modal-state" id="modal-info-task" type="checkbox" ref="modalInfoTask">
	<div class="modal">
	  <label class="modal-bg" for="modal-info-task"></label>
	  <div class="modal-body" style="max-width:700px;">
		<div v-if="taskToShow == null">
			<h4>Loading...</h4>
		</div>
		<div v-if="taskToShow !== null">
			<label class="btn-close" for="modal-info-task">X</label>
			<br/>
			<h4 class="card-title">{{ taskToShow == null ? '' : taskToShow.title }}</h4>
			<hr/>
			<h4>Como: {{ taskToShow == null ? '' : taskToShow.role }}</h4>
			<h4>Quiero: {{ taskToShow == null ? '' : taskToShow.request }}</h4>
			<h4>Para: {{ taskToShow == null ? '' : taskToShow.purpose }}</h4>
		</div>
	  </div>
	</div>
	
	