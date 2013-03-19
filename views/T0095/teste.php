<script>
    $(".date-uk").tableSorter({
            sortColumn: 'name',			// Integer or String of the name of the column to sort by.
            sortClassAsc: 'headerSortUp',		// Class name for ascending sorting action to header
            sortClassDesc: 'headerSortDown',	// Class name for descending sorting action to header
            headerClass: 'header',			// Class name for headers (th's)
            dateFormat: 'dd/mm/yyyy' 		// set date format for non iso dates default us, in this case override and set uk-format
    });
</script>
  
<div class="conteudo_16">
    <h3>Code:</h3>
    <pre>
    &lt;script&gt;
    $(document).ready(function() {
            $("#date-uk").tableSorter({
                    sortColumn: 'name',			// Integer or String of the name of the column to sort by.
                    sortClassAsc: 'headerSortUp',		// Class name for ascending sorting action to header
                    sortClassDesc: 'headerSortDown',	// Class name for descending sorting action to header
                    headerClass: 'header',			// Class name for headers (th's)
                    dateFormat: 'dd/mm/yyyy' 		// set date format for non iso dates default us, in this case override and set uk-format
            });
    });
    &lt;/script&gt;
    </pre>

    <h3>Demo:</h3>	
    <table class="tablesorter tDados" border="0" cellpadding="0" cellspacing="0">
            <thead>
                    <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Total purchase</th>
                            <th>UK Short Date</th>
                            <th>US Long Date</th>
                    </tr>
            </thead>
            <tbody>
                    <tr>
                            <td>Peter</td>
                            <td>28</td>
                            <td>$9.99</td>
                            <td>12/01/2001</td>
                            <td>Jul 6, 2006 8:14 AM</td>
                    </tr>
                    <tr>
                            <td>John</td>
                            <td>32</td>
                            <td>$19.99</td>
                            <td>12/10/2001</td>
                            <td>Dec 10, 2002 5:14 AM</td>
                    </tr>
                    <tr>
                            <td>Clark</td>
                            <td>18</td>
                            <td>$15.89</td>
                            <td>21/04/1962</td>
                            <td>Jan 12, 2003 11:14 AM</td>
                    </tr>
                    <tr>
                            <td>Clark</td>
                            <td>18</td>
                            <td>$15.89</td>
                            <td>28/02/2007</td>
                            <td>Jan 12, 2003 11:14 AM</td>
                    </tr>
                    <tr>
                            <td>Clark</td>
                            <td>18</td>
                            <td>$15.89</td>
                            <td>05/05/2005</td>
                            <td>Jan 12, 2003 11:14 AM</td>
                    </tr>
                    <tr>
                            <td>Clark</td>
                            <td>18</td>
                            <td>$15.89</td>
                            <td>30/09/2012</td>
                            <td>Jan 12, 2003 11:14 AM</td>
                    </tr>
                    <tr>
                            <td>Clark</td>
                            <td>18</td>
                            <td>$15.89</td>
                            <td>12/01/2001</td>
                            <td>Jan 12, 2003 11:14 AM</td>
                    </tr>
            </tbody>
    </table>
</div>