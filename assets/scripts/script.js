//when page loads, show data about employees in a table
$(document).ready(function() {
  $.ajax({
    url: 'app.php',
    type: 'get',
    dataType: 'JSON',
    success: function(response) {
      for (var i = 0; i < response.length; i++) {
        var firstName = response[i]['first_name'];
        var lastName = response[i]['last_name'];
        var gender = response[i]['gender'];
        var birthDate = response[i]['birth_date'];
        var hireDate = response[i]['hire_date'];
        var title = response[i]['title'];
        var department = response[i]['dept_name'];
        var salary = response[i]['salary'];

        var tr_str = "<tr>" +
          "<td align='center'>" + (i+1) + "</td>" +
          "<td align='center'>" + lastName + ", " + firstName + "</td>" +
          "<td align='center'>" + gender + "</td>" +
          "<td align='center'>" + birthDate + "</td>" +
          "<td align='center'>" + hireDate + "</td>" +
          "<td align='center'>" + title + "</td>" +
          "<td align='center'>" + department + "</td>" +
          "<td align='center'>" + salary + "</td>" +
          "</tr>";

        $('#employeesTable tbody').append(tr_str);
      }
    }
  });
});
