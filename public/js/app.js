$(document).ready(function () {
    

    // Apply functionality for cashdrawer selecting
    $(document).on('click', '.checkbox-toggler', function (e) {

        e.preventDefault();

        var currentBtn = $(this);
        var action = currentBtn.data('action');
        var parent_id = currentBtn.data('id');

        var childrens = $('.child-id-' + parent_id);
        
        if ( action == 'select' ) {
            childrens.attr('checked', 'checked');
        }
        else {
            childrens.attr('checked', false);
        }

    });

    // For testing
    var collection = [];
    var matches = [];

    var timer = 0;
    $(document).on('keyup', '.match_sql_statement', function (e) { 

        var text = $(this).val();
        var inputTable = $('#input_table');

        if (timer) {
            clearTimeout(timer);
        }

        timer = setTimeout(function () {
            
            matches = [...text.matchAll('{[A-Za-z_]*}')];

            // Reset
            var appendString = '';
            inputTable.html('');

            for (var i = 0; i < matches.length; i++ ) {
                appendString += domElement(matches[i], i);
            }

            inputTable.append(appendString);

            $('select').select2({
                theme: 'bootstrap4'
            });

        }, 1000); 

    });

    // A dom element function
    function domElement(label, number)
    {
        var element = '<tr>';
            element += '<td width="50%">';
            element += '<div class="input-field">';
            element += '<label class="active" for="">'+label+'</label>';
            element += '<input type="hidden" name="sql_variables[\'keys\']['+number+']" id="sql_var_key_'+number+'" value="'+label+'" >';
            element += '</div>';
            element += '</td>';
            element += '<td>';
            element += '<select class="sql_variables" name="sql_variables[\'values\']['+number+']" id="sql_var_val_'+number+'">';
            element += '<option value="YD" selected>Yesterday\'s Date</option>';
            element += '<option value="TD">Today\'s Date</option>';
            element += '<option value="TMD">Tomorrow\'s Date</option>';
            element += '</select>';
            element += '</td>';
            element += '</tr>';
        return element;
    }

    // Query Test button
    var modalWindow = $('#query-display');
    $(document).on('click', '.query-test-button', function (e) { 
        
        e.preventDefault();

        var tElement = $(this);
        var targetURL = $(this).attr('href');

        var sqlStatement = $(document).find('#query_statement').val();

        var variables = [];

        if ( $('.sql_variables').length > 0 ) {
            $.each($('.sql_variables'), function (i, item) { 
                variables.push({"key" : $('#sql_var_key_' + i).val(), "value" : $(item).val()});
            });
        }

        // Validate if there is any query
        if (sqlStatement == "") {
            hf_error_toast("Please fill in SQL statement");
            return false;
        }

        console.log(sqlStatement);
        console.log(variables);

        // Initialize
        modalWindow.find('.modal-body').html('Loading...');
        modalWindow.modal('show');

        $.post(targetURL, { statement: sqlStatement, variables: variables }, function (rData) {
            modalWindow.find('.modal-body').html(rData);
        });

    });


    $('.timepicker').datetimepicker({format: 'LT'})

 });
