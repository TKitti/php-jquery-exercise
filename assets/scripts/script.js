//when page loads, show data about employees in a table
var employeesPerPage = 10;
var firstEmployeeToShow = 0;
var totalEmployees;

$(document).ready(function() {
  getEmployeeData(firstEmployeeToShow, employeesPerPage);
  
  $('.next-btn').click(function(){
    firstEmployeeToShow += employeesPerPage;
    if (firstEmployeeToShow <= totalEmployees) {
      getEmployeeData(firstEmployeeToShow, employeesPerPage);
    }
  });

  $('.prev-btn').click(function(){
    firstEmployeeToShow -= employeesPerPage;
    if (firstEmployeeToShow < 0){
      firstEmployeeToShow = 0;
    }
    getEmployeeData(firstEmployeeToShow, employeesPerPage);
  });
});

function getEmployeeData (offset, limit) {
  $.ajax({
    url: `app.php?employeesPerPage=${limit}&firstEmployeeToShow=${offset}`,
    type: 'get',
    dataType: 'JSON',
    success: function(response) {
      createTable(response);
    }
  }).done(function(){
    
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

    $(".search-btn").click(filterTable);
    $('.cancel-btn').click(showAllRows);

    function hideUnmatchedRows() {
      $('.table-body > tr').each(function(){
        var cellText = $(this).find("td").eq(getSelectedOption()).html().toLowerCase();

        if (cellText.indexOf(getSearchedText()) === -1) {
          $(this).hide();
        }
      });
    }

    function getSearchedText() {
      return $("#search-field").val().toLowerCase();
    }

    function getSelectedOption() {
      return $('#filter-options').find(":selected").index() + 1;
    }

    function clearSearchField() {
      $("#search-field").val('');
    }

    function clearDropdownMenu() {
      $('#filter-options').prop('selectedIndex', 0);
    }

    function showAllRows() {
      $('.table-body > tr').show();
    }

    function filterTable() {
      hideUnmatchedRows();
      clearSearchField();
      clearDropdownMenu();
    }
  });
}

function createTable (data, total) {
  $('#employeesTable tbody tr').remove();

  for (var i = 0; i < data.length; i++) {
    if (i == 0) {
      totalEmployees = data[i]['total'];
    } else {
      var firstName = data[i]['first_name'];
      var lastName = data[i]['last_name'];
      var gender = data[i]['gender'];
      var birthDate = data[i]['birth_date'];
      var hireDate = data[i]['hire_date'];
      var title = data[i]['title'];
      var department = data[i]['dept_name'];
      var salary = data[i]['salary'];
  
      var tr_str = "<tr>" +
        "<td>" + gender + "</td>" +
        "<td>" + lastName + ", " + firstName + "</td>" +
        "<td>" + birthDate + "</td>" +
        "<td>" + hireDate + "</td>" +
        "<td>" + title + "</td>" +
        "<td>" + department + "</td>" +
        "<td>" + salary + "</td>" +
        "</tr>";
  
      $('#employeesTable tbody').append(tr_str);
    }
  }
}
