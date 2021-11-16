	const app = new Vue({
		el: '#app',
		data: {
			createProjectName : '',
			currentProjectId : null,
			projectsListJSON : [],
			createSprintName : '',
			currentSprintId : null,
			sprintsListJSON : [],
			currentTaskId : null,
			
			statusesListJSON : [],
			
			createTaskTitle : '',
			createTaskRole : '',
			createTaskRequest : '',
			createTaskPurpose : '',
			tasksListJSON : [],
			
			newNoteForTask : '',
			
			newStatusForProject : '',
			
			taskToShow : null
		},
		created() {
			this.LoadProjects();
		},
		methods: {
			LoadProjects: function()
			{
				fetch('./controllers/getProjectsController.php', {
				  method: 'POST'
				}).then(res => res.json())
				.then(response => 
				{
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.projectsListJSON = response.projects;
						if(response.numprojects > 0)
						{
							if(this.currentProjectId == null)
							{
								this.currentProjectId = response.projects[0].id;
							}
							else
							{
								var i = 0;
								while(i < response.projects.length && response.projects[i].id != this.currentProjectId) {i++;}
								if(i >= response.projects.length)
								{
									this.currentProjectId = response.projects[0].id;
								}
							}
							this.LoadSprints();
						}
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			CleanModals: function()
			{
				this.createTaskTitle = '';
				this.createTaskRole = '';
				this.createTaskRequest = '';
				this.createTaskPurpose = '';
				this.createProjectName = '';
				this.createSprintName = '';
				this.newNoteForTask = '';
				this.newStatusForProject = '';
			},
			CreteProject: function()
			{
				var data = new FormData();
				data.append('n', this.createProjectName);
				
				fetch('./controllers/createProjectController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{ 
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						location.reload();
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { } );
			},
			LoadSprints: function()
			{				
				var data = new FormData();
				data.append('i', this.currentProjectId);
				
				fetch('./controllers/getSprintsOfProjectController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.sprintsListJSON = response.sprints;
						if(response.numsprints===0)
						{
							this.currentSprintId = null;
						}
						else
						{
							var currentStrintExists = false;
							for(var i = 0; !currentStrintExists && i < response.numsprints;i++)
							{
								if(response.sprints[i].id == this.currentSprintId)
								{
									currentStrintExists = true;
								}
							}
							
							if(!currentStrintExists)
							{
								this.currentSprintId = response.sprints[response.numsprints - 1].id;
							}
							this.LoadStatuses();
							this.LoadTasks();
						}
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			CreateSprint: function()
			{
				var data = new FormData();
				data.append('i', this.currentProjectId);
				data.append('n', this.createSprintName);
				
				fetch('./controllers/createSprintController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{ 
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.currentSprintId = null;
						this.LoadSprints();
						this.CleanModals();
						this.$refs.modalCreateSprint.click();						
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { } );
			},
			LoadTasks: function()
			{
				var data = new FormData();
				data.append('ip', this.currentProjectId);
				data.append('is', this.currentSprintId);
				
				fetch('./controllers/getTasksOfSprintsProjectController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.CleanModals();
						this.tasksListJSON = response.tasks;
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			GetTaskInfo: function(task_to_get)
			{
				this.currentTaskId = task_to_get;
				var data = new FormData();
				data.append('ip', this.currentProjectId);
				data.append('is', this.currentSprintId);
				data.append('it', task_to_get);
				
				fetch('./controllers/getTaskOfSprintsProjectController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.taskToShow = response.task;
						this.LoadNotes();
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			LoadNotes: function()
			{
				var data = new FormData();
				data.append('ip', this.currentProjectId);
				data.append('is', this.currentSprintId);
				data.append('it', this.currentTaskId);
				
				fetch('./controllers/getNotesOfTaskController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{
					JSON.stringify(response);
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.taskToShow.notes = response.notes;
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			LoadStatuses: function()
			{
				var data = new FormData();
				data.append('i', this.currentProjectId);
				
				fetch('./controllers/getStatusesOfProjectController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.statusesListJSON = response.statuses;
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			CreateTask: function()
			{
				var data = new FormData();
				data.append('ip', this.currentProjectId);
				data.append('is', this.currentSprintId);
				data.append('t', this.createTaskTitle);
				data.append('c', this.createTaskRole);
				data.append('q', this.createTaskRequest);
				data.append('p', this.createTaskPurpose);
				
				fetch('./controllers/createTaskController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{ 
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.CleanModals();
						this.LoadTasks();
						this.$refs.modalCreateTask.click();
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			CreateNote: function()
			{
				var data = new FormData();
				data.append('ip', this.currentProjectId);
				data.append('is', this.currentSprintId);
				data.append('it', this.currentTaskId);
				data.append('n', this.newNoteForTask);
				
				fetch('./controllers/createNoteForTaskController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{ 
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.newNoteForTask = '';
						this.LoadNotes();
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			myallowDrop:function(event) {
				event.preventDefault();
			},
			mydrop:function(event) {
				if(!event.target.id.startsWith("status"))
					return;

				var data = event.dataTransfer.getData("Text");
				event.target.appendChild(document.getElementById(data));
				event.preventDefault();

				//alert("El elemento " + data + " está ahora en el cuadro " + event.target.id);
				this.ChangeStatusToTask(event.target.id, data);
			},
			mydrag:function(event) {
				if(!event.target.id.startsWith("task"))
					return;

				event.dataTransfer.setData("Text", event.target.id);
			},
			ChangeStatusToTask: function(status_to_change, task_to_be_changed)
			{
				var data = new FormData();
				data.append('ip', this.currentProjectId);
				data.append('is', this.currentSprintId);
				data.append('it', task_to_be_changed);
				data.append('ie', status_to_change);
				
				fetch('./controllers/updateStatusTasksController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			DeleteTask: function(taskid)
			{
				if(!confirm("¿Estás seguro de borrar la historia de usuario? Se perderá toda la información."))
					return;
				
				var data = new FormData();
				data.append('ip', this.currentProjectId);
				data.append('is', this.currentSprintId);
				data.append('it', taskid);
				
				fetch('./controllers/deleteTaskController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.LoadTasks();
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			DeleteSprint: function()
			{
				if(!confirm("¿Estás seguro de borrar sprint? Se perderán todas las historias de usuario."))
					return;				

				var data = new FormData();
				data.append('ip', this.currentProjectId);
				data.append('is', this.currentSprintId);
				
				fetch('./controllers/deleteSprintController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.currentSprintId = null;
						this.LoadSprints();						
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			DeleteProject: function(taskid)
			{
				if(!confirm("¿Estás seguro de borrar proyecto? Se perderán todos los sprints y todas las historias de usuario."))
					return;

				var data = new FormData();
				data.append('ip', this.currentProjectId);
				
				fetch('./controllers/deleteProjectController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.currentProjectId = null;
						this.currentSprintId = null;
						this.LoadProjects();
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			CreateStatus: function()
			{
				var data = new FormData();
				data.append('ip', this.currentProjectId);
				data.append('st', this.newStatusForProject);
				
				fetch('./controllers/createStatusController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.LoadProjects();
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			DeleteStatus: function(statuspublicid)
			{
				if(!confirm("¿Estás seguro de borrar este estado? Se perderán todas las historias de usuario."))
					return;

				var data = new FormData();
				data.append('ip', this.currentProjectId);
				data.append('st', statuspublicid);
				
				fetch('./controllers/deleteStatusController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.LoadProjects();
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			},
			OnStatusTypeChange: function(event, statuspublicid)
			{
				var data = new FormData();
				data.append('ip', this.currentProjectId);
				data.append('st', statuspublicid);
				data.append('ty', event.target.value);
				
				fetch('./controllers/changeStatusTypeController.php', {
				  method: 'POST', // or 'PUT'
				  body: data
				}).then(res => res.json())
				.then(response => 
				{
					if(response===null)
					{
						alert('Error de conexión');
					}
					else if(response.code==='200')
					{
						this.LoadProjects();
					}
					else
					{
						alert(response.message);
					}
				} )
				.catch(error => { alert(error); } );
			}
		}
	});