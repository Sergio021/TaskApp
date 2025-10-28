<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Aplicación de tareas</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
	<header class="container mt-5 mb-3">
		<div class="d-flex">
			<div class="p-2 flex-grow-1">
				<h1>Lista de tareas</h1>
			</div>
			<div class="p-2">
				<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">Agregar Tarea</button>
			</div>
		</div>
	</header>

	<main class="container">
		<div id="counterPending"></div>
        <table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">Tarea</th>
					<th scope="col">Descripción</th>
					<th scope="col">Status</th>
					<th scope="col">fecha</th>
					<th scope="col"></th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody id="contenido">
				<tr>
					<td>Tarea 1</td>
					<td>Descripción</td>
					<td>status</td>
					<td>Fecha</td>
					<td><button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalModificar">Completar</button></td>
					<td><button type="button" class="btn btn-outline-danger">Eliminar</button></td>
					</tr>
				</tr>
			</tbody>
		</table>
	</main>

	<!-- Modal Agregar Tarea -->
	<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addTaskModalLabel">Agregar Nueva Tarea</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="taskForm">
						<div class="mb-3">
							<label for="taskTitle" class="form-label">Título</label>
							<input type="text" class="form-control" id="taskTitle" required>
						</div>
						<div class="mb-3">
							<label for="taskDescription" class="form-label">Descripción</label>
							<textarea class="form-control" id="taskDescription" rows="3"></textarea>
						</div>
						<div class="mb-3">
							<label for="taskDueDate" class="form-label">Fecha de Vencimiento</label>
							<input type="date" class="form-control" id="taskDueDate">
						</div>
						<button type="submit" class="btn btn-primary">Agregar Tarea</button>
					</form>
				</div>
			</div>
		</div>
	</div>


	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

	<script>
		const apiUrl = '<?= base_url('api/tasks') ?>';
		const contenido = document.getElementById('contenido');
		const form = document.getElementById('taskForm');
		const counterPending = document.getElementById('counterPending');
		const modalAgregar = new bootstrap.Modal('#addTaskModal', {
			keyboard: false
		})
		

		cargarTareas();

		function cargarTareas() {
			fetch(apiUrl)
				.then(response => response.json())
				.then(data => {
					contenido.innerHTML = '';
					let taskspending = 0;
					let taskscompleted = 0;
					data.forEach(tarea => {
						if(tarea.status === 'pending') {
							taskspending++;
						} else if (tarea.status === 'completed') {
							taskscompleted++;
						}			
						const fila = `
							<tr>
								<td>${tarea.title}</td>
								<td>${tarea.description || ''}</td>
								<td>${tarea.status === 'pending' ? 'Pendiente' : 'Completada'}</td>
								<td>${tarea.due_date || ''}</td>
								<td><button class="btn btn-outline-success" onclick="modificarTarea(${tarea.id}, '${tarea.status}')">${tarea.status === 'pending' ? 'Completar' : 'Reabrir'}</button></td>
								<td><button type="button" class="btn btn-outline-danger" onclick="eliminarTarea(${tarea.id})">Eliminar</button></td>
							</tr>
						`;
						contenido.innerHTML += fila;
					});
					counter(taskspending, taskscompleted)
				});
		}
		function counter(pending, completed) {
			counterPending.innerHTML = `<span class="mb-5">Tareas Pendientes: ${pending} <br> Tareas Completadas: ${completed}</span>`;
		}

		function modificarTarea(id, status) {
			const nuevoStatus = status === 'pending' ? 'completed' : 'pending';
			fetch(`${apiUrl}/${id}`, {
				method: 'PUT',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ status: nuevoStatus })
			})
			.then(() => cargarTareas());
		}
		function eliminarTarea(id) {
			fetch(`${apiUrl}/${id}`, {
				method: 'DELETE'
			})
			.then(() => cargarTareas());
		}
		
		form.addEventListener('submit', e => {
			e.preventDefault();
			const data = {
				title: document.getElementById('taskTitle').value,
				description: document.getElementById('taskDescription').value,
				due_date: document.getElementById('taskDueDate').value
			};
			fetch(apiUrl, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(data)
			})
			.then(() => {
				form.reset();
				modalAgregar.hide();
				cargarTareas();
			});
		});
	</script>
</body>
</html>