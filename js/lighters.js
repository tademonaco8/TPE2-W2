function getTasks() {
    fetch('api/tareas/')
    .then(response => response.json())
    .then(tasks => {
        let content = document.querySelector(".lista-tareas");
        content.innerHTML = "";
        for(let task of tasks) {
            content.innerHTML += createTaskHTML(task);
        }
    })
    .catch(error => console.log(error));
}
function createTaskHTML(task) {
    let element = `${task.titulo}: ${task.descripcion}`;
    
    if (task.finalizada == 1)
        element = `<strike>${element}</strike>`;
    else {
        element += `<a href="tarea/${task.id}">Ver</a> `;
        element += `<a href="finalizar/${task.id}">Finalizar</a> `;
        element += `<a href="borrar/${task.id}">Eliminar</a>`;
    }
        
    element = `<li>${element}</li>`;
    return element;  
}

document.querySelector("#form-tarea").addEventListener('submit', addTask);
function addTask(e) {
    e.preventDefault();
    
    let data = {
        titulo:  document.querySelector("input[name=titulo]").value,
        descripcion:  document.querySelector("input[name=descripcion]").value,
        prioridad:  document.querySelector("input[name=prioridad]").value
    }

    fetch('api/tareas', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},       
        body: JSON.stringify(data) 
     })
     .then(response => {
         getTasks();
     })
     .catch(error => console.log(error));
}

