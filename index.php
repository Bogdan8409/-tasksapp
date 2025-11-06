<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agenda - Lista programări</title>
  
  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
  <!-- Custom CSS -->
  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 20px;
      padding-bottom: 40px;
    }
    
    .navbar-custom {
      background-color: #007bff;
      border-radius: 5px;
      margin-bottom: 30px;
    }
    
    .navbar-custom a {
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      display: inline-block;
      border-radius: 3px;
      transition: background-color 0.3s;
    }
    
    .navbar-custom a:hover {
      background-color: #0056b3;
    }
    
    .page-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 30px;
      border-radius: 10px;
      margin-bottom: 30px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .form-card {
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }
    
    .table-card {
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .badge-done {
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border-radius: 12px;
      font-size: 12px;
    }
    
    .badge-open {
      background-color: #ffc107;
      color: #333;
      padding: 5px 10px;
      border-radius: 12px;
      font-size: 12px;
    }
    
    .action-btn {
      padding: 5px 12px;
      margin: 2px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 13px;
      transition: all 0.3s;
    }
    
    .action-toggle {
      background-color: #17a2b8;
      color: white;
    }
    
    .action-toggle:hover {
      background-color: #138496;
    }
    
    .action-edit {
      background-color: #ffc107;
      color: #333;
    }
    
    .action-edit:hover {
      background-color: #e0a800;
    }
    
    .action-delete {
      background-color: #dc3545;
      color: white;
    }
    
    .action-delete:hover {
      background-color: #c82333;
    }
    
    .table-responsive {
      overflow-x: auto;
    }
    
    .task-table {
      width: 100%;
      margin-top: 20px;
    }
    
    .task-table thead {
      background-color: #007bff;
      color: white;
    }
    
    .task-table th {
      padding: 12px;
      text-align: left;
    }
    
    .task-table td {
      padding: 12px;
      border-bottom: 1px solid #dee2e6;
    }
    
    .task-table tbody tr:hover {
      background-color: #f8f9fa;
    }
    
    .editing-mode {
      border: 2px solid #ffc107;
      background-color: #fff9e6;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Navigation -->
    <nav class="navbar-custom">
      <a href="index.php">Acasă</a>
      <a href="tasks_schedule.php">Lista programări</a>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
      <h1 class="mb-0">📅 Agenda Mea</h1>
      <p class="mb-0 mt-2">Gestionează-ți programările eficient</p>
    </div>

    <!-- Form Card -->
    <div class="form-card" id="formCard">
      <h3 class="mb-4">
        <span id="formTitle">Adaugă programare nouă</span>
      </h3>
      
      <form id="agendaForm" action="submit.php" method="post">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="title">Titlu <span class="text-danger">*</span></label>
            <input 
              id="title" 
              name="title" 
              type="text" 
              class="form-control" 
              placeholder="Ex: Întâlnire client"
              maxlength="50"
              required
            >
          </div>
          
          <div class="col-md-6 mb-3">
            <label for="dates">Data <span class="text-danger">*</span></label>
            <input 
              id="dates" 
              name="dates" 
              type="date" 
              class="form-control" 
              required
            >
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="starttime">Ora început <span class="text-danger">*</span></label>
            <input 
              id="starttime" 
              name="starttime" 
              type="time" 
              class="form-control" 
              required
            >
          </div>
          
          <div class="col-md-6 mb-3">
            <label for="endtime">Ora sfârșit <span class="text-danger">*</span></label>
            <input 
              id="endtime" 
              name="endtime" 
              type="time" 
              class="form-control" 
              required
            >
          </div>
        </div>

        <div class="row">
          <div class="col-12 mb-3">
            <label for="notes">Notițe</label>
            <textarea 
              id="notes" 
              name="notes" 
              class="form-control" 
              rows="3"
              placeholder="Adaugă detalii suplimentare..."
            ></textarea>
          </div>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <span id="submitBtnText">Trimite</span>
          </button>
          <button type="button" id="resetForm" class="btn btn-secondary">
            Resetează
          </button>
          <button type="button" id="cancelEdit" class="btn btn-warning" style="display:none;">
            Anulează editarea
          </button>
        </div>
      </form>
    </div>

    <!-- Table Card -->
    <div class="table-card">
      <h3 class="mb-4">Lista programărilor</h3>
      
      <div class="table-responsive">
        <table class="task-table table table-hover">
          <thead>
            <tr>
              <th style="width: 50px;">#</th>
              <th>Titlu</th>
              <th style="width: 120px;">Data</th>
              <th style="width: 150px;">Interval</th>
              <th>Notițe</th>
              <th style="width: 100px;">Status</th>
              <th style="width: 250px;">Acțiuni</th>
            </tr>
          </thead>
          <tbody id="tasksBody">
            <?php
            // Conectare la baza de date
            $conn = new mysqli("localhost", "root", "", "2webtasks");
            
            // Verificare conexiune
            if ($conn->connect_error) {
                die("Conexiune eșuată: " . $conn->connect_error);
            }
            
            // Extragere sarcini din baza de date
            $sql = "SELECT * FROM tasks ORDER BY dates, starttime";
            $result = $conn->query($sql);
            
            $tasks = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $tasks[] = $row;
                }
            }
            $conn->close();
            ?>
          </tbody>
        </table>
      </div>
      
      <div id="emptyState" style="display:none; text-align:center; padding:40px;">
        <p class="text-muted">Nu există programări. Adaugă prima ta programare!</p>
      </div>
    </div>
  </div>

  <!-- Bootstrap 4 JS dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Custom JavaScript -->
  <script>
    // Convertire array PHP în JavaScript
    let tasks = <?php echo json_encode($tasks); ?>;

    // Variabilă pentru a ține evidența sarcinii editate
    let editingId = null;

    // Elemente DOM
    const tasksBody = document.getElementById('tasksBody');
    const form = document.getElementById('agendaForm');
    const formCard = document.getElementById('formCard');
    const formTitle = document.getElementById('formTitle');
    const submitBtnText = document.getElementById('submitBtnText');
    const cancelEditBtn = document.getElementById('cancelEdit');
    const emptyState = document.getElementById('emptyState');

    /**
     * Funcție pentru afișarea sarcinilor în tabel
     */
    function renderTasks() {
      tasksBody.innerHTML = '';
      
      if (tasks.length === 0) {
        emptyState.style.display = 'block';
        return;
      }
      
      emptyState.style.display = 'none';
      
      tasks.forEach((task, index) => {
        const tr = document.createElement('tr');
        
        // Statusul sarcinii
        const statusClass = task.status === 'done' ? 'badge-done' : 'badge-open';
        const statusText = task.status === 'done' ? 'Finalizat' : 'Deschis';
        
        // Butonul de toggle status
        const toggleBtnText = task.status === 'done' ? 'Marchează Deschis' : 'Marchează Finalizat';
        
        tr.innerHTML = `
          <td>${index + 1}</td>
          <td><strong>${escapeHtml(task.title)}</strong></td>
          <td>${task.dates}</td>
          <td>${task.starttime} - ${task.endtime}</td>
          <td>${escapeHtml(task.notes || '-')}</td>
          <td><span class="${statusClass}">${statusText}</span></td>
          <td>
            <button class="action-btn action-toggle" data-id="${task.id}">
              ${toggleBtnText}
            </button>
           <a href="edit.php?id=${task.id}" class="btn btn-sm btn-info">Editează</a>
            <button class="action-btn action-delete" data-id="${task.id}">
              Șterge
            </button>
          </td>
        `;
        
        tasksBody.appendChild(tr);
      });

      // Adăugare event listeners pentru butoane
      attachEventListeners();
    }

    /**
     * Funcție pentru atașarea event listeners la butoane
     */
    function attachEventListeners() {
      // Butoane toggle status
      document.querySelectorAll('.action-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
          const id = parseInt(this.getAttribute('data-id'), 10);
          toggleStatus(id);
        });
      });

      // Butoane delete
      document.querySelectorAll('.action-delete').forEach(btn => {
        btn.addEventListener('click', function() {
          const id = parseInt(this.getAttribute('data-id'), 10);
          if (confirm('Ești sigur că vrei să ștergi această programare?')) {
            deleteTask(id);
          }
        });
      });

      // Butoane edit
      document.querySelectorAll('.action-edit').forEach(btn => {
        btn.addEventListener('click', function() {
          const id = parseInt(this.getAttribute('data-id'), 10);
          editTask(id);
        });
      });
    }

    /**
     * Funcție pentru schimbarea statusului unei sarcini
     */
    function toggleStatus(id) {
      const task = tasks.find(t => t.id === id);
      if (!task) {
        console.error('Task not found with id:', id);
        return;
      }
      
      // Schimbăm statusul
      const newStatus = (task.status === 'done') ? 'open' : 'done';
      task.status = newStatus;
      
      console.log('Status changed for task', id, 'to', newStatus);
      
      // Re-randăm tabelul
      renderTasks();
      
      // Salvare în baza de date
      fetch('update_status.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: id, status: newStatus })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          console.log('Status updated in database');
        } else {
          alert('Eroare la actualizarea statusului');
          // Revenim la statusul anterior
          task.status = (newStatus === 'done') ? 'open' : 'done';
          renderTasks();
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Eroare la comunicarea cu serverul');
        // Revenim la statusul anterior
        task.status = (newStatus === 'done') ? 'open' : 'done';
        renderTasks();
      });
    }

    /**
     * Funcție pentru ștergerea unei sarcini
     */
    function deleteTask(id) {
      // Salvăm o copie pentru rollback
      const tasksCopy = [...tasks];
      
      // Ștergem din array
      tasks = tasks.filter(t => t.id !== id);
      renderTasks();
      
      // Ștergere din baza de date
      fetch('delete.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: id })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          console.log('Task deleted from database');
        } else {
          alert('Eroare la ștergerea sarcinii');
          tasks = tasksCopy;
          renderTasks();
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Eroare la comunicarea cu serverul');
        tasks = tasksCopy;
        renderTasks();
      });
    }

    /**
     * Funcție pentru editarea unei sarcini
     */
    function editTask(id) {
      const task = tasks.find(t => t.id === id);
      if (!task) return;
      
      // Populăm formularul cu datele sarcinii
      document.getElementById('title').value = task.title;
      document.getElementById('dates').value = task.dates;
      document.getElementById('starttime').value = task.starttime;
      document.getElementById('endtime').value = task.endtime;
      document.getElementById('notes').value = task.notes || '';
      
      // Setăm modul de editare
      editingId = id;
      formCard.classList.add('editing-mode');
      formTitle.textContent = 'Editează programare';
      submitBtnText.textContent = 'Actualizează';
      cancelEditBtn.style.display = 'inline-block';
      
      // Scroll la formular
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /**
     * Funcție pentru anularea editării
     */
    function cancelEditing() {
      form.reset();
      editingId = null;
      formCard.classList.remove('editing-mode');
      formTitle.textContent = 'Adaugă programare nouă';
      submitBtnText.textContent = 'Trimite';
      cancelEditBtn.style.display = 'none';
    }

    /**
     * Funcție pentru escape HTML (prevenire XSS)
     */
    function escapeHtml(unsafe) {
      if (!unsafe) return '';
      return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }

    /**
     * Handler pentru submit formular
     */
    form.addEventListener('submit', function(e) {
      // Prevenim submit-ul default
      e.preventDefault();

      // Preluăm valorile din formular
      const title = document.getElementById('title').value.trim();
      const dates = document.getElementById('dates').value;
      const starttime = document.getElementById('starttime').value;
      const endtime = document.getElementById('endtime').value;
      const notes = document.getElementById('notes').value.trim();

      // Validare
      if (!title || !dates || !starttime || !endtime) {
        alert('Completează toate câmpurile obligatorii!');
        return;
      }

      if (endtime <= starttime) {
        alert('Ora de sfârșit trebuie să fie după ora de începere!');
        return;
      }

      if (editingId) {
        // Actualizăm sarcina existentă
        const task = tasks.find(t => t.id === editingId);
        task.title = title;
        task.dates = dates;
        task.starttime = starttime;
        task.endtime = endtime;
        task.notes = notes;
        
        // TODO: Aici trimiti request pentru actualizare în DB
        
        cancelEditing();
      } else {
        // Adăugăm sarcină nouă
        const newId = tasks.length ? (Math.max(...tasks.map(t => t.id)) + 1) : 1;
        tasks.push({
          id: newId,
          title: title,
          dates: dates,
          starttime: starttime,
          endtime: endtime,
          notes: notes,
          status: 'open'
        });
        
        // TODO: Aici trimiti request pentru salvare în DB
        
        form.reset();
      }

      renderTasks();
    });

    /**
     * Handler pentru butonul Reset
     */
    document.getElementById('resetForm').addEventListener('click', function() {
      form.reset();
      cancelEditing();
    });

    /**
     * Handler pentru butonul Anulează Editarea
     */
    cancelEditBtn.addEventListener('click', function() {
      cancelEditing();
    });

    // Randare inițială
    renderTasks();
  </script>
</body>
</html>