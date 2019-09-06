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
          "<td>" + (i+1) + "</td>" +
          "<td>" + lastName + ", " + firstName + "</td>" +
          "<td>" + gender + "</td>" +
          "<td>" + birthDate + "</td>" +
          "<td>" + hireDate + "</td>" +
          "<td>" + title + "</td>" +
          "<td>" + department + "</td>" +
          "<td>" + salary + "</td>" +
          "</tr>";

        $('#employeesTable tbody').append(tr_str);
      }
    }
  });

  var arrowUp = $('.arrow-up');
  var arrowDown = $('.arrow-down');
  arrowDown.hide();

  arrowUp.click(function() {
    const headerIndex = $(this).parent().index();
    sortByCategory(headerIndex, 'desc');
    arrowUp.hide();
    arrowDown.show();
  });

  arrowDown.click(function() {
    const headerIndex = $(this).parent().index();
    sortByCategory(headerIndex, 'asc');
    arrowUp.show();
    arrowDown.hide();
  });

  function sortByCategory(index, order) {
    var tbody = $('.table-body');

    tbody
      .find('tr')
      .sort(function(a, b) {
        if (order === 'asc') {
          return $(`td:eq(${index})`, a).text().localeCompare($(`td:eq(${index})`, b).text());
        } else {
          return $(`td:eq(${index})`, b).text().localeCompare($(`td:eq(${index})`, a).text());
        }
      })
      .appendTo(tbody);
  }
});
