
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
		  <textarea id="large-input" placeholder="Quiero (petición)" v-model.text="createTaskRequest" style="min-width:340px"></textarea>
		</div>
		<div class="form-group">
		  <label for="create-task-purpose">Large Input</label>
		  <textarea id="large-input" placeholder="Para (justificación)" v-model.text="createTaskPurpose" style="min-width:340px"></textarea>
		</div>
		
		<div class="row flex-center">
			<button class="btn-success-outline" v-on:click="CreateTask()">Create</button>
		</div>

	  </div>
	</div>
	
	<input class="modal-state" id="modal-info-task" type="checkbox" ref="modalInfoTask">
	<div class="modal">
	  <label class="modal-bg" for="modal-info-task"></label>
	  <div class="modal-body" style="max-width:700px;min-width:430px;">
		<div v-if="taskToShow == null">
			<h4>Loading...</h4>
		</div>
		<div v-if="taskToShow !== null">
			<label class="btn-close" for="modal-info-task">X</label>
				<article class="article" style="margin-top: 30px;">
				  <div class="alert alert-primary" style="margin-bottom: 10px;">{{ taskToShow == null ? '' : taskToShow.title }}</div>
				  <div class="modal-long">
					  <h4 style="margin-bottom: 0px;">Como: {{ taskToShow == null ? '' : taskToShow.role }}</h4>
					  <div class="collapsible">
						<input id="collapsible1" type="checkbox" name="collapsible" checked="true">
						<label for="collapsible1" style="padding-left: 0px;padding-top: 10px;padding-bottom: 5px;">Quiero</label>
						<div class="collapsible-body" style="padding-top: 5px;padding-bottom: 5px;">
						  <span>{{ taskToShow == null ? '' : taskToShow.request }}</span>
						</div>
					  </div>
					  <div class="collapsible">
						<input id="collapsible2" type="checkbox" name="collapsible" checked="true">
						<label for="collapsible2" style="padding-left: 0px;padding-top: 10px;padding-bottom: 5px;">Para</label>
						<div class="collapsible-body" style="padding-top: 5px;padding-bottom: 5px;">
						  <span>{{ taskToShow == null ? '' : taskToShow.purpose }}</span>
						</div>
					  </div>
					  <div class="collapsible" style="padding:5px">
						<input id="collapsible3" type="checkbox" name="collapsible" checked="true">
						<label for="collapsible3" style="padding-left: 0px;padding-top: 10px;padding-bottom: 5px;">Notas</label>
						<div class="collapsible-body" style="padding-top: 5px;padding-bottom: 5px;">
							<div class="row">
							  <div class="col-9 col" style="padding:5px">
								<textarea class="inline" id="txtnewNoteForTask" placeholder="New note" v-model.text="newNoteForTask" style="min-width:100%;"></textarea>
							  </div>
							  <div class="col-3 col" style="padding:5px">
								<button class="inline paper-btn margin btn-success btn-small inline" v-on:click="CreateNote()">+</button>
							  </div>
							</div>

							<ul v-if="taskToShow.notes !== null">
							  <li v-for="note in taskToShow.notes"><span>{{ note == null ? '' : note.note }}</span></li>
							</ul>
						</div>
					  </div>
					  
				  </div>
				</article>
			
		</div>
	  </div>
	</div>
	
	<input class="modal-state" id="modal-conf-project" type="checkbox">
	<div class="modal">
	  <label class="modal-bg" for="modal-conf-project"></label>
	  <div class="modal-body" style="max-width:700px;min-width:430px;">
		<label class="btn-close" for="modal-conf-project">X</label>
		<h4 class="modal-title">Project's Configuration</h4>
		<br/>
		
		<table class="container">
			<tr class="fila" id="editStatuses" v-for="status in statusesListJSON">
				<td>
					{{ status.name }}
				</td>
				<td>
					<select v-model="status.type" v-on:change="OnStatusTypeChange($event, status.publicid)">
					  <option value="alert-primary">Initial</option>
					  <option value="alert-secondary">Intermediate</option>
					  <option value="alert-success">Final</option>
					</select>
					
				</td>
				<td>
					<button class="btn-small btn-danger-outline" v-on:click="DeleteStatus(status.publicid)">x</button>
				</td>
			</tr>

			<tr class="fila">
				<td colspan="2">
					<input type="text" class="inline" id="txtnewStatusForProject" placeholder="New status" v-model.text="newStatusForProject" style="min-width:100%;" />
				</td>
				<td>
					<button class="inline paper-btn margin btn-success btn-small inline" v-on:click="CreateStatus()">+</button>
				</td>
			</tr>

		</table>

	  </div>
	</div>
	
