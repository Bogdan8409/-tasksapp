<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="utf-8">
  <title>Agenda - Lista programări</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Agenda</h1>

    <!-- Formular scurt -->
    <form id="agendaForm" action="submit.php" method="post">
      <div class="form-row">
        <div class="field">
          <label for="title">Titlu</label>
          <input id="title" name="title" type="text" pattern=".{1,50}" required>
        </div>
        <div class="field">
          <label for="dates">Data</label>
          <input id="dates" name="dates" type="date" required>
        </div>
        <div class="field">
          <label for="starttime">Ora început</label>
          <input id="starttime" name="starttime" type="time" required>
        </div>
        <div class="field">
          <label for="endtime">Ora sfârșit</label>
          <input id="endtime" name="endtime" type="time" required>
        </div>
      </div>

      <div class="form-row">
        <div style="flex:1">
          <label for="notes">Notițe</label>
          <textarea id="notes" name="notes"></textarea>
        </div>
      </div>

      <div style="margin-top:12px;">
        <button type="submit" class="btn btn-primary">Trimite</button>
        <button type="button" id="resetForm" class="btn">Resetează</button>
      </div>
    </form>

    <!-- Tabel sarcini -->
    <div class="table-wrap">
      <table class="task-table" id="tasksTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Titlu</th>
            <th>Data</th>
            <th>Interval</th>
            <th>Notițe</th>
            <th>Status</th>
            <th>Acțiuni</th>
          </tr>
        </thead>
        <tbody id="tasksBody">
          <!-- rânduri generate din JS / backend -->
        </tbody>
      </table>
    </div>
  </div>
  <div class="nav">
    <a href="index.php">Acasă</a>
    <a href="tasks_schedule.php">Lista programări</a>
    <a href="submit.php">Submit</a>
    <a href="edit.php">Actualizare date</a>
  </div>
  <script>
    // Exemplu de date inițiale (în realitate vin din DB sau din AJAX)
    let tasks = [
      { id: 1, title: "Întâlnire client A", date: "2025-10-10", start: "10:00", end: "11:00", notes: "Discută contract", status: "open" },
      { id: 2, title: "Depunere acte", date: "2025-10-12", start: "09:00", end: "09:30", notes: "Tribunal", status: "done" }
    ];

    const tasksBody = document.getElementById('tasksBody');

    function renderTasks(){
      tasksBody.innerHTML = '';
      tasks.forEach((t, idx) => {
        const tr = document.createElement('tr');

        tr.innerHTML = `
          <td>${idx+1}</td>
          <td>${escapeHtml(t.title)}</td>
          <td>${t.date}</td>
          <td>${t.start} - ${t.end}</td>
          <td>${escapeHtml(t.notes || '')}</td>
          <td><span class="badge ${t.status === 'done' ? 'done' : 'open'}">${t.status === 'done' ? 'Done' : 'Open'}</span></td>
          <td>
            <button class="action-btn action-toggle" data-id="${t.id}">${t.status === 'done' ? 'Mark Open' : 'Mark Done'}</button>
            <button class="action-btn action-edit" data-id="${t.id}">Edit</button>
            <button class="action-btn action-delete" data-id="${t.id}">Delete</button>
          </td>
        `;
        tasksBody.appendChild(tr);
      });

      // Adaugăm event listeners pentru butoane
      document.querySelectorAll('.action-toggle').forEach(btn => {
        btn.addEventListener('click', function(){
          const id = parseInt(this.getAttribute('data-id'), 10);
          toggleStatus(id);
        });
      });

      document.querySelectorAll('.action-delete').forEach(btn => {
        btn.addEventListener('click', function(){
          const id = parseInt(this.getAttribute('data-id'), 10);
          if(confirm('Ștergi această programare?')) {
            deleteTask(id);
          }
        });
      });

      document.querySelectorAll('.action-edit').forEach(btn => {
        btn.addEventListener('click', function(){
          const id = parseInt(this.getAttribute('data-id'), 10);
          editTaskPopulateForm(id);
        });
      });
    }

    function toggleStatus(id){
      const task = tasks.find(t => t.id === id);
      if(!task) return;
      task.status = (task.status === 'done') ? 'open' : 'done';
      renderTasks();
      // TODO: Aici faci request AJAX / fetch pentru a salva status în DB
    }

    function deleteTask(id){
      tasks = tasks.filter(t => t.id !== id);
      renderTasks();
      // TODO: delete on server
    }

    function editTaskPopulateForm(id){
      const t = tasks.find(x => x.id === id);
      if(!t) return;
      document.getElementById('title').value = t.title;
      document.getElementById('dates').value = t.date;
      document.getElementById('starttime').value = t.start;
      document.getElementById('endtime').value = t.end;
      document.getElementById('notes').value = t.notes;
      // dacă vrei, setează un flag pentru update în submit handler
      editingId = id;
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function deleteTaskFromServer(id){
      // exemplu fetch POST: fetch('delete.php', {...})
    }

    function escapeHtml(unsafe) {
      return unsafe
       .replace(/&/g, "&amp;")
       .replace(/</g, "&lt;")
       .replace(/>/g, "&gt;")
       .replace(/"/g, "&quot;")
       .replace(/'/g, "&#039;");
    }

    // Formular - adăugare / actualizare
    let editingId = null;
    const form = document.getElementById('agendaForm');
    form.addEventListener('submit', function(e){
      // prevenim submitul default ca exemplu (în realitate folosești submit.php)
      e.preventDefault();

      const title = document.getElementById('title').value.trim();
      const date = document.getElementById('dates').value;
      const start = document.getElementById('starttime').value;
      const end = document.getElementById('endtime').value;
      const notes = document.getElementById('notes').value.trim();

      if(!title || !date || !start || !end){
        alert('Completează toate câmpurile obligatorii.');
        return;
      }
      if(end <= start){
        alert('Ora de sfârșit trebuie să fie după ora de începere.');
        return;
      }

      if(editingId){
        // update local
        const t = tasks.find(x => x.id === editingId);
        t.title = title; t.date = date; t.start = start; t.end = end; t.notes = notes;
        editingId = null;
      } else {
        // add new
        const newId = tasks.length ? (Math.max(...tasks.map(x=>x.id))+1) : 1;
        tasks.push({ id: newId, title, date, start, end, notes, status: 'open' });
      }

      // reset form
      form.reset();
      renderTasks();

      // TODO: aici trimiti fetch/POST la submit.php pentru salvare în DB
    });

    document.getElementById('resetForm').addEventListener('click', function(){ 
      form.reset(); editingId = null;
    });

    // initial render
    renderTasks();
  </script>
</body>
</html>
