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
});
