$(document).ready(function() {
    // Global Settings
    let edit = false;
  
    // Testing Jquery
    fetchRecetas();
    fetchUsers();


    fetchBotones();
    
    $('#task-result').hide();
  
  
      // Fetching Tasks
    function fetchUsers() {
      $.ajax({
        url: './editar_usuarios/listaUsuarios.php',
        type: 'GET',
        success: function(response) {
          const tasks = JSON.parse(response);
          let template = '';
          tasks.forEach(task => {
            template += `
            <a href="#" class="task-item">
                    <tr taskId="${task.id}">
                    
                    <td>
                      ${task.name} 
                    
                    </td>
                    <td>${task.id}</td>
                    <td>${task.description}</td>
                    <td>
                      <button class="task-delete btn btn-danger">
                       Delete 
                      </button>
                    </td>
                    
                    </tr>
                    </a>
                  `
          });
          $('#tasks').html(template);
        }
      });
    }

    function fetchRecetas() {
      $.ajax({
        url: './editar_usuarios/listaRecetas.php',
        type: 'GET',
        success: function(response) {  
          const recetas = JSON.parse(response);
          let template = '';
          recetas.forEach(task => {
            template += `
            <a href="#" class="task-receta">
                    <tr taskIdReceta="${task.idReceta}">
                    <td>${task.idReceta}</td>
                    <td>
                    
                      ${task.nombreReceta} 
                   
                    </td>
                    <td>
                      <button class="task-deleteReceta btn btn-danger">
                       Delete 
                      </button>
                    </td>
                    <td>
                      <button onclick="window.location.href='index.php?accion=modificarReceta&id=${task.idReceta}'" class="btn btn-danger">
                       Modify 
                      </button>
                    </td>
                    </tr>
                    </a>
                  `
          });
          $('#recetas').html(template);
        }
      });
    }


    function fetchComentarios() {
      const id = $recipe;
      $.post('./editar_usuarios/listaComentarios.php', {id}, (response) => {
        const comentarios = JSON.parse(response);
        let template = '';
        comentarios.forEach(task => {
          template += `
                  <tr taskIdComentario="${task.idComentario}">
                  <td>
                    <a href="#" class="task-comentario">
                      ${task.nombreUsuario} 
                    </a>
                    </td>
                  <td>${task.comentario}</td>
                  <td>
                    <button class="task-deleteComentario btn btn-danger">
                     Delete 
                    </button>
                  </td>
                  </tr>
                `
        });
        $('#comentarios').html(template);
    });
  }

    

  // editar
    $('#task-form').submit(e => {
      e.preventDefault();
      const postData = {
        username: $('#username').val(),
        name: $('#name').val(),
        email: $('#email').val(),
        surname: $('#surname').val(),
        isAdmin: $('#isAdmin').val()
      };
      const url = edit === false ? './editar_usuarios/task-add.php' : './editar_usuarios/edit.php';
      $.post(url, postData, (response) => {
        $('#task-form').trigger('reset');
        fetchUsers();
      });
    });

    //importarCSV
    $('#importCSV').submit(e => {
      e.preventDefault();
      const postData = {
        username: $('#csv').val(),
      };
      const url =  './editar_usuarios/importCSV.php';
      $.post(url, postData, (response) => {
        response = getElementById('errorCSV');
        response.text = "BIEN";
      });
    });

    $(document).on('click', '.task-receta', (e) => {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const id = $(element).attr('taskIdReceta');
      $recipe = id;
      $.post('./editar_usuarios/listaComentarios.php', {id}, (response) => {
          console.log(response);
          console.log(JSON.parse(response));
          const comentarios = JSON.parse(response);
          let template = '';
          comentarios.forEach(task => {
            template += `
                    <tr taskIdComentario="${task.idComentario}">
                    <td>
                    <a href="#" class="task-coment">
                      ${task.nombreUsuario} 
                    </a>
                    </td>
                    <td>${task.comentario}</td>
                    <td>
                      <button class="task-deleteComentario btn btn-danger">
                       Delete 
                      </button>
                    </td>
                    </tr>
                  `
          });
          $('#comentarios').html(template);
      });
      e.preventDefault();
    });

    $(document).on('click', '.task-coment', (e) => {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const id = $(element).attr('taskIdComentario');
      $recipe = id;
      $.post('./editar_usuarios/getUsuario.php', {id}, (response) => {
        console.log(response);
        console.log(JSON.parse(response));
        const tasks = JSON.parse(response);
        let template = '';
        tasks.forEach(task => {
          template += `
                  <tr taskId="${task.id}">
                  <td>
                  <a href="#" class="task-item">
                    ${task.name} 
                  </a>
                  </td>
                  <td>${task.id}</td>
                  <td>${task.description}</td>
                  <td>
                    <button class="task-delete btn btn-danger">
                     Delete 
                    </button>
                  </td>
                  </tr>
                `
        });
        $('#tasks').html(template);
      });
      e.preventDefault();
    });

    $(document).on('click', '.task-coment', (e) => {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const id = $(element).attr('taskIdComentario');
      $user = id;
      $.post('./editar_usuarios/getUsuario.php', {id}, (response) => {
        const tasks = JSON.parse(response);
        let template = '';
        tasks.forEach(task => {
          template += `
                  <tr taskId="${task.id}">
                  <td>
                  <a href="#" class="task-item">
                    ${task.name} 
                  </a>
                  </td>
                  <td>${task.id}</td>
                  <td>${task.description}</td>
                  <td>
                    <button class="task-delete btn btn-danger">
                     Delete 
                    </button>
                  </td>
                  </tr>
                `
        });
        $('#tasks').html(template);
      });
      e.preventDefault();
    });
  
  // Get a Single Task by Id 
    $(document).on('click', '.task-item', (e) => {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const id = $(element).attr('taskId');
      $.post('./editar_usuarios/single.php', {id}, (response) => {
        response = response.replace("[","");
        response = response.replace("]","");
        const task = JSON.parse(response);
        $('#username').val(task.username);
        $('#name').val(task.name);
        $('#email').val(task.email);
        $('#surname').val(task.surname);
        $('#isAdmin').val(task.isAdmin);
        edit = true;
      });
      e.preventDefault();
    });
  
  
  
    
     // Delete a Single Task
    $(document).on('click', '.task-delete', (e) => {
      if(confirm('Are you sure you want to delete it?')) {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('taskId');
        $.post('./editar_usuarios/delete.php', {id}, (response) => {
          fetchUsers();
        });
      }
    });

    $(document).on('click', '.task-deleteReceta', (e) => {
      if(confirm('Are you sure you want to delete it?')) {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('taskIdReceta');
        $.post('./editar_usuarios/deleteReceta.php', {id}, (response) => {
          fetchRecetas();
        });
      }
    });

    $(document).on('click', '.task-deleteComentario', (e) => {
      if(confirm('Are you sure you want to delete it?')) {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('taskIdComentario');
        $.post('./editar_usuarios/deleteComentario.php', {id}, (response) => {
          fetchComentarios();
        });
      }
    });
  
  });