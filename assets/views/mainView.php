<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Employees</title>
  <link rel="stylesheet" href="assets/styles/style.css">
  <link rel="stylesheet" href="assets/scripts/jquery/jquery-ui.min.css">
  <script src="assets/scripts/jquery/jquery.js"></script>
  <script src="assets/scripts/jquery/jquery-ui.min.js"></script>
</head>
<body>
  <div class="container">
    <div class="search-container">
      <input type="text" name="search" id="search-field" placeholder="type keyword">
      <select id="filter-options">
        <option value="">--Please choose a category--</option>
        <option value="name">Name</option>
        <option value="birthDate">Birth date</option>
        <option value="hireDate">Hire date</option>
        <option value="title">Title</option>
        <option value="department">Department</option>
      </select>
      <button class="search-btn btn">search</button>
    </div>

    <button class="cancel-btn btn">cancel search</button>
    
    <div class="table-container">
      <table id="employeesTable">
        <thead>
          <tr>
            <th>Gender</th>
            <th>Name <span class="ui-icon ui-icon-triangle-1-n arrow-up"></span><span class="ui-icon ui-icon-triangle-1-s arrow-down"></span></th>
            <th>Birth date <span class="ui-icon ui-icon-triangle-1-n arrow-up"></span><span class="ui-icon ui-icon-triangle-1-s arrow-down"></span></th>
            <th>Hire date <span class="ui-icon ui-icon-triangle-1-n arrow-up"></span><span class="ui-icon ui-icon-triangle-1-s arrow-down"></span></th>
            <th>Title <span class="ui-icon ui-icon-triangle-1-n arrow-up"></span><span class="ui-icon ui-icon-triangle-1-s arrow-down"></span></th>
            <th>Department <span class="ui-icon ui-icon-triangle-1-n arrow-up"></span><span class="ui-icon ui-icon-triangle-1-s arrow-down"></span></th>
            <th>Salary</th>
          </tr>
        </thead>
        <tbody class="table-body"></tbody>
      </table>
      <div class="page-navigation">
        <button class="prev-btn btn">prev</button>
        <button class="next-btn btn">next</button>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="assets/scripts/script.js"></script>
</body>
</html>
