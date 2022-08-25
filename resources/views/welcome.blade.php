<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
     <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('css')}}/style.css">
<meta name="csrf-token" content="{{ csrf_token()}}">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <title>Kanban board</title>
</head>
<body>

    <section class="board">
            <div class="container">
                <div class="from">
                    <input type="text" id="taskname" placeholder="Write Your Task ..." />
                    <button id="tasksubmit"  onclick="addData()"> Add</button>
                </div>
                <div class="container">

                    <div class="row">
                      <div class="col-md-4 ">
                        <div class="todo">
                          <div class="heading">
                            <h2>TO DO</h2>
                          </div>
                            <div class="todtask" id="todotask">
                    
                            </div>
                        </div>

                      </div>
                      <div class="col-md-4">
                        <div class="todo">
                          <div class="heading">
                            <h2> IN Progress</h2>
                          </div>
                            <div class="todtask" id="processtask">
                                {{-- <ul>
                                  <li  data-toggle="modal" data-target="#Progress">Task 1</li>
                                    
                                  <!-- Modal -->
                                  <div class="modal fade" id="Progress" role="dialog">
                                    <div class="modal-dialog">
                                    
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">Modal Header</h4>
                                        </div>
                                        <div class="modal-body">
                                          <p>progress.</p>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                      
                                    </div>
                                  </div>

                                    <li>Task 2</li>
                                </ul> --}}
                            </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="todo">
                          <div class="heading">
                            <h2>Done</h2>
                          </div>
                            <div class="todtask" id="donetask">
                                {{-- <ul>
                                    <li>Task 1</li>
                                    <li>Task 2</li>
                                </ul> --}}
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
    </section>
    <script src="https://code.jquery.com/jquery.js"></script>
    <script>
        $.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

function allData(){
    $.ajax ({
        type:"GET",
        dataType:'json',
        
        url:"/api/get/todo/task",
        success:function(response){
          var data=""
        //   var i = 1
        
           $.each(response,function(key, value)
           {
            data = data + "<ul>"
        
            data = data +'<li  data-toggle="modal" data-target="#Progress'+value.id+'">'+value.name+'</li>'
            // data = data +"<li>"+value.last_name+"</li>"
            // data = data +"<td>"+value.email+"</td>"
            // data =data +"<td>"
            // data = data + "<button class='btn btn-sm btn-primary mr-2' onclick='edit("+value.id+")'>Edit </button>"
            // data = data + "<button class='btn btn-sm btn-danger' onclick='deleteData("+value.id+")'>Delete </button>"
            // data =data +"</td>"

            data=data +' <div class="modal fade" id="Progress'+value.id+'" role="dialog">'
            data=data +' <div class="modal-dialog">'
             data=data +'  <div class="modal-content">'
            data=data +'  <div class="modal-header">'
            data=data +' <button type="button" class="close" data-dismiss="modal">&times;</button>'
            data=data +' <h4 class="modal-title">Task Name:'+' '+' '+ value.name +' </h4>'
            data=data +' </div>'
            data=data +' <div class="modal-body">'
            data=data +' <select id="selectedid'+value.id+'" class="form-select" aria-label="Select Task Status">'
            data=data +' <option selected> select your task status</option>'
            data=data +'   <option value="2">Progress</option>'
            data=data +'   <option value="3">Done</option>'
           data=data +' </select>'

            data=data +'   </div>'
            data=data +' <div class="modal-footer">'
            data=data +' <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>'
            data=data +' <button type="button" class="btn btn-default" data-dismiss="modal" onclick="UpdateData('+value.id+')" >Submit</button>'
            data=data +' </div>'
            data=data +' </div>'
            data=data +' </div>'
            data=data +' </div>'
     
            data = data + "</ul>"

           })
      
           $('#todotask').html(data);
        }
    });

    // process data
    $.ajax ({
        type:"GET",
        dataType:'json',
        
        url:"/api/get/progress/task",
        success:function(response){
          var data=""
        
        
           $.each(response,function(key, value)
           {
            data = data + "<ul>"
        
            data = data +'<li  data-toggle="modal" data-target="#Progress'+value.id+'">'+value.name+'</li>'
            // data = data +"<li>"+value.last_name+"</li>"
            // data = data +"<td>"+value.email+"</td>"
            // data =data +"<td>"
            // data = data + "<button class='btn btn-sm btn-primary mr-2' onclick='edit("+value.id+")'>Edit </button>"
            // data = data + "<button class='btn btn-sm btn-danger' onclick='deleteData("+value.id+")'>Delete </button>"
            // data =data +"</td>"

            data=data +' <div class="modal fade" id="Progress'+value.id+'" role="dialog">'
            data=data +' <div class="modal-dialog">'
             data=data +'  <div class="modal-content">'
            data=data +'  <div class="modal-header">'
            data=data +' <button type="button" class="close" data-dismiss="modal">&times;</button>'
            data=data +' <h4 class="modal-title">Task Name:'+' '+' '+ value.name +' </h4>'
            data=data +' </div>'
            data=data +' <div class="modal-body">'
            data=data +' <select id="selectedid'+value.id+'" class="form-select" aria-label="Select Task Status">'
            data=data +' <option selected>select your task status</option>'
            data=data +'   <option value="1">To do</option>'
            data=data +'   <option value="3">Done</option>'
           data=data +' </select>'

            data=data +'   </div>'
            data=data +' <div class="modal-footer">'
            data=data +' <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>'
            data=data +' <button type="button" class="btn btn-default" data-dismiss="modal" onclick="UpdateData('+value.id+')" >Submit</button>'
            data=data +' </div>'
            data=data +' </div>'
            data=data +' </div>'
            data=data +' </div>'
     
            data = data + "</ul>"

           })
      
           $('#processtask').html(data);
 
           
        }
       
        
    });

// done data
$.ajax ({
        type:"GET",
        dataType:'json',
        
        url:"/api/get/done/task",
        success:function(response){
          var data=""
        //   var i = 1
        
           $.each(response,function(key, value)
           {
            data = data + "<ul>"
        
            data = data +'<li  data-toggle="modal" data-target="#Progress'+value.id+'">'+value.name+'</li>'
            // data = data +"<li>"+value.last_name+"</li>"
            // data = data +"<td>"+value.email+"</td>"
            // data =data +"<td>"
            // data = data + "<button class='btn btn-sm btn-primary mr-2' onclick='edit("+value.id+")'>Edit </button>"
            // data = data + "<button class='btn btn-sm btn-danger' onclick='deleteData("+value.id+")'>Delete </button>"
            // data =data +"</td>"

            data=data +' <div class="modal fade" id="Progress'+value.id+'" role="dialog">'
            data=data +' <div class="modal-dialog">'
             data=data +'  <div class="modal-content">'
            data=data +'  <div class="modal-header">'
            data=data +' <button type="button" class="close" data-dismiss="modal">&times;</button>'
            data=data +' <h4 class="modal-title">Task Name:'+' '+' '+ value.name +' </h4>'
            data=data +' </div>'
            data=data +' <div class="modal-body">'
            data=data +' <select id="selectedid'+value.id+'" class="form-select" aria-label="Select Task Status">'
            data=data +' <option selected>Open this select menu</option>'
            data=data +'   <option value="1">To do</option>'
            // data=data +'   <option value="3">Done</option>'
           data=data +' </select>'

            data=data +'   </div>'
            data=data +' <div class="modal-footer">'
            data=data +' <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>'
            data=data +' <button type="button" class="btn btn-default" data-dismiss="modal" onclick="UpdateData('+value.id+')" >Submit</button>'
            data=data +' </div>'
            data=data +' </div>'
            data=data +' </div>'
            data=data +' </div>'
     
            data = data + "</ul>"

           })
      
           $('#donetask').html(data);
        }
       
        
    });

}
allData();

// add all data
function addData(){
  var taskname = $('#taskname').val();

$.ajax({
  type:"POST",
  dataType:"json",
  data:{taskname:taskname},
  url:"/api/inserttask",
  success:function(data){
    console.log('successfully  data added');
    Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Your Task has been saved',
            showConfirmButton: false,
            timer: 1500
            })
  },
  error:function(error){
   console.log(error.responseJSON.errors.email);
   console.log(error.responseJSON.errors.frist_name);
   console.log(error.responseJSON.errors.last_name);
  }
})
allData();
allClear();

}

function allClear()
{
  $('#taskname').val('');

}

function UpdateData(id) {
    var selectedid = $('#selectedid'+id).val();
    console.log(selectedid);
    console.log(id);

    $.ajax({
    type:"POST",
    dataType:"json",
    data:{status:selectedid},
    url:"/api/update/"+id,
    success:function(data){
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'Your work has been updated',
            showConfirmButton: false,
            timer: 1500
            })
      console.log('data updated');
      allData();
      
    },
    error:function(error){
   console.log(error.responseJSON.errors.status);

  }
  
  })

}


    </script>

</body>
</html>