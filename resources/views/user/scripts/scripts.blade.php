<script type="text/javascript">
    $(".marital_status").change(function(){       
        if($(this).val()=="Married")
        {    
           $("div.marriage_date").show();
        }
        else
        {
           $("div.marriage_date").hide();
        }
    });   

    $(document).ready(function()
    {
         fetch_academic_data();

         fetch_employment_data();

         fetch_family_data();

         function fetch_academic_data()
         {   
          $.ajax({
           url:"/academics-data",
           dataType:"json",
           success:function(data)
           {
            var html = '';
            html += '<tr>';
            html += '<td contenteditable id="course_name"></td>';
            html += '<td contenteditable id="from"></td>';
            html += '<td contenteditable id="to"></td>';
            html += '<td contenteditable id="university"></td>';
            html += '<td contenteditable id="location"></td>';
            html += '<td contenteditable id="branch"></td>';
            html += '<td contenteditable id="percentage"></td>';
            html += '<td contenteditable id="class_obt"></td>';
            html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Add</button></td></tr>';
            for(var count=0; count < data.length; count++)
            {
            html +='<tr>';
            html +='<td contenteditable class="column_name" data-column_name="course_name" data-id="'+data[count].id+'">'+data[count].course_name+'</td>';
            html +='<td contenteditable class="column_name" data-column_name="from" data-id="'+data[count].id+'">'+data[count].from+'</td>';
            html +='<td contenteditable class="column_name" data-column_name="to" data-id="'+data[count].id+'">'+data[count].to+'</td>';
            html +='<td contenteditable class="column_name" data-column_name="university" data-id="'+data[count].id+'">'+data[count].university+'</td>';
            html +='<td contenteditable class="column_name" data-column_name="location" data-id="'+data[count].id+'">'+data[count].location+'</td>';
            html +='<td contenteditable class="column_name" data-column_name="branch" data-id="'+data[count].id+'">'+data[count].branch+'</td>';
            html +='<td contenteditable class="column_name" data-column_name="percentage" data-id="'+data[count].id+'">'+data[count].percentage+'</td>';
            html +='<td contenteditable class="column_name" data-column_name="class_obt" data-id="'+data[count].id+'">'+data[count].class_obt+'</td>';
            html +='<td><button type="button" class="btn btn-danger btn-xs delete" id="'+data[count].id+'">Delete</button></td></tr>';
            }
            $('tbody').html(html);
           }
          });
         }

         var _token = $('input[name="_token"]').val();

         $(document).on('click', '#add', function(){
          var course_name = $('#course_name').text();
          var from = $('#from').text();
          var to = $('#to').text();
          var university = $('#university').text();
          var location = $('#location').text();
          var branch = $('#branch').text();
          var percentage = $('#percentage').text();
          var class_obt = $('#class_obt').text();

          if(course_name != '' && from != '' && to != '' && university != '' && location != '' && branch != '' && percentage != '' && class_obt != '')
          {
           $.ajax({
            url:"{{ route('add_academic_data') }}",
            method:"POST",
            data:{course_name:course_name, from:from,to:to,university:university,location:location,branch:branch,percentage:percentage,class_obt:class_obt, _token:_token},
            success:function(data)
            {
             $('#message').html(data);
             fetch_academic_data();
            }
           });
          }
          else
          {    
           $('#message').html("<div class='alert alert-danger'>All Fields are required</div>");
          }
         });

         $(document).on('blur', '.column_name', function(){
          var column_name = $(this).data("column_name");
          var column_value = $(this).text();
          var id = $(this).data("id");
          
          if(column_value != '')
          {
           $.ajax({
            url:"{{ route('update_academic_data') }}",
            method:"POST",
            data:{column_name:column_name, column_value:column_value, id:id, _token:_token},
            success:function(data)
            {
             $('#message').html(data);
            }
           })
          }
          else
          {
           $('#message').html("<div class='alert alert-danger'>Enter some value</div>");
          }
         });

         $(document).on('click', '.delete', function(){
          var id = $(this).attr("id");
          if(confirm("Are you sure you want to delete this records?"))
          {
           $.ajax({
            url:"{{ route('delete_academic_data') }}",
            method:"POST",
            data:{id:id, _token:_token},
            success:function(data)
            {
             $('#message').html(data);
             fetch_academic_data();
            }
           });
          }
         });
         

         function fetch_employment_data()
         {   
          $.ajax({
           url:"/employment-data",
           dataType:"json",
           success:function(data)
           {
            var html = '';
            html += '<tr>';
            html += '<td contenteditable id="duration_from"></td>';
            html += '<td contenteditable id="duration_to"></td>';
            html += '<td contenteditable id="duration_month"></td>';
            html += '<td contenteditable id="organization"></td>';
            html += '<td contenteditable id="designation"></td>';
            html += '<td contenteditable id="role"></td>';
            html += '<td contenteditable id="leaving"></td>';
            html += '<td><button type="button" class="btn btn-success btn-xs" id="emp_add">Add</button></td></tr>';
            for(var count=0; count < data.length; count++)
            {
            html +='<tr>';
            html +='<td contenteditable class="employment_name" data-employment_name="duration_from" data-id="'+data[count].id+'">'+data[count].duration_from+'</td>';
            html +='<td contenteditable class="employment_name" data-employment_name="duration_to" data-id="'+data[count].id+'">'+data[count].duration_to+'</td>';
            html +='<td contenteditable class="employment_name" data-employment_name="duration_month" data-id="'+data[count].id+'">'+data[count].duration_month+'</td>';
            html +='<td contenteditable class="employment_name" data-employment_name="organization" data-id="'+data[count].id+'">'+data[count].organization+'</td>';
            html +='<td contenteditable class="employment_name" data-employment_name="designation" data-id="'+data[count].id+'">'+data[count].designation+'</td>';
            html +='<td contenteditable class="employment_name" data-employment_name="role" data-id="'+data[count].id+'">'+data[count].role+'</td>';
            html +='<td contenteditable class="employment_name" data-employment_name="leaving" data-id="'+data[count].id+'">'+data[count].leaving+'</td>';
            html +='<td><button type="button" class="btn btn-danger btn-xs emp_delete" id="'+data[count].id+'">Delete</button></td></tr>';
            }
            $('.employment_table').html(html);
           }
          });
         }

         var _token = $('input[name="_token"]').val();

         $(document).on('click', '#emp_add', function(){
          var duration_from = $('#duration_from').text();
          var duration_to = $('#duration_to').text();
          var duration_month = $('#duration_month').text();
          var organization = $('#organization').text();
          var designation = $('#designation').text();
          var role = $('#role').text();
          var leaving = $('#leaving').text(); 

          if(duration_from != '' && duration_to != '' && duration_month != '' && organization != '' && designation != '' && role != '' && leaving != '')
          {
           $.ajax({
            url:"{{ route('add_employment_data') }}",
            method:"POST",
            data:{duration_from:duration_from, duration_to:duration_to,duration_month:duration_month,organization:organization,designation:designation,role:role,leaving:leaving,_token:_token},
            success:function(data)
            {
             $('#emp_message').html(data);
             fetch_employment_data();
            }
           });
          }
          else
          {    
           $('#emp_message').html("<div class='alert alert-danger'>All Employment Details Fields are required</div>");
          }
         });

         $(document).on('blur', '.employment_name', function(){
          var column_name = $(this).data("employment_name");
          var column_value = $(this).text();
          var id = $(this).data("id");
          
          if(column_value != '')
          {
           $.ajax({
            url:"{{ route('update_employment_data') }}",
            method:"POST",
            data:{column_name:column_name, column_value:column_value, id:id, _token:_token},
            success:function(data)
            {
             $('#emp_message').html(data);
            }
           })
          }
          else
          {
           $('#emp_message').html("<div class='alert alert-danger'>Enter some value</div>");
          }
         });

         $(document).on('click', '.emp_delete', function(){
          var id = $(this).attr("id");
          if(confirm("Are you sure you want to delete this records?"))
          {
           $.ajax({
            url:"{{ route('delete_employment_data') }}",
            method:"POST",
            data:{id:id, _token:_token},
            success:function(data)
            {
             $('#emp_message').html(data);
             fetch_employment_data();
            }
           });
          }
         });


         function fetch_family_data()
         {   
          $.ajax({
           url:"/family-data",
           dataType:"json",
           success:function(data)
           {
            var html = '';
            html += '<tr>';
            html += '<td contenteditable id="relationship"></td>';
            html += '<td contenteditable id="name"></td>';
            html += '<td contenteditable id="age"></td>';
            html += '<td contenteditable id="dependent"></td>';   
            html += '<td><button type="button" class="btn btn-success btn-xs" id="family_add">Add</button></td></tr>';
            for(var count=0; count < data.length; count++)
            {
            html +='<tr>';
            html +='<td contenteditable class="family_name" data-family_name="relationship" data-id="'+data[count].id+'">'+data[count].relationship+'</td>';
            html +='<td contenteditable class="family_name" data-family_name="name" data-id="'+data[count].id+'">'+data[count].name+'</td>';
            html +='<td contenteditable class="family_name" data-family_name="age" data-id="'+data[count].id+'">'+data[count].age+'</td>';
            html +='<td contenteditable class="family_name" data-family_name="dependent" data-id="'+data[count].id+'">'+data[count].dependent+'</td>';  
            html +='<td><button type="button" class="btn btn-danger btn-xs family_delete" id="'+data[count].id+'">Delete</button></td></tr>';
            }
            $('.family_table').html(html);
           }
          });
         }

         var _token = $('input[name="_token"]').val();

         $(document).on('click', '#family_add', function(){
          var relationship = $('#relationship').text();
          var name = $('#name').text();
          var age = $('#age').text();
          var dependent = $('#dependent').text();

          if(relationship != '' && name != '' && age != '' && dependent != '')
          {
           $.ajax({
            url:"{{ route('add_family_data') }}",
            method:"POST",
            data:{relationship:relationship, name:name,age:age,dependent:dependent,_token:_token},
            success:function(data)
            {
             $('#family_message').html(data);
             fetch_family_data();
            }
           });
          }
          else
          {    
           $('#family_message').html("<div class='alert alert-danger'>All Family Details Fields are required</div>");
          }
         });

         $(document).on('blur', '.family_name', function(){
          var column_name = $(this).data("family_name");
          var column_value = $(this).text();
          var id = $(this).data("id");
          
          if(column_value != '')
          {
           $.ajax({
            url:"{{ route('update_family_data') }}",
            method:"POST",
            data:{column_name:column_name, column_value:column_value, id:id, _token:_token},
            success:function(data)
            {
             $('#family_message').html(data);
            }
           })
          }
          else
          {
           $('#family_message').html("<div class='alert alert-danger'>Enter some value</div>");
          }
         });

         $(document).on('click', '.family_delete', function(){
          var id = $(this).attr("id");
          if(confirm("Are you sure you want to delete this records?"))
          {
           $.ajax({
            url:"{{ route('delete_family_data') }}",
            method:"POST",
            data:{id:id, _token:_token},
            success:function(data)
            {
             $('#family_message').html(data);
             fetch_family_data();
            }
           });
          }
         });
    });

</script> 