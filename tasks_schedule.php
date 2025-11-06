
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
            $id   = isset($_GET['id']) ? intval($_GET['id']) : 0;
$task = null;

            // Verificare conexiune
            if ($conn->connect_error) {
                die("Conexiune eșuată: " . $conn->connect_error);
            }
            
            // Extragere sarcini din baza de date
            $sql = "SELECT * FROM tasks ORDER BY dates, starttime";
            $result = $conn->query($sql);
            
            $hasRows = false;
            if ($result && $result->num_rows > 0) {
                $hasRows = true;
                $i = 1;
                while($row = $result->fetch_assoc()) {
                    // sanitize output and avoid clobbering the GET $id
                    $rowId = (int)$row['id'];
                    $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                    $date = htmlspecialchars($row['dates'], ENT_QUOTES, 'UTF-8');
                    $start = htmlspecialchars($row['starttime'], ENT_QUOTES, 'UTF-8');
                    $end = htmlspecialchars($row['endtime'], ENT_QUOTES, 'UTF-8');
                    $notes = htmlspecialchars($row['notes'], ENT_QUOTES, 'UTF-8');
                    $status = htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8');

                    echo "<tr>";
                    echo "<td>{$i}</td>";
                    echo "<td>{$title}</td>";
                    echo "<td>{$date}</td>";
                    echo "<td>{$start} - {$end}</td>";
                    echo "<td>{$notes}</td>";
                    echo "<td>";
                    if (strtolower($status) === 'done') {
                        echo '<span class="badge-done">Finalizat</span>';
                    } else {
                        echo '<span class="badge-open">Deschis</span>';
                    }
                    
                    echo "</td>";
                    echo "<td>";
                    echo '<button class="action-btn action-toggle" data-id="' . $rowId . '">Toggle</button>';
                    echo '<a href="edit.php?id='.$rowId.'" class="btn btn-sm btn-info">Editează</a>';
                    echo '<button class="action-btn action-delete">Delete</button>';
                    echo "</td>";
                    echo "</tr>";

                    $i++;
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
    <script>
    document.querySelectorAll('.action-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.dataset.id;
            const btn = this;

            fetch('toggle_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + taskId
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    // Actualizează statusul și textul butonului
                    const taskDiv = document.getElementById('task-' + taskId);
                    taskDiv.querySelector('.status').textContent = data.new_status;
                    btn.textContent = (data.new_status === 'finalizat') ? 'Marchează În Curs' : 'Marchează Finalizat';
                } else {
                    alert(data.message);
                }
            })
            .catch(err => console.error(err));
        });
    });
    </script>


<!-- Bootstrap 4 JS dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>