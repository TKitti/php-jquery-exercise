/**
 * when DOM is ready for JavaScript code, table is rendered and prev,next buttons are available
 */
$(document).ready(function() {
  const employeesPerPage = 5;
  let firstEmployeeToShow = 0;

  getEmployeeData(firstEmployeeToShow, employeesPerPage);
  
  /**
   * shows the next amount of employees in the table
   */
  $('.next-btn').click(function(){
    firstEmployeeToShow += employeesPerPage;
    getEmployeeData(firstEmployeeToShow, employeesPerPage);
  });

  /**
   * shows the previous amount of employees in the table
   */
  $('.prev-btn').click(function(){
    firstEmployeeToShow -= employeesPerPage;
    getEmployeeData(firstEmployeeToShow, employeesPerPage);
  });
});

/**
 * gets data about employees from the server
 * 
 * @param {Number} offset  from which employee the data is received
 * @param {Number} limit   number of employees to be received
 */
function getEmployeeData (offset, limit) {
  $.ajax({
    url: `employee?employeesPerPage=${limit}&firstEmployeeToShow=${offset}`,
    type: 'get',
    dataType: 'JSON',
    success: function(response) {
      createTable(response.employees);
      setPaginationAvailability(response.isPrevPage, response.isNextPage);
    }
    /**
     * filter and sort functionalities are available after the client successfully received the data from the server
     */
  }).done(function(){
    const arrowUp = $('.arrow-up');
    const arrowDown = $('.arrow-down');
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

    $(".search-btn").click(filterTable);
    $('.cancel-btn').click(showAllRows);
  });
}

/**
 * renders data in a table format
 * 
 * @param {Object} data  array of data about employees
 */
function createTable (data) {
  $('#employeesTable tbody tr').remove();

  for (let i = 0; i < data.length; i++) {
      let firstName = data[i]['first_name'];
      let lastName = data[i]['last_name'];
      let gender = data[i]['gender'];
      let birthDate = data[i]['birth_date'];
      let hireDate = data[i]['hire_date'];
      let title = data[i]['title'];
      let department = data[i]['dept_name'];
      let salary = data[i]['salary'];
  
      let tr_str = "<tr>" +
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

/**
 * sorts table according to the actual column and order given by the user
 * 
 * @param {Number} index  the position of the column by which the table is sorted in the table
 * @param {Number} order  the way the table is sorted
 */
function sortByCategory(index, order) {
  const tbody = $('.table-body');
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

/**
 * hides rows which does not meet the search criteria
 */
function hideUnmatchedRows() {
  $('.table-body > tr').each(function(){
    let cellText = $(this).find("td").eq(getSelectedOption()).html().toLowerCase();

    if (cellText.indexOf(getSearchedText()) === -1) {
      $(this).hide();
    }
  });
}

/**
 * gets the value of the search input field
 * 
 * @returns the text given by the user
 */
function getSearchedText() {
  return $("#search-field").val().toLowerCase();
}

/**
 * gets the index of the dropdown menu
 * 
 * @returns the position of the selected element in the dropdown menu
 */
function getSelectedOption() {
  return $('#filter-options').find(":selected").index();
}

/**
 * empties the search input field
 */
function clearSearchField() {
  $("#search-field").val('');
}

/**
 * sets the dropdown menu to default
 */
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

function setPaginationAvailability(isPrevPage, isNextPage) {
  $('.next-btn').prop('disabled', !isNextPage);
  $('.prev-btn').prop('disabled', !isPrevPage);
}
